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
<!-- Hero Section -->
<section class="relative bg-white dark:bg-black min-h-[80vh] flex items-center overflow-hidden">
    <!-- Concentric grid background -->
    <div class="absolute inset-0 flex items-center justify-center overflow-hidden">
        <div class="absolute w-[200%] h-[200%] opacity-[3%] dark:opacity-[2%]">
            <div class="absolute inset-0 bg-concentric-grid-black dark:bg-concentric-grid-white"></div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="relative">
            <!-- Text content with fashion alignment -->
            <div class="max-w-2xl mx-auto text-center">
                <div class="font-serif text-5xl sm:text-6xl lg:text-7xl font-light tracking-tight text-black dark:text-white space-y-2">
                    <div class="text-right -mr-10 sm:-mr-16">CURATED</div>
                    <div class="text-left -ml-8 sm:-ml-14">ELEGANCE</div>
                    <div class="text-right -mr-4 sm:-mr-8">REDEFINED</div>
                </div>
                <p class="mt-8 text-lg text-gray-600 dark:text-gray-300 max-w-md mx-auto font-sans">
                    Drake's signature collection blends timeless tailoring with contemporary silhouettes.
                </p>
                <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                    <a href="/shop/mens" class="px-8 py-3 border border-transparent text-sm uppercase tracking-wider font-medium rounded-sm text-white bg-black dark:bg-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200 transition-colors duration-300">
                        Shop Menswear
                    </a>
                    <a href="/shop/womens" class="px-8 py-3 border border-black dark:border-white text-sm uppercase tracking-wider font-medium rounded-sm text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 transition-colors duration-300">
                        Shop Womenswear
                    </a>
                </div>
            </div>

            <!-- Fashion label style badge -->
            <div class="absolute -right-4 -bottom-10 sm:right-10 sm:bottom-10 rotate-90 sm:rotate-0 origin-bottom-left text-xs tracking-widest text-gray-500 dark:text-gray-400 uppercase">
                Since 2023
            </div>
        </div>
    </div>
</section>

<style>
    .bg-concentric-grid-black {
        background-image: 
            radial-gradient(circle, rgba(0,0,0,0.1) 1px, transparent 1px);
        background-size: 30px 30px;
    }
    .bg-concentric-grid-white {
        background-image: 
            radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 30px 30px;
    }
    
    /* Optional animation for grid */
    @keyframes grid-move {
        0% { transform: translate(0,0); }
        100% { transform: translate(-15px,-15px); }
    }
    
    .animate-grid-move {
        animation: grid-move 20s linear infinite alternate;
    }
</style>

<script>
    // Add subtle grid animation
    document.addEventListener('DOMContentLoaded', function() {
        const grid = document.querySelector('.bg-concentric-grid-black, .bg-concentric-grid-white').parentElement;
        grid.classList.add('animate-grid-move');
    });
</script>
</body>
</html>