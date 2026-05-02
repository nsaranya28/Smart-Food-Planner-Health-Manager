<?php 
require_once 'includes/config.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $height = $_POST['height'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $goal = $_POST['goal'] ?? 'maintain';

    $update_stmt = $pdo->prepare("UPDATE users SET name = ?, height = ?, weight = ?, goal = ? WHERE id = ?");
    $update_stmt->execute([$name, $height, $weight, $goal, $user_id]);
    
    $_SESSION['user_name'] = $name;
    $success = "Profile updated successfully!";
    
    // Refresh user data
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - HealthPlanner</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <li><a href="index.php">Nutrition Tracker</a></li>
                <li><a href="profile.php" class="active">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>

    <main class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
        
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="margin-bottom: 3rem; text-align: center;">
                <h1 style="font-weight: 800; font-size: 2.5rem;">User Profile</h1>
                <p class="text-muted">Manage your personal health goals and settings.</p>
            </div>

            <?php if(isset($success)): ?>
                <div style="background: var(--success); color: white; padding: 1rem; border-radius: 0.75rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                </div>
            <?php endif; ?>

            <div class="dashboard-grid" style="grid-template-columns: 1fr;">
                <div class="card glass">
                    <form action="profile.php" method="POST">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                <small class="text-muted">Email cannot be changed.</small>
                            </div>
                            <div class="form-group">
                                <label for="height">Height (cm)</label>
                                <input type="number" id="height" name="height" class="form-control" value="<?php echo $user['height']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight (kg)</label>
                                <input type="number" id="weight" name="weight" class="form-control" value="<?php echo $user['weight']; ?>">
                            </div>
                            <div class="form-group" style="grid-column: span 2;">
                                <label for="goal">Your Health Goal</label>
                                <select id="goal" name="goal" class="form-control">
                                    <option value="lose_weight" <?php echo $user['goal'] == 'lose_weight' ? 'selected' : ''; ?>>Lose Weight</option>
                                    <option value="maintain" <?php echo $user['goal'] == 'maintain' ? 'selected' : ''; ?>>Maintain Health</option>
                                    <option value="gain_muscle" <?php echo $user['goal'] == 'gain_muscle' ? 'selected' : ''; ?>>Gain Muscle</option>
                                </select>
                            </div>
                        </div>

                        <div style="margin-top: 2rem; border-top: 1px solid var(--border); padding-top: 2rem; text-align: right;">
                            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2.5rem;">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div style="margin-top: 2rem;" class="card">
                <h3 style="color: var(--danger); margin-bottom: 1rem;">Danger Zone</h3>
                <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 1.5rem;">Once you delete your account, there is no going back. Please be certain.</p>
                <button class="btn btn-outline" style="color: var(--danger); border-color: var(--danger);">Delete Account</button>
            </div>
        </div>

    </main>

</body>
</html>
