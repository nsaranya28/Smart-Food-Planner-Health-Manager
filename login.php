<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HealthPlanner</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 2rem;">

    <div class="card glass animate-fade-in" style="width: 100%; max-width: 400px;">
        <div style="text-align: center; margin-bottom: 2rem;">
            <a href="index.php" class="logo" style="justify-content: center; margin-bottom: 1rem;">
                <i class="fas fa-utensils"></i>
                <span>HealthPlanner</span>
            </a>
            <h2 style="font-weight: 700;">Welcome Back</h2>
            <p class="text-muted">Enter your details to log in</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div style="background: var(--danger); color: white; padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1rem; font-size: 0.875rem;">
                Invalid email or password.
            </div>
        <?php endif; ?>

        <form action="api/auth_handler.php" method="POST">
            <input type="hidden" name="action" value="login">
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="john@example.com" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.875rem;">Log In</button>
        </form>

        <div style="margin-top: 1.5rem; text-align: center; font-size: 0.875rem;">
            <span class="text-muted">Don't have an account?</span>
            <a href="register.php" style="color: var(--primary); font-weight: 600; text-decoration: none;">Register now</a>
        </div>
    </div>

</body>
</html>
