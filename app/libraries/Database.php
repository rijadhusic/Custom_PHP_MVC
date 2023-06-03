<?php

class Database {
    private $host = DB_HOST;
    private $username = DB_USER;
    private $password = DB_PASSWORD;
    private $dbname = DB_NAME;

    private $connection;
    private $statement;

    public function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname;charset=utf8mb4";

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $params = []) {
        $this->statement = $this->connection->prepare($sql);
        $this->bindValues($params);
        $this->statement->execute();
        return $this;
    }

    public function select($table, $columns = '*', $conditions = [], $params = []) {
        $sql = "SELECT $columns FROM $table";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        return $this->query($sql, $params)->fetchAll();
    }

    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        return $this->query($sql, $data)->getLastInsertId();
    }

    public function update($table, $data, $conditions = [], $params = []) {
        $set = implode(', ', array_map(fn($column) => "$column = :$column", array_keys($data)));
        $sql = "UPDATE $table SET $set";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $params = array_merge($data, $params);

        return $this->query($sql, $params)->getAffectedRowCount();
    }

    public function delete($table, $conditions = [], $params = []) {
        $sql = "DELETE FROM $table";

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        return $this->query($sql, $params)->getAffectedRowCount();
    }

    public function fetchAll() {
        return $this->statement->fetchAll();
    }

    public function fetch() {
        return $this->statement->fetch();
    }

    public function getLastInsertId() {
        return $this->connection->lastInsertId();
    }

    public function getAffectedRowCount() {
        return $this->statement->rowCount();
    }

    private function bindValues($params) {
        foreach ($params as $param => $value) {
            $this->statement->bindValue($param, $value);
        }
    }

    // Get a single result as an object
    public function single() {
        $this->statement->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

}