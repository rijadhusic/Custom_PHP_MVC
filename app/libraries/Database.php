<?php
/*
 * PDO Database Class
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $password = DB_PASSWORD;
    private $dbname = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;
    private $errorMode;

    public function __construct($errorMode = null) {
        $this->errorMode = $errorMode ?? PDO_ERROR_MODE;
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => $this->errorMode
        ];
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Database connection error: " . $this->error);
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
        
    }
    
    // Fetch all rows from the result set
    public function fetchAll() {
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Fetch a single row by ID
    public function fetchById($table, $id) {
        $sql = "SELECT * FROM $table WHERE id = :id";
        $this->query($sql, ['id' => $id]);
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Insert a new record into the specified table
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $this->query($sql, $data);
    }

    // Update a record in the specified table
    public function update($table, $id, $data) {
        $set = '';
        foreach ($data as $column => $value) {
            $set .= "$column = :$column, ";
        }
        $set = rtrim($set, ', ');
        $sql = "UPDATE $table SET $set WHERE id = :id";
        $data['id'] = $id;
        $this->query($sql, $data);
    }
    
    // Delete a record from the specified table
    public function delete($table, $id) {
        $sql = "DELETE FROM $table WHERE id = :id";
        $this->query($sql, ['id' => $id]);
    }
    
    // Count the number of records in the specified table
    public function countRows($table) {
        $sql = "SELECT COUNT(*) FROM $table";
        $this->query($sql);
        return $this->stmt->fetchColumn();
    }

    // Execute a prepared query and fetch a single row
    public function fetchOne($sql, $params = []) {
        $this->query($sql, $params);
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Execute a prepared query and fetch a single column
    public function fetchColumn($sql, $params = [], $columnIndex = 0) {
        $this->query($sql, $params);
        return $this->stmt->fetchColumn($columnIndex);
    }
    
    // Execute a prepared query and fetch a specific column from all rows
    public function fetchColumnAll($sql, $params = [], $columnIndex = 0) {
        $this->query($sql, $params);
        return $this->stmt->fetchAll(PDO::FETCH_COLUMN, $columnIndex);
    }
    
    // Check if a record exists based on a condition
    public function exists($table, $condition, $params = []) {
        $sql = "SELECT EXISTS(SELECT 1 FROM $table WHERE $condition LIMIT 1)";
        $this->query($sql, $params);
        return $this->stmt->fetchColumn() == 1;
    }

        // Execute a prepared query
        public function query($sql, $params = []) {
            $this->stmt = $this->dbh->prepare($sql);
            $this->stmt->execute($params);
        }
    
        // Build the parameters
        public function bind($param, $value, $type = null) {
            if (is_null($type)) {
                if (is_int($value)) {
                    $type = PDO::PARAM_INT;
                } elseif (is_bool($value)) {
                    $type = PDO::PARAM_BOOL;
                } elseif (is_null($value)) {
                    $type = PDO::PARAM_NULL;
                } else {
                    $type = PDO::PARAM_STR;
                }
            }
        
            $this->stmt->bindValue($param, $value, $type);
        }
        
    
    // Execute a raw SQL statement
    public function execute($sql, $params = []) {
        $this->query($sql, $params);
    }
    
    // Begin a transaction
    public function beginTransaction() {
        return $this->dbh->beginTransaction();
    }
    
    // Commit a transaction
    public function commit() {
        return $this->dbh->commit();
    }
    
    // Rollback a transaction
    public function rollback() {
        return $this->dbh->rollBack();
    }
    
}