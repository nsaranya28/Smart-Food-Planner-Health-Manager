<?php
require_once 'includes/config.php';

try {
    // Check if column exists
    $check = $pdo->query("SHOW COLUMNS FROM recipes LIKE 'category'");
    if ($check->rowCount() == 0) {
        $pdo->exec("ALTER TABLE recipes ADD COLUMN category VARCHAR(50) DEFAULT 'Uncategorized'");
        echo "Column 'category' added successfully.<br>";
    } else {
        echo "Column 'category' already exists.<br>";
    }
    
    // Update existing sample data
    $pdo->exec("UPDATE recipes SET category = 'Breakfast' WHERE name LIKE '%Smoothie%' OR name LIKE '%Oat%'");
    $pdo->exec("UPDATE recipes SET category = 'Lunch' WHERE name LIKE '%Salad%'");
    $pdo->exec("UPDATE recipes SET category = 'Dinner' WHERE name LIKE '%Chicken%' OR name LIKE '%Steak%'");
    
    echo "Migration completed successfully.";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>
