<?php
// database_fix.php - Temporary script to fix MySQL permissions

$host = 'localhost';
$user = 'root';
$pass = ''; // Try empty first, as Ubuntu root uses auth_socket

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    echo "Connected to MySQL successfully!\n";
    
    $password = 'Mahsum.2121+';
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS byoo");
    echo "Database 'byoo' checked/created.\n";
    
    // Create user or update root
    $pdo->exec("ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '$password'");
    echo "Root user updated with native password.\n";
    
    $pdo->exec("FLUSH PRIVILEGES");
    echo "Privileges flushed.\n";
    
    echo "MySQL configuration completed successfully!\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
