<?php
require_once 'includes/config.php';

try {
    $sql = "CREATE TABLE IF NOT EXISTS daily_intake (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        recipe_id INT NULL,
        food_name VARCHAR(255) NOT NULL,
        calories INT NOT NULL,
        protein DECIMAL(5,2),
        carbs DECIMAL(5,2),
        fat DECIMAL(5,2),
        log_date DATE DEFAULT (CURRENT_DATE),
        log_time TIME DEFAULT (CURRENT_TIME),
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (recipe_id) REFERENCES recipes(id) ON DELETE SET NULL
    )";
    $pdo->exec($sql);
    echo "Table 'daily_intake' created successfully.";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>
