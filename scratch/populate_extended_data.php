<?php
require_once 'includes/config.php';

try {
    // Populate some realistic-looking data based on categories
    $pdo->exec("UPDATE recipes SET fiber = 2.5, vitamin_c = 15, calcium = 50, iron = 1.2 WHERE category = 'Breakfast'");
    $pdo->exec("UPDATE recipes SET fiber = 5.0, vitamin_a = 200, potassium = 400, sodium = 300 WHERE category = 'Lunch'");
    $pdo->exec("UPDATE recipes SET fiber = 4.0, vitamin_a = 150, potassium = 350, sodium = 400 WHERE category = 'Dinner'");
    $pdo->exec("UPDATE recipes SET fiber = 1.5, vitamin_c = 5, sodium = 250 WHERE category = 'Snacks'");
    $pdo->exec("UPDATE recipes SET fiber = 1.0, sodium = 600, calcium = 30 WHERE category = 'Fastfood'");
    $pdo->exec("UPDATE recipes SET vitamin_c = 10, sodium = 500 WHERE category = 'Chat items'");
    $pdo->exec("UPDATE recipes SET vitamin_c = 45, potassium = 200 WHERE category = 'Juice items'");

    echo "Successfully updated recipes with extended nutritional data!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
