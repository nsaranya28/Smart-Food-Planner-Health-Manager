<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Food Planner & Health Manager</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
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
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="grocery.php">Grocery List</a></li>
                <li><a href="nutrition.php">Nutrition</a></li>
                <li><a href="discovery.php">Discovery</a></li>
            </ul>
            <div class="auth-btns">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="profile.php" class="btn btn-outline">Profile</a>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline">Login</a>
                    <a href="register.php" class="btn btn-primary">Join Now</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero">
        <div class="container animate-fade-in">
            <h1>Plan, Eat Healthy, <br>Live Better</h1>
            <p>Your AI-powered companion for meal planning, nutrition tracking, and healthy living.</p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <a href="register.php" class="btn btn-primary btn-lg">Start Free Trial</a>
                <a href="#features" class="btn btn-outline btn-lg">Explore Features</a>
            </div>
        </div>
    </header>

    <main class="container" style="padding-top: 4rem; padding-bottom: 4rem;">
        
        <!-- Quick Stats / Dashboard Overview -->
        <section class="dashboard-grid">
            <!-- Calorie Tracker -->
            <div class="card glass">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                    <h3 style="font-weight: 600;">Daily Calories</h3>
                    <span class="text-muted"><i class="fas fa-fire"></i></span>
                </div>
                <div style="text-align: center; padding: 1rem 0;">
                    <canvas id="calorieChart" width="200" height="200"></canvas>
                    <div style="margin-top: 1rem;">
                        <span style="font-size: 1.5rem; font-weight: 700;">1,200</span>
                        <span class="text-muted">/ 2,000 kcal</span>
                    </div>
                </div>
            </div>

            <!-- Next Meal -->
            <div class="card">
                <h3 style="font-weight: 600; margin-bottom: 1.5rem;">Next Suggested Meal</h3>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=100&h=100&fit=crop" alt="Salad" style="border-radius: 1rem; width: 80px; height: 80px; object-fit: crop;">
                    <div>
                        <h4 style="font-weight: 600;">Quinoa Avocado Salad</h4>
                        <p class="text-muted" style="font-size: 0.875rem;">Ready in 15 mins • 450 kcal</p>
                        <a href="#" style="color: var(--primary); font-weight: 600; text-decoration: none; font-size: 0.875rem; display: block; margin-top: 0.5rem;">View Recipe <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Grocery Status -->
            <div class="card">
                <h3 style="font-weight: 600; margin-bottom: 1.5rem;">Grocery List</h3>
                <ul style="list-style: none;">
                    <li style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <input type="checkbox" checked>
                        <span style="text-decoration: line-through; color: var(--text-muted);">Fresh Spinach</span>
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <input type="checkbox">
                        <span>Greek Yogurt</span>
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <input type="checkbox">
                        <span>Organic Almonds</span>
                    </li>
                </ul>
                <a href="grocery.php" class="btn btn-outline" style="width: 100%; margin-top: 1rem;">Go to List</a>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" style="margin-top: 6rem;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <h2 style="font-size: 2.5rem; font-weight: 700;">Smart Features</h2>
                <p class="text-muted">Everything you need to reach your health goals.</p>
            </div>
            
            <div class="dashboard-grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
                <div style="text-align: center; padding: 2rem;">
                    <div style="background: var(--primary-light); color: var(--primary); width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h4>AI Recommendations</h4>
                    <p class="text-muted">Personalized recipes based on your taste and goals.</p>
                </div>
                <div style="text-align: center; padding: 2rem;">
                    <div style="background: #e0e7ff; color: #4338ca; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h4>Smart Grocery</h4>
                    <p class="text-muted">Auto-generated shopping lists with budget tracking.</p>
                </div>
                <div style="text-align: center; padding: 2rem;">
                    <div style="background: #fef3c7; color: #b45309; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h4>Nutrition Analyzer</h4>
                    <p class="text-muted">Detailed breakdown of macros and daily progress.</p>
                </div>
                <div style="text-align: center; padding: 2rem;">
                    <div style="background: #fee2e2; color: #b91c1c; width: 64px; height: 64px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h4>Local Discovery</h4>
                    <p class="text-muted">Find healthy restaurants and street food nearby.</p>
                </div>
            </div>
        </section>

    </main>

    <footer style="background: #fff; border-top: 1px solid var(--border); padding: 4rem 0;">
        <div class="container" style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 2rem;">
            <div style="max-width: 300px;">
                <a href="index.php" class="logo" style="margin-bottom: 1rem;">
                    <i class="fas fa-utensils"></i>
                    <span>HealthPlanner</span>
                </a>
                <p class="text-muted">Building the future of personal nutrition and meal management.</p>
            </div>
            <div>
                <h4 style="margin-bottom: 1rem;">Product</h4>
                <ul style="list-style: none; color: var(--text-muted);">
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="text-decoration: none; color: inherit;">Features</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="text-decoration: none; color: inherit;">Pricing</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="text-decoration: none; color: inherit;">Mobile App</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1rem;">Company</h4>
                <ul style="list-style: none; color: var(--text-muted);">
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="text-decoration: none; color: inherit;">About Us</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="text-decoration: none; color: inherit;">Careers</a></li>
                    <li style="margin-bottom: 0.5rem;"><a href="#" style="text-decoration: none; color: inherit;">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="container" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--border); text-align: center; color: var(--text-muted);">
            <p>&copy; <?php echo date('Y'); ?> Smart Food Planner. All rights reserved.</p>
        </div>
    </footer>

    <script>
        // Simple Chart.js initialization
        const ctx = document.getElementById('calorieChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [1200, 800],
                    backgroundColor: ['#10b981', '#e2e8f0'],
                    borderWidth: 0,
                    cutout: '80%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { enabled: false }
                }
            }
        });
    </script>
</body>
</html>
