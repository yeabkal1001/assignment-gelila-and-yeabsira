<?php
/**
 * Database Configuration
 *
 * This file contains the database connection settings for the Velora Hotel website.
 */

// Database credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'velora_user');
define('DB_PASS', 'velora_password');
define('DB_NAME', 'velora_hotel');

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to ensure proper handling of special characters
$conn->set_charset("utf8mb4");

/**
 * Helper function to execute queries and handle errors
 *
 * @param string $sql SQL query to execute
 * @param array $params Parameters to bind to the query
 * @param string $types Types of the parameters (i: integer, s: string, d: double, b: blob)
 * @return mysqli_stmt|false Returns the statement object or false on failure
 */
function executeQuery($sql, $params = [], $types = '') {
    global $conn;

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        error_log("Query preparation failed: " . $conn->error);
        return false;
    }

    if (!empty($params)) {
        if (empty($types)) {
            // Auto-determine types if not provided
            $types = str_repeat('s', count($params));
        }

        $stmt->bind_param($types, ...$params);
    }

    if (!$stmt->execute()) {
        error_log("Query execution failed: " . $stmt->error);
        return false;
    }

    return $stmt;
}
