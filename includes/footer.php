<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="lg:col-span-2">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-purple-600 to-green-500 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-gavel text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold"><?php echo SITE_NAME; ?></span>
                </div>
                <p class="text-gray-300 mb-4 leading-relaxed">
                    Pakistan's leading tax consultancy firm with over 6 years of experience. 
                    We provide comprehensive tax solutions for individuals and businesses across Pakistan.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-linkedin text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li><a href="index.php" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                    <li><a href="services.php" class="text-gray-300 hover:text-white transition-colors">Services</a></li>
                    <li><a href="about.php" class="text-gray-300 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="blog.php" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="contact.php" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Our Services</h3>
                <ul class="space-y-2">
                    <li><a href="services.php#litigation" class="text-gray-300 hover:text-white transition-colors">Litigation</a></li>
                    <li><a href="services.php#compliance" class="text-gray-300 hover:text-white transition-colors">Tax Compliance</a></li>
                    <li><a href="services.php#advisory" class="text-gray-300 hover:text-white transition-colors">Advisory</a></li>
                    <li><a href="services.php#international" class="text-gray-300 hover:text-white transition-colors">International Tax</a></li>
                    <li><a href="services.php#corporate" class="text-gray-300 hover:text-white transition-colors">Corporate Tax</a></li>
                </ul>
            </div>
        </div>

        <!-- Office Locations -->
        <div class="mt-12 pt-8 border-t border-gray-800">
            <h3 class="text-lg font-semibold mb-6 text-center">Our Office</h3>
            <div class="grid grid-cols-1 gap-6">
                <div class="text-center">
                    <h4 class="font-semibold text-purple-400 mb-2">Multan</h4>
                    <p class="text-sm text-gray-300"><?php echo COMPANY_ADDRESS; ?></p>
                    <p class="text-sm text-gray-300 mt-1"><?php echo SITE_PHONE; ?></p>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="mt-12 pt-8 border-t border-gray-800 text-center">
            <p class="text-gray-400">
                &copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved. 
                <!-- | <a href="privacy.php" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a> | 
                <a href="terms.php" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a> -->
            </p>
        </div>
    </div>
</footer>
