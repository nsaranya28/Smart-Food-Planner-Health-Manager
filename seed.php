<?php
require_once 'includes/config.php';

echo "Seeding database...<br>";

try {
    // 1. Clear existing data (Optional, be careful)
    // $pdo->exec("SET FOREIGN_KEY_CHECKS = 0; TRUNCATE recipes; TRUNCATE ingredients; SET FOREIGN_KEY_CHECKS = 1;");

    // 2. Insert Recipes
    $recipes = [
        [
            'name' => 'Quinoa Avocado Salad',
            'time' => 15,
            'cal' => 450,
            'prot' => 12.5,
            'carb' => 45.0,
            'fat' => 22.0,
            'img' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400&h=300&fit=crop',
            'inst' => '1. Rinse quinoa. 2. Boil with water for 15 mins. 3. Dice avocado and mix with lemon juice. 4. Combine and serve.'
        ],
        [
            'name' => 'Grilled Chicken Breast',
            'time' => 25,
            'cal' => 350,
            'prot' => 40.0,
            'carb' => 5.0,
            'fat' => 10.0,
            'img' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=400&h=300&fit=crop',
            'inst' => '1. Season chicken with salt and pepper. 2. Grill for 10-12 mins each side. 3. Serve with steamed broccoli.'
        ],
        [
            'name' => 'Berry Smoothie Bowl',
            'time' => 10,
            'cal' => 300,
            'prot' => 15.0,
            'carb' => 40.0,
            'fat' => 5.0,
            'img' => 'https://images.unsplash.com/photo-1590301157890-4810ed352733?w=400&h=300&fit=crop',
            'inst' => '1. Blend frozen berries with yogurt. 2. Pour into bowl. 3. Top with granola and chia seeds.'
        ]
    ];

    $stmt = $pdo->prepare("INSERT INTO recipes (name, cooking_time, calories, protein, carbs, fat, image, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($recipes as $r) {
        $stmt->execute([$r['name'], $r['time'], $r['cal'], $r['prot'], $r['carb'], $r['fat'], $r['img'], $r['inst']]);
    }

    echo "Successfully seeded " . count($recipes) . " recipes!<br>";
    echo "<a href='index.php'>Go to Home</a>";

} catch (PDOException $e) {
    die("Seeding failed: " . $e->getMessage());
}
?>
