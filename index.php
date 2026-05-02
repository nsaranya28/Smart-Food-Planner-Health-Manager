<?php 
require_once 'includes/config.php'; 

// Check login or use dummy for demo
if (!isset($_SESSION['user_id'])) {
    $stmt = $pdo->query("SELECT id FROM users LIMIT 1");
    $user = $stmt->fetch();
    if ($user) $_SESSION['user_id'] = $user['id'];
}

$user_id = $_SESSION['user_id'] ?? 0;

// Fetch user goal
$stmt = $pdo->prepare("SELECT goal FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user_data = $stmt->fetch();
$goal_type = $user_data['goal'] ?? 'maintain';

$daily_goal = 2000;
if ($goal_type == 'lose_weight') $daily_goal = 1800;
if ($goal_type == 'gain_muscle') $daily_goal = 2800;

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

$cal_percentage = min(100, ($totals['cal'] / $daily_goal) * 100);

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
    <title>Nutrition Insights - HealthPlanner</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: var(--bg-card);
            border-radius: 1.5rem;
            padding: 1.5rem;
            border: 1px solid var(--border);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }
        .stat-icon {
            position: absolute;
            right: -10px;
            bottom: -10px;
            font-size: 5rem;
            opacity: 0.05;
            transform: rotate(-15deg);
        }
        .progress-container {
            height: 12px;
            background: #e2e8f0;
            border-radius: 6px;
            margin: 1rem 0;
            overflow: hidden;
        }
        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            border-radius: 6px;
            transition: width 1s ease-out;
        }
        .macro-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
        .glass-header {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
            border-radius: 2rem;
            padding: 3rem;
            margin-bottom: 3rem;
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">
                <i class="fas fa-utensils"></i>
                <span>HealthPlanner</span>
            </a>
            
            <div class="search-container">
                <form action="search.php" method="GET" class="search-form">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="q" class="search-input" placeholder="Search foods, recipes...">
                </form>
            </div>

            <ul class="nav-links">
                <li><a href="index.php" class="active">Nutrition Tracker</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <main class="container" style="padding-top: 3rem; padding-bottom: 5rem;">
        
        <div class="glass-header animate-fade-in">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 2rem;">
                <div>
                    <h1 style="font-weight: 800; font-size: 3rem; margin-bottom: 0.5rem; background: linear-gradient(to right, var(--text-main), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Nutrition Insights</h1>
                    <p class="text-muted" style="font-size: 1.1rem;">You've consumed <strong><?php echo $totals['cal']; ?></strong> of your <strong><?php echo $daily_goal; ?></strong> kcal daily goal.</p>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 3rem; font-weight: 800; color: var(--primary);"><?php echo round($cal_percentage); ?>%</div>
                    <div class="text-muted" style="text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.75rem;">Daily Progress</div>
                </div>
            </div>
            <div class="progress-container">
                <div class="progress-bar" style="width: <?php echo $cal_percentage; ?>%;"></div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <span class="text-muted" style="font-size: 0.875rem; font-weight: 600;">PROTEIN</span>
                <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;"><?php echo $totals['prot']; ?><small style="font-size: 1rem; color: var(--text-muted);">g</small></div>
                <div style="font-size: 0.875rem; color: var(--success);"><i class="fas fa-check-circle"></i> On track</div>
                <i class="fas fa-egg stat-icon"></i>
            </div>
            <div class="stat-card">
                <span class="text-muted" style="font-size: 0.875rem; font-weight: 600;">CARBS</span>
                <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;"><?php echo $totals['carb']; ?><small style="font-size: 1rem; color: var(--text-muted);">g</small></div>
                <div style="font-size: 0.875rem; color: var(--accent);"><i class="fas fa-info-circle"></i> Balanced</div>
                <i class="fas fa-bread-slice stat-icon"></i>
            </div>
            <div class="stat-card">
                <span class="text-muted" style="font-size: 0.875rem; font-weight: 600;">FATS</span>
                <div style="font-size: 2rem; font-weight: 800; margin: 0.5rem 0;"><?php echo $totals['fat']; ?><small style="font-size: 1rem; color: var(--text-muted);">g</small></div>
                <div style="font-size: 0.875rem; color: var(--warning);"><i class="fas fa-bolt"></i> Essential</div>
                <i class="fas fa-cheese stat-icon"></i>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 2fr 1.2fr; gap: 2rem; margin-top: 3rem;">
            <!-- Weekly Chart -->
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                    <h3 style="font-weight: 700;">Weekly Consumption</h3>
                    <div style="display: flex; gap: 1rem;">
                        <div style="display: flex; align-items: center; font-size: 0.875rem; color: var(--text-muted);">
                            <span class="macro-dot" style="background: var(--primary);"></span> Calories
                        </div>
                    </div>
                </div>
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="weeklyChart"></canvas>
                </div>
            </div>

            <!-- Macro Breakdown -->
            <div class="card glass" style="display: flex; flex-direction: column;">
                <h3 style="font-weight: 700; margin-bottom: 2rem;">Macro Distribution</h3>
                <div style="flex-grow: 1; position: relative; min-height: 250px;">
                    <canvas id="macroChart"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; pointer-events: none;">
                        <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Total</div>
                        <div style="font-size: 1.5rem; font-weight: 800;"><?php echo $totals['prot'] + $totals['carb'] + $totals['fat']; ?>g</div>
                    </div>
                </div>
                <div style="margin-top: 2rem; display: grid; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #f8fafc; border-radius: 1rem;">
                        <div style="display: flex; align-items: center;">
                            <span class="macro-dot" style="background: var(--primary);"></span>
                            <span style="font-weight: 500;">Protein</span>
                        </div>
                        <span style="font-weight: 700;"><?php echo $totals['prot']; ?>g</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #f8fafc; border-radius: 1rem;">
                        <div style="display: flex; align-items: center;">
                            <span class="macro-dot" style="background: var(--accent);"></span>
                            <span style="font-weight: 500;">Carbs</span>
                        </div>
                        <span style="font-weight: 700;"><?php echo $totals['carb']; ?>g</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem; background: #f8fafc; border-radius: 1rem;">
                        <div style="display: flex; align-items: center;">
                            <span class="macro-dot" style="background: var(--danger);"></span>
                            <span style="font-weight: 500;">Fat</span>
                        </div>
                        <span style="font-weight: 700;"><?php echo $totals['fat']; ?>g</span>
                    </div>
                </div>
            </div>
        </div>

        <section style="margin-top: 4rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                <h2 style="font-weight: 800; font-size: 2rem;">Recent Food Logs</h2>
            </div>
            
            <div class="card" style="padding: 0; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid var(--border);">
                            <th style="padding: 1.25rem 1.5rem; text-align: left; font-weight: 700; color: var(--text-muted); font-size: 0.875rem;">TIME</th>
                            <th style="padding: 1.25rem 1.5rem; text-align: left; font-weight: 700; color: var(--text-muted); font-size: 0.875rem;">MEAL NAME</th>
                            <th style="padding: 1.25rem 1.5rem; text-align: center; font-weight: 700; color: var(--text-muted); font-size: 0.875rem;">CALORIES</th>
                            <th style="padding: 1.25rem 1.5rem; text-align: right; font-weight: 700; color: var(--text-muted); font-size: 0.875rem;">MACROS (P/C/F)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($today_logs)): ?>
                            <tr>
                                <td colspan="4" style="padding: 4rem; text-align: center;">
                                    <div style="color: var(--text-muted); margin-bottom: 1rem;">
                                        <i class="fas fa-calendar-day" style="font-size: 3rem; opacity: 0.2;"></i>
                                    </div>
                                    <p style="color: var(--text-muted); font-size: 1.1rem;">No logs for today yet.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($today_logs as $log): ?>
                                <tr style="border-bottom: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='white'">
                                    <td style="padding: 1.25rem 1.5rem; color: var(--text-muted); font-size: 0.875rem;">
                                        <?php echo date('h:i A', strtotime($log['log_time'])); ?>
                                    </td>
                                    <td style="padding: 1.25rem 1.5rem;">
                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                            <div style="width: 40px; height: 40px; background: var(--primary-light); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                                <i class="fas fa-utensils"></i>
                                            </div>
                                            <span style="font-weight: 600; font-size: 1.1rem;"><?php echo htmlspecialchars($log['food_name']); ?></span>
                                        </div>
                                    </td>
                                    <td style="padding: 1.25rem 1.5rem; text-align: center;">
                                        <span style="background: #f0fdf4; color: var(--primary); padding: 0.5rem 1rem; border-radius: 2rem; font-weight: 700;">
                                            <?php echo $log['calories']; ?> <small>kcal</small>
                                        </span>
                                    </td>
                                    <td style="padding: 1.25rem 1.5rem; text-align: right;">
                                        <div style="display: flex; justify-content: flex-end; gap: 1rem; font-size: 0.875rem;">
                                            <span><strong><?php echo $log['protein']; ?></strong>P</span>
                                            <span><strong><?php echo $log['carbs']; ?></strong>C</span>
                                            <span><strong><?php echo $log['fat']; ?></strong>F</span>
                                        </div>
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
        // Set global chart defaults
        Chart.defaults.font.family = "'Outfit', sans-serif";
        Chart.defaults.color = '#64748b';

        // Weekly Progress Chart
        const weeklyCtx = document.getElementById('weeklyChart').getContext('2d');
        const gradient = weeklyCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.8)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0.2)');

        new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: <?php echo $weekly_labels; ?>,
                datasets: [{
                    label: 'Calories',
                    data: <?php echo $weekly_values; ?>,
                    backgroundColor: gradient,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true, 
                        grid: { borderDash: [5, 5], drawBorder: false },
                        ticks: { stepSize: 500 }
                    },
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
                    hoverOffset: 10,
                    borderWidth: 0,
                    borderRadius: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: {
                    legend: { display: false }
                }
            }
        });
    </script>
</body>
</html>
