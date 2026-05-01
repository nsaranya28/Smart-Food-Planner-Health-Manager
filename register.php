<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join HealthPlanner - Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">

    <div class="card glass animate-fade-in" style="width: 100%; max-width: 450px;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="index.php" class="logo" style="justify-content: center; margin-bottom: 1rem;">
                <i class="fas fa-utensils"></i>
                <span>HealthPlanner</span>
            </a>
            <h2 style="font-weight: 700;">Create Account</h2>
            <p class="text-muted">Start your health journey today</p>
        </div>

        <form action="api/auth_handler.php" method="POST">
            <input type="hidden" name="action" value="register">
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="John Doe" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="height">Height (cm)</label>
                    <input type="number" id="height" name="height" class="form-control" placeholder="175">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="weight">Weight (kg)</label>
                    <input type="number" id="weight" name="weight" class="form-control" placeholder="70">
                </div>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.875rem;">Create Account</button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem;">
            <span class="text-muted">Already have an account?</span>
            <a href="login.php" style="color: var(--primary); font-weight: 600; text-decoration: none;">Log in</a>
        </div>
    </div>

</body>
</html>
