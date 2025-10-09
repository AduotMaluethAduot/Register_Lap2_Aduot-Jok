<?php
// Use the enhanced session management from core.php
require_once 'settings/core.php';

// Ensure session variables are set for user name and role
$user_name = get_user_name();
$user_role = get_user_role();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taste of Africa - Authentic Flavors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Menu -->
    <div class="menu-tray">
        <i class="fas fa-utensils me-2" style="color: var(--primary-orange);"></i>
        <?php if (is_user_logged_in()): ?>
            <span class="welcome-message me-2">
                <i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($user_name); ?>!
                <?php if ($user_role === 'admin'): ?>
                    <span style="color: var(--accent-yellow); font-weight: bold;">
                        <i class="fas fa-crown"></i> Admin
                    </span>
                <?php endif; ?>
            </span>
            <?php if ($user_role === 'admin'): ?>
                <a href="admin/dashboard.php" class="btn btn-sm btn-warning" style="margin-right: 8px;">
                    <i class="fas fa-tachometer-alt"></i> Admin Panel
                </a>
            <?php endif; ?>
            <a href="login/logout.php" class="btn btn-sm btn-danger-custom">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        <?php else: ?>
            <a href="login/register.php" class="btn btn-sm btn-primary-custom">
                <i class="fas fa-user-plus"></i> Register
            </a>
            <a href="login/login.php" class="btn btn-sm btn-secondary-custom">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        <?php endif; ?>
    </div>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-10 hero-content">
                    <h1 class="hero-title">
                        <i class="fas fa-leaf me-3" style="color: var(--accent-yellow);"></i>
                        Taste of Africa
                    </h1>
                    <p class="hero-subtitle">
                        <i class="fas fa-star me-2"></i>
                        Authentic Flavors, Unforgettable Experiences
                    </p>
                    
                    <?php if (is_user_logged_in()): ?>
                        <div class="hero-description">
                            <i class="fas fa-heart" style="color: var(--accent-yellow);"></i>
                            Welcome back, <strong><?php echo htmlspecialchars($user_name); ?></strong>! 
                            <?php if ($user_role === 'admin'): ?>
                                <span style="color: var(--accent-yellow);">You have administrative privileges.</span>
                            <?php endif; ?>
                            Ready to explore more delicious African cuisine?
                        </div>
                        <div class="mt-4">
                            <?php if ($user_role === 'admin'): ?>
                                <a href="admin/dashboard.php" class="cta-button pulse-animation">
                                    <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                                </a>
                                <a href="admin/category.php" class="cta-button pulse-animation">
                                    <i class="fas fa-tags me-2"></i>Categories
                                </a>
                            <?php endif; ?>
                            <a href="#menu" class="cta-button <?php echo ($user_role === 'admin') ? 'cta-secondary' : 'pulse-animation'; ?>">
                                <i class="fas fa-utensils me-2"></i>Explore Menu
                            </a>
                            <a href="#order" class="cta-button cta-secondary">
                                <i class="fas fa-shopping-cart me-2"></i>Order Now
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="hero-description">
                            <i class="fas fa-globe-africa" style="color: var(--accent-yellow);"></i>
                            Discover the rich, vibrant flavors of African cuisine. From spicy Ethiopian dishes to 
                            savory West African delicacies, embark on a culinary journey like no other.
                        </div>
                        <div class="mt-4">
                            <a href="login/register.php" class="cta-button pulse-animation">
                                <i class="fas fa-user-plus me-2"></i>Join Our Family
                            </a>
                            <a href="login/login.php" class="cta-button cta-secondary">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 style="font-family: 'Playfair Display', serif; color: var(--text-brown); font-size: 2.5rem; margin-bottom: 1rem;">
                        <i class="fas fa-fire" style="color: var(--primary-orange);"></i> Why Choose Us?
                    </h2>
                    <p style="color: var(--warm-brown); font-size: 1.1rem; max-width: 600px; margin: 0 auto;">
                        Experience authentic African cuisine with modern convenience and exceptional service.
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-pepper-hot"></i>
                        </div>
                        <h3 class="feature-title">Authentic Flavors</h3>
                        <p class="feature-description">
                            Traditional recipes passed down through generations, using authentic spices and cooking methods.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3 class="feature-title">Fresh Ingredients</h3>
                        <p class="feature-description">
                            Fresh, locally-sourced ingredients combined with imported African spices for the perfect taste.
                        </p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3 class="feature-title">Fast Delivery</h3>
                        <p class="feature-description">
                            Hot, delicious meals delivered to your doorstep in 30 minutes or less. Satisfaction guaranteed!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
