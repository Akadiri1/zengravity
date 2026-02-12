<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=zengravity_db;port=3306', 'root', '');
    echo "Connected successfully to zengravity_db\n";
    
    // Check tables
    $stmt = $pdo->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo "Table: " . $row[0] . "\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
