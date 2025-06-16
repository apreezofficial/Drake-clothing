<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check current theme - default to light
$currentTheme = $_SESSION['theme'] ?? 'light';
?>

<!DOCTYPE html>
<html lang="en" class="<?php echo $currentTheme === 'dark' ? 'dark' : ''; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drake Clothing Store</title>
    <script src="/tailwind.js"></script>
    <link rel="stylesheet" href="includes/font-awesome/css/all.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        drake: {
                            light: '#ffffff',
                            dark: '#000000',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-drake-light dark:bg-drake-dark transition-colors duration-300">
<?php include './includes/nav.php';?>
<div style="height:100px;"></div>
<!-- Hero Section -->
<section class="relative bg-white dark:bg-black min-h-[80vh] flex items-center overflow-hidden">
    <!-- Square grid background -->
    <div class="absolute inset-0 grid grid-cols-8 grid-rows-6 gap-px overflow-hidden opacity-10 dark:opacity-[0.08]">
        <!-- Generate grid cells -->
        <?php for ($i = 0; $i < 48; $i++): ?>
            <div class="bg-black dark:bg-white"></div>
        <?php endfor; ?>
    </div>

    <!-- Animated floating squares -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-16 h-16 border border-black dark:border-white opacity-20 animate-float-1"></div>
        <div class="absolute top-1/3 right-1/4 w-12 h-12 border border-black dark:border-white opacity-20 animate-float-2"></div>
        <div class="absolute bottom-1/4 right-1/3 w-10 h-10 border border-black dark:border-white opacity-20 animate-float-3"></div>
    </div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center relative z-10">
<div class="max-w-3xl mx-auto">
    <!-- Brand Mark -->
    <div class="mb-2">
        <span class="text-xs tracking-[0.5em] text-gray-500 dark:text-gray-400">EST. <?php echo date('Y');?></span>
    </div>

    <!-- Main Heading -->
    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-bold text-black dark:text-white mb-4 leading-tight">
        <span class="block">DRESS YOUR</span>
        <span class="block">OWN RHYTHM</span>
    </h1>

    <!-- Subheading -->
    <div class="font-serif italic text-xl text-gray-600 dark:text-gray-300 mb-8">
        "Drake isn’t just fashion — it’s your statement."
    </div>

    <!-- Description -->
    <p class="text-lg text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
        Clean cuts. Bold fits. Drake is where comfort meets cool — crafted for those who wear their vibe.
    </p>

    <!-- CTA Buttons -->
    <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
        <a href="/new-arrivals" class="px-8 py-3 bg-black dark:bg-white text-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors duration-300 text-sm uppercase tracking-wider font-medium">
            Shop New Drops
        </a>
        <a href="/collections" class="px-8 py-3 border border-black dark:border-white text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-300 text-sm uppercase tracking-wider font-medium">
            Browse Collections
        </a>
    </div>

    <!-- Additional Elements -->
    <div class="text-xs uppercase tracking-widest text-gray-400 dark:text-gray-500 space-y-2">
        <div class="flex items-center justify-center space-x-4">
            <span>Free Worldwide Shipping</span>
            <span class="w-1 h-1 bg-gray-400 dark:bg-gray-500 rounded-full"></span>
            <span>Ethical Materials</span>
            <span class="w-1 h-1 bg-gray-400 dark:bg-gray-500 rounded-full"></span>
            <span>Built to Last</span>
        </div>
        <div class="mt-4">
            <span>Drop Alert: Summer '24 Out Now</span>
        </div>
    </div>
</div>
</div>
</section>

<style>
    /* Grid animation */
    @keyframes float-1 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(10px, 15px) rotate(5deg); }
    }
    @keyframes float-2 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-15px, 10px) rotate(-3deg); }
    }
    @keyframes float-3 {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(5px, -10px) rotate(2deg); }
    }
    
    .animate-float-1 {
        animation: float-1 8s ease-in-out infinite;
    }
    .animate-float-2 {
        animation: float-2 10s ease-in-out infinite;
    }
    .animate-float-3 {
        animation: float-3 12s ease-in-out infinite;
    }
</style>


</body>
</html>