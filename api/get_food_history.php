<?php
require_once '../includes/config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$food_name = $_GET['food_name'] ?? '';

if (empty($food_name)) {
    echo json_encode(['error' => 'Food name is required']);
    exit;
}

// Fetch weekly history for this specific food
$history = [];
$results = [];

// Get daily totals for this specific food for the last 7 days
$start_date = date('Y-m-d', strtotime("-6 days"));
$stmt = $pdo->prepare("SELECT log_date, SUM(calories) as food_cal FROM daily_intake WHERE user_id = ? AND food_name = ? AND log_date >= ? GROUP BY log_date");
$stmt->execute([$user_id, $food_name, $start_date]);
$food_results = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $results[] = (int)($food_results[$date] ?? 0);
}

echo json_encode([
    'success' => true,
    'food_name' => $food_name,
    'data' => $results
]);
