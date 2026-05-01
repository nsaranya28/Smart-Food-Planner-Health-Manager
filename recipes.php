<?php 
require_once 'includes/config.php'; 

// Fetch recipes
$stmt = $pdo->query("SELECT * FROM recipes ORDER BY created_at DESC");
$recipes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthy Recipes - HealthPlanner</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <li><a href="recipes.php" class="active">Recipes</a></li>
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

    <main class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 2.5rem;">
            <div>
                <h1 style="font-weight: 800; font-size: 2.5rem;">Discover Recipes</h1>
                <p class="text-muted">Personalized meals based on your nutrition goals.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <input type="text" class="form-control" placeholder="Search recipes..." style="width: 300px;">
                </div>
                <button class="btn btn-outline"><i class="fas fa-filter"></i> Filters</button>
            </div>
        </div>

        <!-- Recipe Grid -->
        <div class="dashboard-grid">
            <?php foreach($recipes as $recipe): ?>
                <div class="card animate-fade-in" style="padding: 0; overflow: hidden;">
                    <img src="<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['name']; ?>" style="width: 100%; height: 200px; object-fit: cover;">
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                            <h3 style="font-weight: 700; font-size: 1.25rem;"><?php echo $recipe['name']; ?></h3>
                            <span style="background: var(--primary-light); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 600;">
                                <i class="fas fa-clock"></i> <?php echo $recipe['cooking_time']; ?>m
                            </span>
                        </div>
                        
                        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; color: var(--text-muted); font-size: 0.875rem;">
                            <span><strong><?php echo $recipe['calories']; ?></strong> kcal</span>
                            <span><strong><?php echo $recipe['protein']; ?>g</strong> Protein</span>
                            <span><strong><?php echo $recipe['fat']; ?>g</strong> Fat</span>
                        </div>

                        <div style="display: flex; gap: 0.5rem;">
                            <a href="recipe-details.php?id=<?php echo $recipe['id']; ?>" class="btn btn-primary" style="flex: 1;">View Details</a>
                            <button class="btn btn-outline" title="Add to Meal Plan"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </main>

</body>
</html>
