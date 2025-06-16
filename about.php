<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Drake Clothing Store</title>
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
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Georgia', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .bg-pattern {
            background-image: 
                linear-gradient(to right, rgba(0,0,0,0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(0,0,0,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .dark .bg-pattern {
            background-image: 
                linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);
        }
        .timeline-item:not(:last-child):after {
            content: '';
            @apply absolute left-0 bottom-0 w-full h-px bg-gray-200 dark:bg-gray-800;
        }
    </style>
</head>
<body class="bg-white dark:bg-black text-gray-800 dark:text-gray-200 font-sans">
<?php include './includes/nav.php';?>
<!-- Hero Section -->
<header class="pt-32 pb-20 bg-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-black dark:text-white mb-6">
                <span class="block">OUR STORY</span>
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                Founded in 2023, Drake redefines modern essentials through intentional design and uncompromising quality.
            </p>
        </div>
    </div>
</header>

<!-- Philosophy Section -->
<section class="py-20 border-t border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:flex items-center gap-16">
            <div class="lg:w-1/2 mb-12 lg:mb-0">
                <div class="aspect-w-16 aspect-h-9 bg-gray-100 dark:bg-gray-900 overflow-hidden rounded-lg">
                    <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-800">
                      
<img src="https://media2.dev.to/dynamic/image/width=320,height=320,fit=cover,gravity=auto,format=auto/https%3A%2F%2Fdev-to-uploads.s3.amazonaws.com%2Fuploads%2Fuser%2Fprofile_image%2F2856590%2F5ab16ff7-2818-4af6-9253-948bf62d2d83.jpg">
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2">
                <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-4 block">Philosophy</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-6">INTENTIONAL DESIGN</h2>
                <div class="space-y-6 text-gray-600 dark:text-gray-300">
                    <p>
                        At Drake, we believe clothing should solve problems, not create them. Each piece is designed to 
                        eliminate decision fatigue while elevating your everyday.
                    </p>
                    <p>
                        Our founder's background in architecture informs our approach—every seam, stitch, and silhouette 
                        serves a purpose.
                    </p>
                    <p class="font-serif italic text-lg">
                        "We don't follow trends. We create clothes that outlast them."
                    </p>
                    <div class="pt-6 border-t border-gray-200 dark:border-gray-800">
                        <p class="text-sm uppercase tracking-widest">Precious, Founder</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Timeline Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 block">Journey</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">OUR TIMELINE</h2>
            <div class="w-20 h-px bg-black dark:bg-white mx-auto"></div>
        </div>

        <div class="max-w-3xl mx-auto space-y-12">
            <!-- Timeline Item 1 -->
            <div class="relative timeline-item pb-12 pl-8">
                <div class="absolute left-0 top-1 w-4 h-4 rounded-full bg-black dark:bg-white border-4 border-gray-50 dark:border-gray-900"></div>
                <div>
                    <h3 class="text-xl font-bold text-black dark:text-white mb-2">2023 - Foundation</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Launched with 12 essential pieces after two years of material research and prototype development.
                    </p>
                </div>
            </div>

            <!-- Timeline Item 2 -->
            <div class="relative timeline-item pb-12 pl-8">
                <div class="absolute left-0 top-1 w-4 h-4 rounded-full bg-black dark:bg-white border-4 border-gray-50 dark:border-gray-900"></div>
                <div>
                    <h3 class="text-xl font-bold text-black dark:text-white mb-2">2024 - Expansion</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Introduced womenswear and opened our flagship store in New York. Featured in Vogue and GQ.
                    </p>
                </div>
            </div>

            <!-- Timeline Item 3 -->
            <div class="relative pl-8">
                <div class="absolute left-0 top-1 w-4 h-4 rounded-full bg-black dark:bg-white border-4 border-gray-50 dark:border-gray-900"></div>
                <div>
                    <h3 class="text-xl font-bold text-black dark:text-white mb-2">2025 - Sustainability</h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Achieved 100% sustainable sourcing and launched our recycling program. Winner of Ethical Fashion Award.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-20 border-t border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 block">People</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">MEET THE TEAM</h2>
            <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                A collective of designers, artisans, and innovators committed to redefining modern clothing.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Team Member 1 -->
            <div class="text-center">
                <div class="aspect-square bg-gray-100 dark:bg-gray-900 rounded-full overflow-hidden mb-6 mx-auto w-3/4">
                    <!-- Team member image placeholder -->
                    <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-800">
<img src="https://preciousadedokun.com.ng/images/ap.jpg">
                    </div>
                </div>
                <h3 class="text-xl font-bold text-black dark:text-white mb-1">Precious Adedokun</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Creative Director</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 max-w-xs mx-auto">
                    Former head designer at Acne Studios. Leads our design philosophy.
                </p>
            </div>

            <!-- Team Member 2 -->
            <div class="text-center">
                <div class="aspect-square bg-gray-100 dark:bg-gray-900 rounded-full overflow-hidden mb-6 mx-auto w-3/4">
                    <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-800">
                        <span class="text-gray-400 dark:text-gray-600">MJ</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-black dark:text-white mb-1">Marcus Johnson</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Head of Production</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 max-w-xs mx-auto">
                    15 years experience in Italian textile manufacturing.
                </p>
            </div>

            <!-- Team Member 3 -->
            <div class="text-center">
                <div class="aspect-square bg-gray-100 dark:bg-gray-900 rounded-full overflow-hidden mb-6 mx-auto w-3/4">
                    <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-800">
                        <span class="text-gray-400 dark:text-gray-600">SR</span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-black dark:text-white mb-1">Sarah Rivera</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Sustainability Lead</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 max-w-xs mx-auto">
                    Pioneered our ethical sourcing initiatives.
                </p>
            </div>

            <!-- Team Member 4 -->
            <div class="text-center">
                <div class="aspect-square bg-gray-100 dark:bg-gray-900 rounded-full overflow-hidden mb-6 mx-auto w-3/4">
                    <div class="w-full h-full flex items-center justify-center bg-gray-200 dark:bg-gray-800">
<img src="https://avatars.githubusercontent.com/u/183222252?v=4">
                    </div>
                </div>
                <h3 class="text-xl font-bold text-black dark:text-white mb-1">Samuel Tuoyo</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Customer Experience</p>
                <p class="text-sm text-gray-600 dark:text-gray-300 max-w-xs mx-auto">
                    Ensures every interaction reflects our values.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <span class="text-xs uppercase tracking-widest text-gray-500 dark:text-gray-400 mb-2 block">Commitment</span>
            <h2 class="text-3xl sm:text-4xl font-bold text-black dark:text-white mb-4">OUR VALUES</h2>
            <div class="w-20 h-px bg-black dark:bg-white mx-auto"></div>
        </div>

        <div class="grid md:grid-cols-3 gap-12">
            <!-- Value 1 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-black dark:bg-white text-white dark:text-black rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-tshirt text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-black dark:text-white mb-3">Quality First</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    We source only the finest materials and subject every piece to rigorous quality control.
                </p>
            </div>

            <!-- Value 2 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-black dark:bg-white text-white dark:text-black rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-leaf text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-black dark:text-white mb-3">Ethical Practice</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    From farm to factory to closet, we ensure fair treatment at every stage of production.
                </p>
            </div>

            <!-- Value 3 -->
            <div class="text-center">
                <div class="w-16 h-16 bg-black dark:bg-white text-white dark:text-black rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-pen-fancy text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-black dark:text-white mb-3">Timeless Design</h3>
                <p class="text-gray-600 dark:text-gray-300">
                    We create clothes meant to last years, not just seasons, through thoughtful design.
                </p>
            </div>
        </div>
    </div>
</section>
<?php include './includes/footer.php';?>
</body>
</html>