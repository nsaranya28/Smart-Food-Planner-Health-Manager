<?php
/**
 * Database Configuration
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'pass');
define('DB_NAME', 'food_planner');

// Create connection
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    // If database doesn't exist, we might need to handle it or just fail
    // For now, let's just die with error
    die("Connection failed: " . $e->getMessage());
}

// Session start for auth
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Global constants
define('SITE_NAME', 'Smart Food Planner');
define('BASE_URL', 'http://localhost/food/');
?>
