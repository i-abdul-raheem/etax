<header class="bg-white shadow-lg sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="index.php" class="flex items-center">
                    <div class="w-20 h-10 flex items-center justify-center mr-3">
                        <img src="../assets/img/logo-md.png" alt="">
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-green-500 bg-clip-text text-transparent">
                        <?php echo SITE_NAME; ?>
                    </span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8">
                    <a href="index.php" class="text-gray-900 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Home
                    </a>
                    <a href="services.php" class="text-gray-900 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Services
                    </a>
                    <a href="about.php" class="text-gray-900 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        About
                    </a>
                    <a href="blog.php" class="text-gray-900 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Blog
                    </a>
                    <a href="contact.php" class="text-gray-900 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Contact
                    </a>
                    <?php if (isLoggedIn()): ?>
                        <a href="dashboard/" class="text-gray-900 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            Dashboard
                        </a>
                        <a href="logout.php" class="text-gray-900 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="text-gray-900 hover:text-purple-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button" class="mobile-menu-button bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500">
                    <span class="sr-only">Open main menu</span>
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 border-t border-gray-200">
                <a href="index.php" class="text-gray-900 hover:text-purple-600 block px-3 py-2 rounded-md text-base font-medium transition-colors">
                    Home
                </a>
                <a href="services.php" class="text-gray-900 hover:text-purple-600 block px-3 py-2 rounded-md text-base font-medium transition-colors">
                    Services
                </a>
                <a href="about.php" class="text-gray-900 hover:text-purple-600 block px-3 py-2 rounded-md text-base font-medium transition-colors">
                    About
                </a>
                <a href="blog.php" class="text-gray-900 hover:text-purple-600 block px-3 py-2 rounded-md text-base font-medium transition-colors">
                    Blog
                </a>
                <a href="contact.php" class="text-gray-900 hover:text-purple-600 block px-3 py-2 rounded-md text-base font-medium transition-colors">
                    Contact
                </a>
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard/" class="text-gray-900 hover:text-purple-600 block px-3 py-2 rounded-md text-base font-medium transition-colors">
                        Dashboard
                    </a>
                    <a href="logout.php" class="text-gray-900 hover:text-red-600 block px-3 py-2 rounded-md text-base font-medium transition-colors">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="text-gray-900 hover:text-purple-600 block px-3 py-2 rounded-md text-base font-medium transition-colors">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<script>
// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
</script>
