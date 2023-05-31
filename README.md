# Custom PHP MVC Framework

This is a custom PHP MVC (Model-View-Controller) framework that provides a structured approach to building web applications. It follows the MVC architectural pattern to separate concerns and promote code organization.

## Project Structure

The project structure is organized as follows:

- `app/config`: Contains configuration files for the application.
- `app/controllers`: Contains the controller classes responsible for handling requests and coordinating the flow of data.
- `app/helpers`: Contains helper functions or utility classes that provide common functionality across the application.
- `app/libraries`: Contains additional libraries or classes used by the framework or the application.
- `app/models`: Contains the model classes that interact with the database or handle data manipulation.
- `app/views`: Contains the view files responsible for rendering HTML templates and displaying data to the user.
- `public/css`: Contains CSS files for styling the application.
- `public/img`: Contains image files used in the application.
- `public/js`: Contains JavaScript files for client-side interactivity.
- `public/index.php`: The entry point of the application.
- `.htaccess`: Handles routing and serves files from the `public` directory.

## Getting Started

To get started with the framework, follow these steps:

1. Clone the repository to your local machine.
2. Configure your web server to point to the project root directory.
3. Update the necessary configurations in the `app/config` files according to your environment and preferences.
4. Create a new MySQL database and update the database configuration in `app/config/config.php`.
5. Update the base URL in the .htaccess file located in the public directory. Open the .htaccess file and modify the RewriteBase directive to match the base URL of your application. For example, if your application is accessible at http://localhost/rijadmvc/public, set RewriteBase /rijadmvc/public.
6. Start building your application by creating controllers, models, and views in their respective directories.
7. Access your application by visiting the configured domain or localhost in your web browser.

## Dependencies

The custom PHP MVC framework does not have any external dependencies. It is designed to be lightweight and self-contained.

## Usage Examples

### Database Interaction

The framework includes a `Database` class (`libraries/Database.php`) that provides a PDO-based database connection and various methods to interact with the database.

To use the `Database` class, you can create an instance of it and then call its methods as needed. Here are a few examples:

```php
<?php

// Create a new instance of the Database class
$db = new Database();

// Example 1: Fetch rows using parameter binding
$name = 'John Doe';
$sql = "SELECT * FROM users WHERE name = :name";
$db->query($sql);
$db->bind(':name', $name);
$users = $db->fetchAll();

// Example 2: Fetch a single row by ID
$id = 1;
$user = $db->fetchById('users', $id);

// Example 3: Insert a new record
$data = [
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'password123'
];
$db->insert('users', $data);

// Example 4: Update a record
$id = 1;
$data = [
    'name' => 'Updated Name',
    'email' => 'updated@example.com'
];
$db->update('users', $id, $data);

// Example 5: Delete a record
$id = 1;
$db->delete('users', $id);

// Example 6: Count the number of records
$table = 'users';
$count = $db->countRows($table);

// Example 7: Execute a raw SQL statement
$sql = "UPDATE users SET name = 'New Name' WHERE id = :id";
$params = ['id' => 1];
$db->execute($sql, $params);

// Example 8: Begin a transaction
$db->beginTransaction();
try {
    // Perform database operations within the transaction
    // ...
    
    // Commit the transaction
    $db->commit();
} catch (Exception $e) {
    // Handle any errors and rollback the transaction if necessary
    $db->rollback();
    echo "Transaction failed: " . $e->getMessage();
}
```
Feel free to customize and expand the Database class to suit your specific needs.

## Dependencies

The custom PHP MVC framework does not have any external dependencies. It is designed to be lightweight and self-contained.

## Contributing

Contributions to the framework are welcome! If you find any issues or have suggestions for improvements, please submit an issue or create a pull request.

## License

This project is licensed under the [MIT License](LICENSE).
