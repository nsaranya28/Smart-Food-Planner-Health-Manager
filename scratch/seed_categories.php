<?php
require_once 'includes/config.php';

try {
    // Clear existing recipes
    $pdo->exec("DELETE FROM recipes");

    $recipes = [
        ['name' => 'Masala Dosa', 'time' => 20, 'cal' => 350, 'prot' => 8, 'carb' => 50, 'fat' => 12, 'cat' => 'Breakfast', 'img' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=400&fit=crop'],
        ['name' => 'Idli Sambar', 'time' => 15, 'cal' => 250, 'prot' => 10, 'carb' => 45, 'fat' => 2, 'cat' => 'Breakfast', 'img' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=400&fit=crop'],
        ['name' => 'South Indian Meals', 'time' => 30, 'cal' => 800, 'prot' => 25, 'carb' => 120, 'fat' => 30, 'cat' => 'Lunch', 'img' => 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400&fit=crop'],
        ['name' => 'Curd Rice', 'time' => 5, 'cal' => 300, 'prot' => 6, 'carb' => 55, 'fat' => 8, 'cat' => 'Lunch', 'img' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&fit=crop'],
        ['name' => 'Roti & Dal', 'time' => 25, 'cal' => 450, 'prot' => 15, 'carb' => 60, 'fat' => 10, 'cat' => 'Dinner', 'img' => 'https://images.unsplash.com/photo-1585937421612-70a008356fbe?w=400&fit=crop'],
        ['name' => 'Mixed Veg Curry', 'time' => 20, 'cal' => 280, 'prot' => 8, 'carb' => 35, 'fat' => 15, 'cat' => 'Dinner', 'img' => 'https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=400&fit=crop'],
        ['name' => 'Roasted Peanuts', 'time' => 5, 'cal' => 160, 'prot' => 7, 'carb' => 6, 'fat' => 14, 'cat' => 'Snacks', 'img' => 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?w=400&fit=crop'],
        ['name' => 'Spicy Corn', 'time' => 10, 'cal' => 120, 'prot' => 3, 'carb' => 25, 'fat' => 2, 'cat' => 'Snacks', 'img' => 'https://images.unsplash.com/photo-1551754655-cd27e38d2076?w=400&fit=crop'],
        ['name' => 'Veg Burger', 'time' => 15, 'cal' => 450, 'prot' => 12, 'carb' => 55, 'fat' => 20, 'cat' => 'Fastfood', 'img' => 'https://images.unsplash.com/photo-1550547660-d9450f859349?w=400&fit=crop'],
        ['name' => 'Pani Puri', 'time' => 10, 'cal' => 200, 'prot' => 4, 'carb' => 35, 'fat' => 6, 'cat' => 'Chat items', 'img' => 'https://images.unsplash.com/photo-1589301760014-d929f3979dbc?w=400&fit=crop'],
        ['name' => 'Samosa Chat', 'time' => 10, 'cal' => 320, 'prot' => 6, 'carb' => 40, 'fat' => 15, 'cat' => 'Chat items', 'img' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=400&fit=crop'],
        ['name' => 'Fresh Orange Juice', 'time' => 5, 'cal' => 110, 'prot' => 2, 'carb' => 26, 'fat' => 0, 'cat' => 'Juice items', 'img' => 'https://images.unsplash.com/photo-1613478223719-2ab802602423?w=400&fit=crop'],
        ['name' => 'Watermelon Juice', 'time' => 5, 'cal' => 90, 'prot' => 1, 'carb' => 22, 'fat' => 0, 'cat' => 'Juice items', 'img' => 'https://images.unsplash.com/photo-1589733901241-5e391270dd91?w=400&fit=crop']
    ];

    $stmt = $pdo->prepare("INSERT INTO recipes (name, cooking_time, calories, protein, carbs, fat, category, image, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($recipes as $r) {
        $stmt->execute([$r['name'], $r['time'], $r['cal'], $r['prot'], $r['carb'], $r['fat'], $r['cat'], $r['img'], 'Mix and serve.']);
    }

    echo "Successfully seeded " . count($recipes) . " categorized recipes!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
