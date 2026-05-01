<?php
require_once '../includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // For demo purposes, if not logged in, we'll try to find the first user
    $stmt = $pdo->query("SELECT id FROM users LIMIT 1");
    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
    } else {
        echo json_encode(['success' => false, 'message' => 'User not authenticated']);
        exit;
    }
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_id = $_POST['recipe_id'] ?? null;
    $food_name = $_POST['food_name'] ?? 'Unknown Food';
    $calories = $_POST['calories'] ?? 0;
    $protein = $_POST['protein'] ?? 0;
    $carbs = $_POST['carbs'] ?? 0;
    $fat = $_POST['fat'] ?? 0;

    try {
        $stmt = $pdo->prepare("INSERT INTO daily_intake (user_id, recipe_id, food_name, calories, protein, carbs, fat) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $recipe_id, $food_name, $calories, $protein, $carbs, $fat]);
        
        if (isset($_POST['redirect'])) {
            header("Location: ../nutrition.php?success=1");
            exit;
        }
        
        echo json_encode(['success' => true, 'message' => 'Food logged successfully']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
