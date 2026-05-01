<?php 
require_once 'includes/config.php'; 

// Check login or use dummy for demo
if (!isset($_SESSION['user_id'])) {
    $stmt = $pdo->query("SELECT id FROM users LIMIT 1");
    $user = $stmt->fetch();
    if ($user) $_SESSION['user_id'] = $user['id'];
}

$user_id = $_SESSION['user_id'] ?? 0;

// Fetch today's logs
$today = date('Y-m-d');
$stmt = $pdo->prepare("SELECT * FROM daily_intake WHERE user_id = ? AND log_date = ? ORDER BY log_time DESC");
$stmt->execute([$user_id, $today]);
$today_logs = $stmt->fetchAll();

// Calculate today's totals
$totals = ['cal' => 0, 'prot' => 0, 'carb' => 0, 'fat' => 0];
foreach ($today_logs as $log) {
    $totals['cal'] += $log['calories'];
    $totals['prot'] += $log['protein'];
    $totals['carb'] += $log['carbs'];
    $totals['fat'] += $log['fat'];
}

// Fetch weekly data (last 7 days)
$weekly_data = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date('Y-m-d', strtotime("-$i days"));
    $day_name = date('D', strtotime($date));
    
    $stmt = $pdo->prepare("SELECT SUM(calories) as total_cal FROM daily_intake WHERE user_id = ? AND log_date = ?");
    $stmt->execute([$user_id, $date]);
    $res = $stmt->fetch();
    
    $weekly_data[] = [
        'day' => $day_name,
        'calories' => $res['total_cal'] ?? 0
    ];
}

$weekly_labels = json_encode(array_column($weekly_data, 'day'));
$weekly_values = json_encode(array_column($weekly_data, 'calories'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nutrition Analytics - HealthPlanner</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <i class="fas fa-utensils"></i>
                <span>HealthPlanner</span>
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="grocery.php">Grocery List</a></li>
                <li><a href="nutrition.php" class="active">Nutrition</a></li>
                <li><a href="discovery.php">Discovery</a></li>
            </ul>
        </div>
    </nav>

    <main class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
        
        <div style="margin-bottom: 3rem;">
            <h1 style="font-weight: 800; font-size: 2.5rem;">Nutrition Analytics</h1>
            <p class="text-muted">Track your progress and stay on top of your health goals.</p>
        </div>

        <div class="dashboard-grid" style="grid-template-columns: 2fr 1fr;">
            <!-- Weekly Progress Chart -->
            <div class="card">
                <h3 style="margin-bottom: 2rem;">Weekly Calorie Intake</h3>
                <canvas id="weeklyChart" height="300"></canvas>
            </div>

            <!-- Macros Breakdown -->
            <div class="card glass">
                <h3 style="margin-bottom: 2rem;">Macro Distribution</h3>
                <canvas id="macroChart" height="300"></canvas>
                <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                    <div style="text-align: center; padding: 1rem; background: #f0fdf4; border-radius: 1rem;">
                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">Protein</span>
                        <strong style="color: var(--primary);"><?php echo $totals['prot']; ?>g</strong>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: #eff6ff; border-radius: 1rem;">
                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">Carbs</span>
                        <strong style="color: var(--accent);"><?php echo $totals['carb']; ?>g</strong>
                    </div>
                    <div style="text-align: center; padding: 1rem; background: #fff1f2; border-radius: 1rem;">
                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">Fat</span>
                        <strong style="color: var(--danger);"><?php echo $totals['fat']; ?>g</strong>
                    </div>
                </div>
            </div>
        </div>

        <section style="margin-top: 3rem;">
            <h2 style="margin-bottom: 2rem; font-weight: 700;">Recent Food Logs</h2>
            <div class="card" style="padding: 0;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid var(--border);">
                            <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600;">Time</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-weight: 600;">Meal</th>
                            <th style="padding: 1rem 1.5rem; text-align: right; font-weight: 600;">Calories</th>
                            <th style="padding: 1rem 1.5rem; text-align: right; font-weight: 600;">Macros (P/C/F)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($today_logs)): ?>
                            <tr>
                                <td colspan="4" style="padding: 2rem; text-align: center; color: var(--text-muted);">No logs for today yet. Go to <a href="recipes.php" style="color: var(--primary);">Recipes</a> to add some!</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($today_logs as $log): ?>
                                <tr style="border-bottom: 1px solid var(--border);">
                                    <td style="padding: 1rem 1.5rem;"><?php echo date('h:i A', strtotime($log['log_time'])); ?></td>
                                    <td style="padding: 1rem 1.5rem; font-weight: 500;"><?php echo htmlspecialchars($log['food_name']); ?></td>
                                    <td style="padding: 1rem 1.5rem; text-align: right;"><?php echo $log['calories']; ?> kcal</td>
                                    <td style="padding: 1rem 1.5rem; text-align: right; color: var(--text-muted);">
                                        <?php echo $log['protein']; ?>g / <?php echo $log['carbs']; ?>g / <?php echo $log['fat']; ?>g
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <script>
        // Weekly Progress Chart
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: <?php echo $weekly_labels; ?>,
                datasets: [{
                    label: 'Calories Consumed',
                    data: <?php echo $weekly_values; ?>,
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: '#10b981',
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, grid: { display: false } },
                    x: { grid: { display: false } }
                }
            }
        });

        // Macro Distribution Chart
        const macroCtx = document.getElementById('macroChart').getContext('2d');
        new Chart(macroCtx, {
            type: 'doughnut',
            data: {
                labels: ['Protein', 'Carbs', 'Fat'],
                datasets: [{
                    data: [<?php echo $totals['prot']; ?>, <?php echo $totals['carb']; ?>, <?php echo $totals['fat']; ?>],
                    backgroundColor: ['#10b981', '#3b82f6', '#ef4444'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>
</body>
</html>
