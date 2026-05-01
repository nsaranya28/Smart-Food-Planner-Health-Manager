<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Grocery List - HealthPlanner</title>
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
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="grocery.php" class="active">Grocery List</a></li>
                <li><a href="nutrition.php">Nutrition</a></li>
                <li><a href="discovery.php">Discovery</a></li>
            </ul>
        </div>
    </nav>

    <main class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
            <div>
                <h1 style="font-weight: 800; font-size: 2.5rem;">Smart Grocery List</h1>
                <p class="text-muted">Auto-generated from your weekly meal plan.</p>
            </div>
            <div class="card glass" style="padding: 1rem 2rem; display: flex; gap: 2rem; align-items: center;">
                <div style="text-align: center;">
                    <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">Budget</span>
                    <strong style="font-size: 1.25rem;">₹ 2,500</strong>
                </div>
                <div style="width: 1px; height: 30px; background: var(--border);"></div>
                <div style="text-align: center;">
                    <span style="display: block; font-size: 0.75rem; color: var(--text-muted);">Estimated</span>
                    <strong style="font-size: 1.25rem; color: var(--primary);">₹ 1,345</strong>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 3rem; align-items: flex-start;">
            
            <!-- List Items -->
            <div>
                <div class="card" style="padding: 0; overflow: hidden;">
                    <div style="padding: 1.5rem; background: #f8fafc; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between;">
                        <h3 style="font-size: 1.125rem; font-weight: 700;">Shopping Items</h3>
                        <button class="btn btn-outline" style="padding: 0.5rem 1rem; font-size: 0.875rem;">+ Add Item</button>
                    </div>
                    
                    <div style="padding: 1.5rem;">
                        <!-- Category: Produce -->
                        <div style="margin-bottom: 2rem;">
                            <h4 style="font-size: 0.875rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Produce</h4>
                            <div style="display: grid; gap: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--border); border-radius: 0.75rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="checkbox" style="width: 20px; height: 20px;">
                                        <div>
                                            <strong style="display: block;">Fresh Spinach</strong>
                                            <span style="font-size: 0.875rem; color: var(--text-muted);">250g • ₹ 40</span>
                                        </div>
                                    </div>
                                    <button style="color: var(--danger); background: none; border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--border); border-radius: 0.75rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="checkbox" style="width: 20px; height: 20px;">
                                        <div>
                                            <strong style="display: block;">Organic Avocados</strong>
                                            <span style="font-size: 0.875rem; color: var(--text-muted);">2 units • ₹ 180</span>
                                        </div>
                                    </div>
                                    <button style="color: var(--danger); background: none; border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>

                        <!-- Category: Dairy -->
                        <div>
                            <h4 style="font-size: 0.875rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1rem;">Dairy & Eggs</h4>
                            <div style="display: grid; gap: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--border); border-radius: 0.75rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <input type="checkbox" style="width: 20px; height: 20px;">
                                        <div>
                                            <strong style="display: block;">Greek Yogurt</strong>
                                            <span style="font-size: 0.875rem; color: var(--text-muted);">500g • ₹ 120</span>
                                        </div>
                                    </div>
                                    <button style="color: var(--danger); background: none; border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary / Sidebar -->
            <div style="position: sticky; top: 120px;">
                <div class="card glass">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Cart Summary</h3>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span class="text-muted">Total Items</span>
                        <span>8</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 1rem;">
                        <span class="text-muted">Subtotal</span>
                        <span>₹ 1,345</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; border-top: 1px solid var(--border); padding-top: 1rem;">
                        <strong style="font-size: 1.25rem;">Total</strong>
                        <strong style="font-size: 1.25rem; color: var(--primary);">₹ 1,345</strong>
                    </div>

                    <button class="btn btn-primary" style="width: 100%; margin-bottom: 1rem;">Checkout</button>
                    <button class="btn btn-outline" style="width: 100%;"><i class="fas fa-share-alt"></i> Share List</button>
                </div>

                <div class="card" style="margin-top: 1.5rem; background: #fffbeb; border-color: #fef3c7;">
                    <div style="display: flex; gap: 1rem; align-items: flex-start;">
                        <i class="fas fa-lightbulb" style="color: #f59e0b; margin-top: 0.25rem;"></i>
                        <div>
                            <h4 style="color: #92400e; margin-bottom: 0.25rem;">Pro Tip</h4>
                            <p style="font-size: 0.875rem; color: #b45309;">Buying organic avocados from local street vendors can save you up to 15% this week!</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

</body>
</html>
