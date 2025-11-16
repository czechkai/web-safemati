<?php
/**
 * SafeMati Database Connection File
 *
 * This file contains the necessary configuration constants to connect
 * to the MySQL database hosted on WampServer.
 *
 * Credentials:
 * - DB_SERVER: localhost (WampServer default)
 * - DB_USERNAME: root (WampServer default)
 * - DB_PASSWORD: (blank/empty string) (WampServer default)
 * - DB_NAME: safemati_db (The database we just created)
 */

// Define database connection parameters
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', ''); // Default WampServer password is an empty string
define('DB_NAME', 'safemati_db');

// Attempt to establish a MySQLi connection
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection status
if ($conn === false) {
    // Stop execution and display a detailed error message if connection fails
    die("ERROR: Could not connect to the database. " . $conn->connect_error);
}

// Optional: Set character set to UTF8 for proper handling of special characters
// This ensures consistency between PHP and the database.
$conn->set_charset('utf8mb4');

// The $conn variable is now ready to be used in other files.

?>