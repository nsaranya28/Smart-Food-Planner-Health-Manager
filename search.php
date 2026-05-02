<?php
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = $_GET['q'] ?? '';
$category = $_GET['category'] ?? '';
$results = [];

$sql = "SELECT * FROM recipes WHERE 1=1";
$params = [];

if (!empty($query)) {
    // Check if the query matches any category name
    $categories_list = ['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Fastfood', 'Chat items', 'Juice items'];
    $matching_cat = '';
    foreach ($categories_list as $cl) {
        if (strtolower($cl) === strtolower(trim($query))) {
            $matching_cat = $cl;
            break;
        }
    }

    if ($matching_cat) {
        // If query is "breakfast", show all in breakfast category OR matching name
        $sql .= " AND (category = ? OR name LIKE ? OR instructions LIKE ?)";
        $params[] = $matching_cat;
        $params[] = "%$query%";
        $params[] = "%$query%";
    } else {
        $sql .= " AND (name LIKE ? OR instructions LIKE ?)";
        $params[] = "%$query%";
        $params[] = "%$query%";
    }
}

if (!empty($category)) {
    $sql .= " AND category = ?";
    $params[] = $category;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();

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
        .filter-section {
            margin-bottom: 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
        }
        .filter-chip {
            padding: 0.6rem 1.25rem;
            border-radius: 2rem;
            background: #fff;
            border: 1px solid var(--border);
            color: var(--text-main);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .filter-chip:hover, .filter-chip.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
            box-shadow: var(--shadow-md);
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
                    <?php if (!empty($category)): ?>
                        <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                    <?php endif; ?>
                    <input type="text" name="q" class="search-input" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search foods, recipes...">
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
            <div style="text-align: center; margin-bottom: 2rem;">
                <h1><?php echo !empty($query) ? 'Search results for "' . htmlspecialchars($query) . '"' : 'Find Healthy Food'; ?></h1>
                <p class="text-muted"><?php echo count($results); ?> items found <?php echo !empty($category) ? 'in ' . htmlspecialchars($category) : ''; ?></p>
            </div>

            <div class="filter-section">
                <?php 
                $categories = ['Breakfast', 'Lunch', 'Dinner', 'Snacks', 'Fastfood', 'Chat items', 'Juice items'];
                ?>
                <a href="search.php" class="filter-chip <?php echo empty($category) ? 'active' : ''; ?>">All Items</a>
                <?php foreach ($categories as $cat): ?>
                    <a href="search.php?category=<?php echo urlencode($cat); ?>" 
                       class="filter-chip <?php echo $category === $cat ? 'active' : ''; ?>">
                        <?php echo $cat; ?>
                    </a>
                <?php endforeach; ?>
            </div>
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
                        
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                            <h3 style="font-weight: 700;"><?php echo htmlspecialchars($recipe['name']); ?></h3>
                            <span style="font-size: 0.75rem; background: var(--primary-light); color: var(--primary-dark); padding: 0.2rem 0.6rem; border-radius: 0.5rem; font-weight: 600;">
                                <?php echo htmlspecialchars($recipe['category']); ?>
                            </span>
                        </div>
                        
                        <div class="nutrition-facts" style="background: #f8fafc; border: 1px solid var(--border); border-radius: 1rem; padding: 1rem; margin-bottom: 1.5rem;">
                            <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 0.75rem; border-bottom: 1px solid var(--border); padding-bottom: 0.25rem;">Nutrition Details</div>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 0.7rem; color: var(--text-muted);">Calories</span>
                                    <span style="font-weight: 800; color: var(--text-main);"><?php echo $recipe['calories']; ?> kcal</span>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 0.7rem; color: var(--text-muted);">Protein</span>
                                    <span style="font-weight: 800; color: var(--primary-dark);"><?php echo $recipe['protein']; ?>g</span>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 0.7rem; color: var(--text-muted);">Carbs</span>
                                    <span style="font-weight: 800; color: var(--accent);"><?php echo $recipe['carbs']; ?>g</span>
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 0.7rem; color: var(--text-muted);">Fat</span>
                                    <span style="font-weight: 800; color: var(--danger);"><?php echo $recipe['fat']; ?>g</span>
                                </div>
                            </div>
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
