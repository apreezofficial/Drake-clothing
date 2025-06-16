    <!-- Navbar -->
    <nav class="bg-white dark:bg-black border-b border-gray-200 dark:border-gray-800 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left section - Logo and links -->
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
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="/shop" class="border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Shop
                        </a>
                        <a href="/collections" class="border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Collections
                        </a>
                        <a href="/about" class="border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            About
                        </a>
                    </div>
                </div>
                
                <!-- Right section - Search, theme toggle, cart -->
                <div class="flex items-center">
                    <!-- Search button -->
                    <button class="p-2 text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                        <i class="fas fa-search"></i>
                    </button>
                    
                    <!-- Theme toggle -->
                    <button id="theme-toggle" class="p-2 text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                        <i class="fas <?php echo $currentTheme === 'dark' ? 'fa-sun' : 'fa-moon'; ?>"></i>
                    </button>
                    
                    <!-- Account -->
                    <a href="/account" class="p-2 text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                        <i class="fas fa-user"></i>
                    </a>
                    
                    <!-- Cart -->
                    <div class="ml-4 flow-root lg:ml-6 relative">
                        <a href="/cart" class="p-2 text-black dark:text-white hover:bg-gray-100 dark:hover:bg-gray-900 rounded-md">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="cart-count absolute -top-1 -right-1 bg-black dark:bg-white text-white dark:text-black text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="sm:hidden hidden bg-white dark:bg-black border-t border-gray-200 dark:border-gray-800">
            <div class="pt-2 pb-3 space-y-1">
                <a href="/shop" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-900 hover:border-gray-300">Shop</a>
                <a href="/collections" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-900 hover:border-gray-300">Collections</a>
                <a href="/about" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-900 hover:border-gray-300">About</a>
            </div>
        </div>
    </nav>