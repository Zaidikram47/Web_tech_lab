<?php
/**
 * Database Configuration & Initialization
 * EduPortal Management System
 */

// Localhost XAMPP Defaults
define('DB_HOST', 'localhost');
define('DB_NAME', 'eduportal_db');
define('DB_USER', 'root'); // Swapped to default XAMPP user to prevent local connection errors
define('DB_PASS', '');     // Swapped to default empty XAMPP password

class DatabaseHelper
{
    private static $connection = null;

    public static function connect()
    {
        // Return existing connection if already initialized
        if (self::$connection !== null) {
            return self::$connection;
        }

        $pdoOptions = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            // 1. Connect to the MySQL server (without specifying a database yet)
            $dsn = 'mysql:host=' . DB_HOST . ';charset=utf8mb4';
            self::$connection = new PDO($dsn, DB_USER, DB_PASS, $pdoOptions);

            // 2. Safely create the database if it's the first time running
            self::$connection->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // 3. Switch to the newly verified database
            self::$connection->exec("USE `" . DB_NAME . "`");

            // 4. Initialize the required tables
            self::initializeSchema();

            return self::$connection;

        } catch (PDOException $error) {
            // Clean error handling that hides sensitive stack traces from users
            http_response_code(500);
            die("<div style='padding: 20px; background: #fee2e2; color: #991b1b; border-radius: 8px; font-family: sans-serif;'>
                    <strong>Database Connection Error:</strong><br> " . htmlspecialchars($error->getMessage()) . "
                 </div>");
        }
    }

    private static function initializeSchema()
    {
        $tableQuery = "
            CREATE TABLE IF NOT EXISTS `students` (
                `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `first_name` VARCHAR(100) NOT NULL,
                `last_name` VARCHAR(100) NOT NULL,
                `email` VARCHAR(150) NOT NULL UNIQUE,
                `dob` DATE DEFAULT NULL,
                `course` VARCHAR(150) DEFAULT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ";

        self::$connection->exec($tableQuery);
    }
}

// Global wrapper function to keep it perfectly compatible with your index.php and create.php files
function getPDO()
{
    return DatabaseHelper::connect();
}
?>