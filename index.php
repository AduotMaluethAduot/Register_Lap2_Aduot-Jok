<?php
// Use the enhanced session management from core.php
require_once 'settings/core.php';
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
	<style>
		:root {
			/* Restaurant Color Palette - Appetite Stimulating */
			--primary-orange: #FF6B35;
			--secondary-red: #D2001C;
			--accent-yellow: #FFB700;
			--background-cream: #FFF8F0;
			--text-brown: #2D1B12;
			--light-orange: #FFE5D9;
			--dark-orange: #E55A2B;
			--warm-brown: #8B4513;
		}
		
		body {
			background: linear-gradient(135deg, var(--background-cream) 0%, var(--light-orange) 100%);
			font-family: 'Open Sans', sans-serif;
			color: var(--text-brown);
			min-height: 100vh;
			margin: 0;
		}
		
		/* Hero Section with Animated Background */
		.hero-section {
			background: linear-gradient(rgba(255, 107, 53, 0.9), rgba(210, 0, 28, 0.8)), 
						url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="%23FFB700" opacity="0.1"><polygon points="0,100 0,0 50,0 100,100"/><polygon points="100,100 100,0 150,0 200,100"/><polygon points="200,100 200,0 250,0 300,100"/><polygon points="300,100 300,0 350,0 400,100"/><polygon points="400,100 400,0 450,0 500,100"/><polygon points="500,100 500,0 550,0 600,100"/><polygon points="600,100 600,0 650,0 700,100"/><polygon points="700,100 700,0 750,0 800,100"/><polygon points="800,100 800,0 850,0 900,100"/><polygon points="900,100 900,0 950,0 1000,100"/></svg>');
			padding: 100px 0 80px;
			position: relative;
			overflow: hidden;
		}
		
		.hero-section::before {
			content: '';
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60" fill="%23FFB700" opacity="0.05"><circle cx="30" cy="30" r="2"/><circle cx="10" cy="10" r="1"/><circle cx="50" cy="10" r="1"/><circle cx="10" cy="50" r="1"/><circle cx="50" cy="50" r="1"/></svg>');
			animation: float 20s ease-in-out infinite;
		}
		
		@keyframes float {
			0%, 100% { transform: translateY(0px); }
			50% { transform: translateY(-10px); }
		}
		
		/* Navigation Menu */
		.menu-tray {
			position: fixed;
			top: 20px;
			right: 20px;
			background: rgba(255, 248, 240, 0.95);
			border: 2px solid var(--accent-yellow);
			border-radius: 15px;
			padding: 12px 20px;
			box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
			z-index: 1000;
			backdrop-filter: blur(10px);
			transition: all 0.3s ease;
		}
		
		.menu-tray:hover {
			transform: translateY(-2px);
			box-shadow: 0 12px 35px rgba(255, 107, 53, 0.4);
		}
		
		.menu-tray .btn {
			margin-left: 8px;
			border-radius: 8px;
			font-weight: 600;
			transition: all 0.3s ease;
			padding: 6px 16px;
		}
		
		.btn-primary-custom {
			background: var(--primary-orange);
			border: 2px solid var(--primary-orange);
			color: white;
		}
		
		.btn-primary-custom:hover {
			background: var(--dark-orange);
			border-color: var(--dark-orange);
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(255, 107, 53, 0.4);
		}
		
		.btn-secondary-custom {
			background: transparent;
			border: 2px solid var(--secondary-red);
			color: var(--secondary-red);
		}
		
		.btn-secondary-custom:hover {
			background: var(--secondary-red);
			border-color: var(--secondary-red);
			color: white;
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(210, 0, 28, 0.4);
		}
		
		.btn-danger-custom {
			background: var(--secondary-red);
			border: 2px solid var(--secondary-red);
			color: white;
		}
		
		.btn-danger-custom:hover {
			background: #B8001A;
			border-color: #B8001A;
			transform: translateY(-2px);
			box-shadow: 0 5px 15px rgba(210, 0, 28, 0.4);
		}
		
		.welcome-message {
			color: var(--warm-brown);
			font-weight: 600;
			font-size: 0.95rem;
		}
		
		/* Main Content */
		.hero-content {
			position: relative;
			z-index: 2;
		}
		
		.hero-title {
			font-family: 'Playfair Display', serif;
			font-size: 4.5rem;
			font-weight: 700;
			color: white;
			text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.3);
			margin-bottom: 1rem;
			animation: slideInUp 1s ease-out;
		}
		
		.hero-subtitle {
			font-size: 1.4rem;
			color: var(--light-orange);
			margin-bottom: 2rem;
			font-weight: 300;
			animation: slideInUp 1s ease-out 0.2s both;
		}
		
		.hero-description {
			font-size: 1.1rem;
			color: rgba(255, 255, 255, 0.9);
			max-width: 600px;
			margin: 0 auto 2.5rem;
			line-height: 1.6;
			animation: slideInUp 1s ease-out 0.4s both;
		}
		
		@keyframes slideInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}
			to {
				opacity: 1;
				transform: translateY(0);
			}
		}
		
		/* Feature Cards */
		.features-section {
			padding: 80px 0;
			background: var(--background-cream);
		}
		
		.feature-card {
			background: white;
			border-radius: 20px;
			padding: 40px 30px;
			text-align: center;
			box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
			transition: all 0.3s ease;
			border: 1px solid rgba(255, 107, 53, 0.1);
			height: 100%;
		}
		
		.feature-card:hover {
			transform: translateY(-10px);
			box-shadow: 0 20px 40px rgba(255, 107, 53, 0.2);
			border-color: var(--accent-yellow);
		}
		
		.feature-icon {
			font-size: 3rem;
			color: var(--primary-orange);
			margin-bottom: 1.5rem;
			display: inline-block;
			padding: 20px;
			background: var(--light-orange);
			border-radius: 50%;
			transition: all 0.3s ease;
		}
		
		.feature-card:hover .feature-icon {
			transform: scale(1.1);
			background: var(--accent-yellow);
			color: var(--text-brown);
		}
		
		.feature-title {
			font-family: 'Playfair Display', serif;
			font-size: 1.5rem;
			font-weight: 600;
			color: var(--text-brown);
			margin-bottom: 1rem;
		}
		
		.feature-description {
			color: var(--warm-brown);
			line-height: 1.6;
			font-size: 1rem;
		}
		
		/* CTA Buttons */
		.cta-button {
			display: inline-block;
			padding: 15px 35px;
			background: var(--accent-yellow);
			color: var(--text-brown);
			text-decoration: none;
			border-radius: 50px;
			font-weight: 600;
			font-size: 1.1rem;
			transition: all 0.3s ease;
			box-shadow: 0 5px 15px rgba(255, 183, 0, 0.3);
			margin: 0 10px;
			animation: slideInUp 1s ease-out 0.6s both;
		}
		
		.cta-button:hover {
			transform: translateY(-3px);
			box-shadow: 0 8px 25px rgba(255, 183, 0, 0.4);
			background: #E5A600;
			color: var(--text-brown);
		}
		
		.cta-secondary {
			background: transparent;
			border: 2px solid white;
			color: white;
		}
		
		.cta-secondary:hover {
			background: white;
			color: var(--primary-orange);
		}
		
		/* Responsive Design */
		@media (max-width: 768px) {
			.hero-title {
				font-size: 3rem;
			}
			
			.hero-subtitle {
				font-size: 1.2rem;
			}
			
			.menu-tray {
				top: 10px;
				right: 10px;
				padding: 8px 12px;
			}
			
			.cta-button {
				display: block;
				margin: 10px auto;
				text-align: center;
				max-width: 280px;
			}
		}
		
		/* Custom Animations */
		.pulse-animation {
			animation: pulse 2s infinite;
		}
		
		@keyframes pulse {
			0% { box-shadow: 0 0 0 0 rgba(255, 107, 53, 0.7); }
			70% { box-shadow: 0 0 0 10px rgba(255, 107, 53, 0); }
			100% { box-shadow: 0 0 0 0 rgba(255, 107, 53, 0); }
		}
	</style>
</head>
<body>
	<!-- Navigation Menu -->
	<div class="menu-tray">
		<i class="fas fa-utensils me-2" style="color: var(--primary-orange);"></i>
		<?php if (is_user_logged_in()): ?>
			<span class="welcome-message me-2">
				<i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars(get_user_name()); ?>!
				<?php if (is_user_admin()): ?>
					<span style="color: var(--accent-yellow); font-weight: bold;">
						<i class="fas fa-crown"></i> Admin
					</span>
				<?php endif; ?>
			</span>
			<?php if (is_user_admin()): ?>
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
							Welcome back, <strong><?php echo htmlspecialchars(get_user_name()); ?></strong>! 
							<?php if (is_user_admin()): ?>
								<span style="color: var(--accent-yellow);">You have administrative privileges.</span>
							<?php endif; ?>
							Ready to explore more delicious African cuisine?
						</div>
						<div class="mt-4">
							<?php if (is_user_admin()): ?>
								<a href="admin/dashboard.php" class="cta-button pulse-animation">
									<i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
								</a>
							<?php endif; ?>
							<a href="#menu" class="cta-button <?php echo is_user_admin() ? 'cta-secondary' : 'pulse-animation'; ?>">
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
