<?php 
require_once 'includes/config.php'; 

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch();

if (!$recipe) {
    header("Location: recipes.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $recipe['name']; ?> - HealthPlanner</title>
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
        </div>
    </nav>

    <main class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
        
        <a href="recipes.php" style="text-decoration: none; color: var(--text-muted); font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem;">
            <i class="fas fa-arrow-left"></i> Back to Recipes
        </a>

        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 3rem;">
            <!-- Main Content -->
            <div>
                <img src="<?php echo $recipe['image']; ?>" alt="<?php echo $recipe['name']; ?>" style="width: 100%; height: 400px; object-fit: cover; border-radius: 1.5rem; margin-bottom: 2rem;">
                
                <h1 style="font-weight: 800; font-size: 3rem; margin-bottom: 1rem;"><?php echo $recipe['name']; ?></h1>
                
                <div style="display: flex; gap: 2rem; margin-bottom: 2.5rem; padding: 1.5rem; background: #fff; border-radius: 1rem; border: 1px solid var(--border);">
                    <div style="text-align: center; border-right: 1px solid var(--border); padding-right: 2rem;">
                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Prep Time</span>
                        <strong style="font-size: 1.25rem;"><?php echo $recipe['cooking_time']; ?> mins</strong>
                    </div>
                    <div style="text-align: center; border-right: 1px solid var(--border); padding-right: 2rem;">
                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Calories</span>
                        <strong style="font-size: 1.25rem;"><?php echo $recipe['calories']; ?> kcal</strong>
                    </div>
                    <div style="text-align: center;">
                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">Protein</span>
                        <strong style="font-size: 1.25rem;"><?php echo $recipe['protein']; ?>g</strong>
                    </div>
                </div>

                <h2 style="font-weight: 700; margin-bottom: 1.5rem;">Instructions</h2>
                <div style="line-height: 1.8; color: var(--text-main); font-size: 1.125rem;">
                    <?php echo nl2br($recipe['instructions']); ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div style="position: sticky; top: 120px; align-self: flex-start;">
                <div class="card glass">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Nutrition Breakdown</h3>
                    
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span class="text-muted">Carbs</span>
                            <span><?php echo $recipe['carbs']; ?>g</span>
                        </div>
                        <div style="height: 8px; background: #e2e8f0; border-radius: 4px;">
                            <div style="width: 45%; height: 100%; background: var(--accent); border-radius: 4px;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span class="text-muted">Protein</span>
                            <span><?php echo $recipe['protein']; ?>g</span>
                        </div>
                        <div style="height: 8px; background: #e2e8f0; border-radius: 4px;">
                            <div style="width: 35%; height: 100%; background: var(--primary); border-radius: 4px;"></div>
                        </div>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span class="text-muted">Fat</span>
                            <span><?php echo $recipe['fat']; ?>g</span>
                        </div>
                        <div style="height: 8px; background: #e2e8f0; border-radius: 4px;">
                            <div style="width: 20%; height: 100%; background: var(--danger); border-radius: 4px;"></div>
                        </div>
                    </div>

                    <form action="api/log_food.php" method="POST" style="margin-bottom: 1rem;">
                        <input type="hidden" name="recipe_id" value="<?php echo $recipe['id']; ?>">
                        <input type="hidden" name="food_name" value="<?php echo $recipe['name']; ?>">
                        <input type="hidden" name="calories" value="<?php echo $recipe['calories']; ?>">
                        <input type="hidden" name="protein" value="<?php echo $recipe['protein']; ?>">
                        <input type="hidden" name="carbs" value="<?php echo $recipe['carbs']; ?>">
                        <input type="hidden" name="fat" value="<?php echo $recipe['fat']; ?>">
                        <input type="hidden" name="redirect" value="1">
                        <button type="submit" class="btn btn-primary" style="width: 100%;">
                            <i class="fas fa-plus-circle"></i> Log this Meal
                        </button>
                    </form>
                    <button class="btn btn-outline" style="width: 100%;">Generate Grocery List</button>
                </div>
            </div>
        </div>

    </main>

</body>
</html>
