<?php require_once 'includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Food Discovery - HealthPlanner</title>
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
                <li><a href="grocery.php">Grocery List</a></li>
                <li><a href="nutrition.php">Nutrition</a></li>
                <li><a href="discovery.php" class="active">Discovery</a></li>
            </ul>
        </div>
    </nav>

    <main class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
        
        <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 3rem;">
            <div>
                <h1 style="font-weight: 800; font-size: 2.5rem;">Local Food Discovery</h1>
                <p class="text-muted">Find healthy restaurants and street food near you.</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button class="btn btn-primary"><i class="fas fa-location-crosshairs"></i> Use My Location</button>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 2rem; height: 600px;">
            
            <!-- List of Places -->
            <div style="overflow-y: auto; padding-right: 1rem;">
                <div style="display: grid; gap: 1.5rem;">
                    
                    <!-- Place 1 -->
                    <div class="card" style="padding: 1rem; cursor: pointer;">
                        <div style="display: flex; gap: 1rem;">
                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=100&h=100&fit=crop" style="width: 80px; height: 80px; border-radius: 0.75rem; object-fit: cover;">
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between;">
                                    <h4 style="font-weight: 700;">Healthy Bites Cafe</h4>
                                    <span style="color: #f59e0b;"><i class="fas fa-star"></i> 4.8</span>
                                </div>
                                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem;">Salads, Juices • 1.2 km</p>
                                <span style="font-size: 0.75rem; background: var(--primary-light); color: var(--primary); padding: 0.2rem 0.5rem; border-radius: 0.4rem; font-weight: 600;">Vegetarian Friendly</span>
                            </div>
                        </div>
                    </div>

                    <!-- Place 2 -->
                    <div class="card" style="padding: 1rem; cursor: pointer;">
                        <div style="display: flex; gap: 1rem;">
                            <img src="https://images.unsplash.com/photo-1543339308-43e59d6b73a6?w=100&h=100&fit=crop" style="width: 80px; height: 80px; border-radius: 0.75rem; object-fit: cover;">
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between;">
                                    <h4 style="font-weight: 700;">Green Leaf Grill</h4>
                                    <span style="color: #f59e0b;"><i class="fas fa-star"></i> 4.5</span>
                                </div>
                                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem;">Organic, Fusion • 2.5 km</p>
                                <span style="font-size: 0.75rem; background: #eff6ff; color: #3b82f6; padding: 0.2rem 0.5rem; border-radius: 0.4rem; font-weight: 600;">High Protein</span>
                            </div>
                        </div>
                    </div>

                    <!-- Place 3 -->
                    <div class="card" style="padding: 1rem; cursor: pointer;">
                        <div style="display: flex; gap: 1rem;">
                            <img src="https://images.unsplash.com/photo-1552611052-33e04de081de?w=100&h=100&fit=crop" style="width: 80px; height: 80px; border-radius: 0.75rem; object-fit: cover;">
                            <div style="flex: 1;">
                                <div style="display: flex; justify-content: space-between;">
                                    <h4 style="font-weight: 700;">The Protein Station</h4>
                                    <span style="color: #f59e0b;"><i class="fas fa-star"></i> 4.7</span>
                                </div>
                                <p style="font-size: 0.875rem; color: var(--text-muted); margin-bottom: 0.5rem;">Gym Food, Keto • 3.1 km</p>
                                <span style="font-size: 0.75rem; background: #fee2e2; color: #ef4444; padding: 0.2rem 0.5rem; border-radius: 0.4rem; font-weight: 600;">Keto Options</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Map View Placeholder -->
            <div class="card" style="padding: 0; position: relative; background: #e2e8f0; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                <div style="text-align: center; color: var(--text-muted);">
                    <i class="fas fa-map-marked-alt" style="font-size: 4rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>Interactive Map Integration<br><span style="font-size: 0.875rem;">(Google Maps API Key Required)</span></p>
                </div>
                <!-- Mock Map Pattern -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1; background-image: radial-gradient(#1e293b 1px, transparent 1px); background-size: 20px 20px;"></div>
            </div>

        </div>

    </main>

</body>
</html>
