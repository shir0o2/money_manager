<?php
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'moneymanager');

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Create database connection
try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", 
        DB_USER, 
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Basic functions
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit;
}