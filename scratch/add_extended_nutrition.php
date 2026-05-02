<?php
require_once 'includes/config.php';

try {
    $columns = [
        'fiber' => 'DECIMAL(5,2) DEFAULT 0',
        'vitamin_a' => 'DECIMAL(8,2) DEFAULT 0',
        'vitamin_c' => 'DECIMAL(8,2) DEFAULT 0',
        'vitamin_d' => 'DECIMAL(8,2) DEFAULT 0',
        'calcium' => 'DECIMAL(8,2) DEFAULT 0',
        'iron' => 'DECIMAL(8,2) DEFAULT 0',
        'potassium' => 'DECIMAL(8,2) DEFAULT 0',
        'sodium' => 'DECIMAL(8,2) DEFAULT 0'
    ];

    $existingColumns = $pdo->query("SHOW COLUMNS FROM recipes")->fetchAll(PDO::FETCH_COLUMN);

    foreach ($columns as $col => $type) {
        if (!in_array($col, $existingColumns)) {
            $pdo->exec("ALTER TABLE recipes ADD COLUMN $col $type");
            echo "Added $col<br>";
        }
    }

    echo "Migration completed.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
