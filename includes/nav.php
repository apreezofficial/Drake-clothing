<?php
$currentTheme = 'theme'?? 'light';
?>
<!-- Navbar -->
<nav class="bg-white dark:bg-black border-b border-gray-200 dark:border-gray-800 fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Left section -->
            <div class="flex items-center">
                <!-- Mobile menu button -->
                <div class="mr-2 flex items-center sm:hidden">
                    <button id="mobile-menu-button" class="inline-flex items-center justify-center p-2 rounded-md text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>

                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold text-black dark:text-white">
                        DRAKE
                    </a>
                </div>

                <!-- Desktop navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                    <a href="/shop.php" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">Shop</a>
                    <a href="/collections.php" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">Collections</a>
                    <a href="/about.php" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">About</a>
                </div>
            </div>

            <!-- Right section -->
            <div class="flex items-center space-x-2">
              <!-- Desktop theme toggle -->
                <button id="theme-toggle" class="sm:block p-2 text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                    <i id="theme-icon" class="fas fa-moon"></i>
                </button>

                <!-- Account -->
                <a href="/track.php" class="p-2 text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                    <i class="fas fa-user"></i>
                </a>

                <!-- Cart -->
                <div class="relative">
                    <a href="/cart.php" class="p-2 text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                        <i class="fas fa-shopping-bag"></i>
                        <span class="cart-count absolute -top-1 -right-1 bg-black dark:bg-white text-white dark:text-black text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<!-- Sidebar Overlay -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300 z-40"></div>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed inset-y-0 left-0 z-50 hidden transform -translate-x-full sm:hidden bg-white dark:bg-black transition-transform duration-300 ease-in-out w-64 border-r border-gray-200 dark:border-gray-800">
    <div class="flex flex-col h-full p-4">
        <!-- Close button -->
        <div class="flex justify-end">
            <button id="close-sidebar" class="p-2 text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <!-- Sidebar content -->
        <div class="flex-1 flex flex-col space-y-6 mt-4">
            <a href="/" class="text-xl font-bold text-black dark:text-white mb-6">DRAKE</a>

            <a href="/shop.php" class="px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">Shop</a>
            <a href="/collections.php" class="px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">Collections</a>
            <a href="/about.php" class="px-3 py-2 rounded-md text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-900">About</a>

            <!-- Theme toggle -->
            <div class="mt-auto pt-6 border-t border-gray-200 dark:border-gray-800">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 dark:text-gray-300">Dark Mode</span>
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" id="sidebar-theme-toggle" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-300 peer-checked:bg-black dark:peer-checked:bg-white rounded-full relative transition-colors">
                            <div class="absolute left-1 top-1 bg-white dark:bg-black peer-checked:translate-x-5 transform transition-transform w-4 h-4 rounded-full"></div>
                        </div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navbar Script -->
<script>
    function getPreferredTheme() {
        const storedTheme = localStorage.getItem('theme');
        if (storedTheme) return storedTheme;
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    function applyTheme(theme) {
        const html = document.documentElement;
        const themeIcon = document.getElementById('theme-icon');

        if (theme === 'dark') {
            html.classList.add('dark');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
            document.getElementById('sidebar-theme-toggle').checked = true;
        } else {
            html.classList.remove('dark');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
            document.getElementById('sidebar-theme-toggle').checked = false;
        }
    }

    const currentTheme = getPreferredTheme();
    applyTheme(currentTheme);

    function toggleTheme() {
        const html = document.documentElement;
        const newTheme = html.classList.contains('dark') ? 'light' : 'dark';
        applyTheme(newTheme);
        localStorage.setItem('theme', newTheme);
    }

    document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
    document.getElementById('sidebar-theme-toggle').addEventListener('change', toggleTheme);

    document.getElementById('mobile-menu-button').addEventListener('click', function () {
        document.getElementById('mobile-sidebar').classList.remove('hidden', '-translate-x-full');
        document.getElementById('sidebar-overlay').classList.remove('opacity-0', 'pointer-events-none');
    });

    document.getElementById('close-sidebar').addEventListener('click', function () {
        document.getElementById('mobile-sidebar').classList.add('-translate-x-full');
        document.getElementById('sidebar-overlay').classList.add('opacity-0', 'pointer-events-none');
        setTimeout(() => document.getElementById('mobile-sidebar').classList.add('hidden'), 300);
    });

    document.getElementById('sidebar-overlay').addEventListener('click', function () {
        document.getElementById('mobile-sidebar').classList.add('-translate-x-full');
        this.classList.add('opacity-0', 'pointer-events-none');
        setTimeout(() => document.getElementById('mobile-sidebar').classList.add('hidden'), 300);
    });

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
        if (!localStorage.getItem('theme')) {
            applyTheme(e.matches ? 'dark' : 'light');
        }
    });
</script>