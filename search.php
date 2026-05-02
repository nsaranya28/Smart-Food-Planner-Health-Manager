<?php
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = $_GET['q'] ?? '';
$results = [];

if (!empty($query)) {
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE name LIKE ? OR instructions LIKE ?");
    $stmt->execute(["%$query%", "%$query%"]);
    $results = $stmt->fetchAll();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - HealthPlanner</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .search-header {
            padding: 3rem 0;
            background: #fff;
            border-bottom: 1px solid var(--border);
            margin-bottom: 3rem;
        }
        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        .recipe-card {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .recipe-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 1rem;
            margin-bottom: 1rem;
        }
        .recipe-stats {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
            font-size: 0.875rem;
            color: var(--text-muted);
        }
        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .log-btn {
            margin-top: auto;
            width: 100%;
            background: var(--primary-light);
            color: var(--primary-dark);
        }
        .log-btn:hover {
            background: var(--primary);
            color: white;
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
                    <input type="text" name="q" class="search-input" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search foods, recipes..." required>
                </form>
            </div>

            <ul class="nav-links">
                <li><a href="index.php">Nutrition Tracker</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="search-header">
        <div class="container">
            <h1>Search results for "<?php echo htmlspecialchars($query); ?>"</h1>
            <p class="text-muted"><?php echo count($results); ?> items found</p>
        </div>
    </div>

    <main class="container" style="padding-bottom: 5rem;">
        <?php if (empty($results)): ?>
            <div class="card" style="text-align: center; padding: 5rem;">
                <i class="fas fa-search" style="font-size: 4rem; color: var(--border); margin-bottom: 1.5rem;"></i>
                <h2>No items found</h2>
                <p class="text-muted">Try searching for something else like "Oatmeal" or "Salad"</p>
                <a href="index.php" class="btn btn-primary" style="margin-top: 2rem;">Go Back Home</a>
            </div>
        <?php else: ?>
            <div class="results-grid">
                <?php foreach ($results as $recipe): ?>
                    <div class="card recipe-card animate-fade-in">
                        <?php if ($recipe['image']): ?>
                            <img src="<?php echo htmlspecialchars($recipe['image']); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>" class="recipe-img">
                        <?php else: ?>
                            <div class="recipe-img" style="background: var(--primary-light); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <i class="fas fa-bowl-food" style="font-size: 3rem;"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h3 style="font-weight: 700;"><?php echo htmlspecialchars($recipe['name']); ?></h3>
                        
                        <div class="recipe-stats">
                            <div class="stat-item"><i class="fas fa-fire"></i> <?php echo $recipe['calories']; ?> kcal</div>
                            <div class="stat-item"><i class="fas fa-clock"></i> <?php echo $recipe['cooking_time']; ?> min</div>
                        </div>
                        
                        <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.8rem; font-weight: 600;">
                            <span style="background: #f1f5f9; padding: 0.25rem 0.75rem; border-radius: 1rem;">P: <?php echo $recipe['protein']; ?>g</span>
                            <span style="background: #f1f5f9; padding: 0.25rem 0.75rem; border-radius: 1rem;">C: <?php echo $recipe['carbs']; ?>g</span>
                            <span style="background: #f1f5f9; padding: 0.25rem 0.75rem; border-radius: 1rem;">F: <?php echo $recipe['fat']; ?>g</span>
                        </div>
                        
                        <button onclick="logFood(<?php echo $recipe['id']; ?>, '<?php echo addslashes($recipe['name']); ?>', <?php echo $recipe['calories']; ?>, <?php echo $recipe['protein']; ?>, <?php echo $recipe['carbs']; ?>, <?php echo $recipe['fat']; ?>)" class="btn log-btn">
                            <i class="fas fa-plus"></i> Add to Today's Log
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <script>
        async function logFood(recipeId, name, cal, prot, carb, fat) {
            const formData = new FormData();
            formData.append('recipe_id', recipeId);
            formData.append('food_name', name);
            formData.append('calories', cal);
            formData.append('protein', prot);
            formData.append('carbs', carb);
            formData.append('fat', fat);

            try {
                const response = await fetch('api/log_food.php', {
                    method: 'POST',
                    body: formData
                });
                const data = await response.json();
                
                if (data.success) {
                    alert('Successfully added ' + name + ' to your log!');
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Something went wrong. Please try again.');
            }
        }
    </script>

</body>
</html>
