<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DriveOffGrid - Let's go on a drive. Choose your group, pick your destination, and define your moments.">
    <title>DriveOffGrid - Let's go on a drive</title>
    <link rel="stylesheet" href="css/style.css?v=1">
    <link rel="stylesheet" href="css/landing.css?v=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body class="landing-page">

    <main class="landing-container">
        <!-- Title Section -->
        <h1 class="landing-title">
            Let's go on a <span class="title-accent">drive</span>...
        </h1>

        <!-- Steps Section -->
        <div class="steps-container">
            <!-- Step 1 -->
            <div class="step-card">
                <div class="step-icon">
                    <img src="assets/images/landing_page/step-1.png" alt="Step 1 - Choose your group" class="step-image" loading="eager">
                </div>
                <p class="step-text">
                    Step 1 - You choose <span class="text-accent">your own group</span>
                </p>
            </div>

            <!-- Step 2 -->
            <div class="step-card">
                <div class="step-icon">
                    <img src="assets/images/landing_page/step-2.png" alt="Step 2 - Pick a destination" class="step-image" loading="eager">
                </div>
                <p class="step-text">
                    Step 2 - You pick a point on the map <span class="text-accent">anywhere in the world</span>
                </p>
            </div>

            <!-- Step 3 -->
            <div class="step-card">
                <div class="step-icon">
                    <img src="assets/images/landing_page/step-3.png" alt="Step 3 - Define your moments" class="step-image" loading="eager">
                </div>
                <p class="step-text">
                    Step 3 - You define the moments, <span class="text-accent">you decide the pace</span>
                </p>
            </div>
        </div>

        <!-- Logo and Slogan Section -->
        <div class="brand-section">
            <div class="logo-container">
                <a href="<?php echo url_path('home'); ?>" class="logo-link" aria-label="Go to homepage">
                    <img src="assets/images/Logo/DoG Logo Final 22nd Jan 2024 1.png" alt="DriveOffGrid logo" class="brand-logo" loading="eager">
                    <!-- <span class="logo-text">driveoffgrid</span> -->
                </a>
            </div>
            <p class="brand-slogan">We make it happen!</p>
        </div>

        <!-- Call to Action Button -->
        <div class="cta-section">
            <a href="<?php echo url_path('home'); ?>" class="cta-button">Ready? Click on the logo</a>
        </div>
    </main>

    <script src="js/main.js"></script>
</body>
</html>

