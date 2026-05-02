<?php
require_once 'includes/config.php';

try {
    $foodItems = [
        ['Appam', 'Breakfast', 200, 4, 35, 5],
        ['Aloo Paratha', 'Breakfast', 300, 6, 45, 12],
        ['Adai', 'Breakfast', 250, 10, 40, 6],
        ['Avocado Toast', 'Breakfast', 250, 5, 25, 15],
        ['Bread Omelette', 'Breakfast', 350, 15, 30, 18],
        ['Bread Butter', 'Breakfast', 200, 3, 25, 10],
        ['Bagel', 'Breakfast', 250, 8, 45, 2],
        ['Banana Smoothie', 'Breakfast', 300, 8, 60, 4],
        ['Cornflakes', 'Breakfast', 200, 5, 45, 1],
        ['Cheese Sandwich', 'Breakfast', 400, 15, 35, 22],
        ['Croissant', 'Breakfast', 350, 5, 40, 20],
        ['Coffee', 'Juice items', 50, 1, 5, 2],
        ['Dosa', 'Breakfast', 150, 3, 30, 4],
        ['Dhokla', 'Breakfast', 150, 5, 25, 4],
        ['Donuts', 'Snacks', 300, 3, 40, 15],
        ['Dates Milkshake', 'Juice items', 350, 8, 70, 6],
        ['Egg Omelette', 'Breakfast', 200, 14, 2, 16],
        ['Egg Sandwich', 'Breakfast', 350, 18, 30, 15],
        ['Egg Bhurji', 'Breakfast', 250, 15, 5, 18],
        ['Boiled Eggs', 'Breakfast', 150, 12, 1, 10],
        ['French Toast', 'Breakfast', 400, 10, 45, 18],
        ['Fruit Salad', 'Lunch', 150, 2, 35, 0],
        ['Filter Coffee', 'Juice items', 70, 2, 8, 3],
        ['Fruit Juice', 'Juice items', 120, 1, 30, 0],
        ['Grilled Sandwich', 'Snacks', 350, 10, 40, 15],
        ['Granola', 'Breakfast', 300, 8, 45, 12],
        ['Green Tea', 'Juice items', 0, 0, 0, 0],
        ['Ghee Dosa', 'Breakfast', 250, 4, 30, 12],
        ['Honey Toast', 'Breakfast', 250, 4, 45, 6],
        ['Herbal Tea', 'Juice items', 0, 0, 0, 0],
        ['Hot Milk', 'Juice items', 150, 8, 12, 8],
        ['Hash Browns', 'Breakfast', 250, 3, 30, 12],
        ['Idli', 'Breakfast', 60, 2, 12, 0],
        ['Idiyappam', 'Breakfast', 150, 3, 35, 1],
        ['Instant Dosa', 'Breakfast', 150, 3, 30, 4],
        ['Jam Toast', 'Breakfast', 200, 3, 40, 5],
        ['Juice (Mixed Fruit)', 'Juice items', 120, 1, 30, 0],
        ['Jalebi', 'Snacks', 300, 2, 60, 10],
        ['Kanchipuram Idli', 'Breakfast', 100, 3, 15, 3],
        ['Khaman Dhokla', 'Breakfast', 150, 5, 25, 5],
        ['Kesari', 'Snacks', 350, 3, 60, 12],
        ['Lemon Juice', 'Juice items', 50, 0, 12, 0],
        ['Lassi', 'Juice items', 250, 8, 30, 10],
        ['Lemon Tea', 'Juice items', 30, 0, 8, 0],
        ['Medu Vada', 'Snacks', 150, 4, 15, 10],
        ['Milk', 'Juice items', 150, 8, 12, 8],
        ['Millet Dosa', 'Breakfast', 180, 5, 35, 5],
        ['Mushroom Omelette', 'Breakfast', 250, 15, 5, 18],
        ['Neer Dosa', 'Breakfast', 100, 2, 20, 2],
        ['Nuts Mix', 'Snacks', 200, 8, 10, 16],
        ['Noodles', 'Fastfood', 450, 10, 65, 18],
        ['Oats Porridge', 'Breakfast', 250, 10, 45, 5],
        ['Omelette', 'Breakfast', 150, 12, 2, 12],
        ['Orange Juice', 'Juice items', 110, 2, 26, 0],
        ['Pongal', 'Breakfast', 350, 8, 55, 12],
        ['Poha', 'Breakfast', 250, 5, 45, 8],
        ['Pancakes', 'Breakfast', 350, 8, 55, 12],
        ['Poori Masala', 'Breakfast', 450, 10, 65, 25],
        ['Quinoa Salad', 'Lunch', 300, 12, 45, 10],
        ['Quinoa Upma', 'Breakfast', 280, 10, 40, 8],
        ['Rava Upma', 'Breakfast', 250, 6, 45, 8],
        ['Rava Idli', 'Breakfast', 120, 4, 25, 4],
        ['Ragi Dosa', 'Breakfast', 180, 6, 35, 5],
        ['Rice Idli', 'Breakfast', 60, 2, 12, 0],
        ['Sandwich', 'Breakfast', 300, 10, 35, 12],
        ['Smoothie', 'Juice items', 300, 8, 60, 4],
        ['Sprouts Salad', 'Lunch', 150, 10, 25, 1],
        ['Sambar Vada', 'Snacks', 250, 8, 30, 12],
        ['Tea', 'Juice items', 40, 1, 8, 1],
        ['Toast', 'Breakfast', 150, 4, 30, 2],
        ['Tomato Soup', 'Lunch', 150, 3, 20, 5],
        ['Masala Tea', 'Juice items', 60, 2, 10, 2],
        ['Uttapam', 'Breakfast', 250, 6, 45, 8],
        ['Upma', 'Breakfast', 250, 6, 45, 8],
        ['Onion Uttapam', 'Breakfast', 280, 7, 48, 10],
        ['Veg Sandwich', 'Breakfast', 250, 8, 35, 10],
        ['Vegetable Soup', 'Lunch', 120, 4, 25, 2],
        ['Veg Cutlet', 'Snacks', 200, 5, 30, 8],
        ['Veg Roll', 'Fastfood', 350, 10, 50, 15],
        ['Waffles', 'Breakfast', 400, 8, 60, 18],
        ['Wheat Dosa', 'Breakfast', 180, 6, 35, 4],
        ['Wheat Toast', 'Breakfast', 180, 6, 35, 3],
        ['Xacuti', 'Dinner', 500, 25, 15, 35],
        ['Xacuti Curry', 'Dinner', 450, 20, 12, 30],
        ['Yogurt', 'Snacks', 150, 10, 15, 5],
        ['Yogurt Smoothie', 'Juice items', 250, 12, 40, 6],
        ['Yogurt Bowl', 'Breakfast', 300, 15, 35, 10],
        ['Zucchini Toast', 'Breakfast', 200, 5, 25, 10],
        ['Zucchini Pancake', 'Breakfast', 250, 8, 30, 12]
    ];

    $stmt = $pdo->prepare("INSERT INTO recipes (name, category, calories, protein, carbs, fat, cooking_time, instructions) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    $pdo->exec("DELETE FROM recipes"); // Clean start
    
    foreach ($foodItems as $item) {
        $stmt->execute([$item[0], $item[1], $item[2], $item[3], $item[4], $item[5], 15, 'Ready to eat or follow basic prep.']);
    }

    echo "Successfully imported " . count($foodItems) . " food items!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
