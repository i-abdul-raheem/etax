<?php
session_start();
require_once 'includes/config.sqlite.php';
require_once 'includes/db.sqlite.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_NAME; ?> Pakistan - Leading Tax Consultancy Services</title>
    <meta name="description" content="Pakistan's premier tax consultancy firm offering expert advice on income tax, sales tax, customs, and international taxation. Get free consultation today!">
    <meta name="keywords" content="tax consultancy, pakistan, income tax, sales tax, customs, international taxation, tax lawyer">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo-md.png">
    <link href="assets/css/style.css" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-D6ZLY3PMB4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-D6ZLY3PMB4');
</script>
</head>
<body class="font-sans antialiased">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-purple-50 via-white to-green-50">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-bold mb-6 text-balance">
                    Pakistan's Leading <span class="bg-gradient-to-r from-purple-600 to-green-500 bg-clip-text text-transparent">Tax Consultancy</span>
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-600 mb-8 max-w-3xl mx-auto leading-relaxed">
                    Expert tax advice for individuals and businesses. From individual taxation to corporate taxation, 
                    we provide comprehensive solutions with speed and precision.
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <a href="<?php echo MEETING_LINK; ?>" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg group">
                        Get Free Consultation
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="services.php" class="bg-white hover:bg-gray-50 text-purple-600 border-2 border-purple-600 font-medium py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg">
                        Our Services
                    </a>
                </div>

                <div class="flex flex-col sm:flex-row gap-6 justify-center items-center text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-phone text-purple-600"></i>
                        <span><?php echo SITE_PHONE; ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-envelope text-purple-600"></i>
                        <span><?php echo SITE_EMAIL; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2">
            <div class="w-6 h-10 border-2 border-gray-400 rounded-full flex justify-center">
                <div class="w-1 h-3 bg-gray-400 rounded-full mt-2 animate-bounce"></div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 to-purple-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-white/30 transition-colors">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold mb-2 group-hover:scale-110 transition-transform">1000+</div>
                    <div class="text-xl font-semibold mb-2">Happy Clients</div>
                    <div class="text-purple-100 text-sm">Satisfied customers across Pakistan</div>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-white/30 transition-colors">
                        <i class="fas fa-award text-2xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold mb-2 group-hover:scale-110 transition-transform">6+</div>
                    <div class="text-xl font-semibold mb-2">Years Experience</div>
                    <div class="text-purple-100 text-sm">Years of tax expertise</div>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-white/30 transition-colors">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold mb-2 group-hover:scale-110 transition-transform">24/7</div>
                    <div class="text-xl font-semibold mb-2">Support Available</div>
                    <div class="text-purple-100 text-sm">Round-the-clock assistance</div>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-white/30 transition-colors">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold mb-2 group-hover:scale-110 transition-transform">99%</div>
                    <div class="text-xl font-semibold mb-2">Success Rate</div>
                    <div class="text-purple-100 text-sm">Proven track record</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-bold mb-6">
                    Our <span class="bg-gradient-to-r from-purple-600 to-green-500 bg-clip-text text-transparent">Services</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Comprehensive tax solutions covering all aspects of taxation in Pakistan. 
                    From compliance to litigation, we're your one-window tax consultancy.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php
                $services = [
                    ['icon' => 'fas fa-user-tie', 'title' => 'Income Tax', 'description' => 'Personal tax planning and compliance for individuals and professionals.', 'features' => ['Personal Tax Returns', 'Tax Planning', 'Tax Refunds', 'Property Tax']],
                    ['icon' => 'fas fa-file-invoice', 'title' => 'Sales Tax', 'description' => 'Specialized services for sales tax, federal excise duty, and customs matters.', 'features' => ['Sales Tax Registration', 'Sales Tax Returns submission', '⁠⁠Invoice Management', 'Stock Portfolio Management']],
                    ['icon' => 'fas fa-globe', 'title' => 'Punjab Service Tax (PRA)', 'description' => 'Expert guidance on cross-border tax matters and international business.', 'features' => ['PRA Tax Registration', 'PRA Tax Returns submission', '⁠⁠Invoice Management', 'PRA Tax Guidance']],
                    ['icon' => 'fas fa-building', 'title' => 'Corporate Tax', 'description' => 'Comprehensive corporate tax solutions for businesses of all sizes.', 'features' => ['Corporate Structuring', 'Tax Optimization', 'Audit Support', 'Compliance Management']],
                    ['icon' => 'fas fa-gavel', 'title' => 'Litigation Services', 'description' => 'Preserve and protect your constitutional and legal rights through effective litigation in tax courts.', 'features' => ['Tax Appeals', 'Constitutional Petitions', 'High Court Representation', 'Supreme Court Cases']],
                    ['icon' => 'fas fa-calculator', 'title' => 'Tax Compliance', 'description' => 'Ensure timely and accurate fulfillment of all tax obligations under applicable laws.', 'features' => ['Tax Returns Filing', 'Compliance Audits', 'Tax Planning', 'Regulatory Compliance']],
                    ['icon' => 'fas fa-lightbulb', 'title' => 'Advisory Services', 'description' => 'Clear and creative tax advice for transactions, controversies, and legislation.', 'features' => ['Tax Strategy', 'Business Structuring', 'Tax Withholdings', 'Corporate Tax']],
                    ['icon' => 'fas fa-shield-alt', 'title' => 'Import Export (PSW)', 'description' => 'Ongoing priority consultancy and day-to-day tax advisory for businesses.', 'features' => ['⁠Import Export Registration', '⁠⁠Import Export Certificate', '⁠⁠Import Export Tax', 'Hassle-free transition']],
                ];

                foreach ($services as $service): ?>
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6 group">
                        <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-4 group-hover:bg-purple-200 transition-colors">
                            <i class="<?php echo $service['icon']; ?> text-purple-600 text-xl"></i>
                        </div>
                        
                        <h3 class="text-xl font-semibold mb-3 text-gray-900">
                            <?php echo $service['title']; ?>
                        </h3>
                        
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            <?php echo $service['description']; ?>
                        </p>
                        
                        <ul class="space-y-2">
                            <?php foreach ($service['features'] as $feature): ?>
                                <li class="flex items-center text-sm text-gray-500">
                                    <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                                    <?php echo $feature; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-16">
                <p class="text-lg text-gray-600 mb-6">
                    Need a specific service or have questions? Get in touch for a free consultation.
                </p>
                <a href="<?php echo MEETING_LINK; ?>" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg">
                    Get Free Consultation
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl md:text-5xl font-bold mb-6">
                        Why Choose <span class="bg-gradient-to-r from-purple-600 to-green-500 bg-clip-text text-transparent"><?php echo SITE_NAME; ?></span>
                    </h2>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        <?php echo SITE_NAME; ?> has been at the forefront of tax consultancy in Pakistan for over 6 years. 
                        Our team combines deep legal expertise with practical business understanding to deliver 
                        exceptional results for our clients.
                    </p>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        We believe in providing not just legal representation, but strategic partnership that 
                        helps our clients navigate the complex Pakistani tax landscape with confidence and success.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <?php
                        $features = [
                            ['icon' => 'fas fa-check-circle', 'title' => 'Competence', 'description' => 'We have the expertise to constitutionally challenge ultra vires exercises of power and obtain restraining orders from courts.'],
                            ['icon' => 'fas fa-star', 'title' => 'One-Window Operation', 'description' => 'Complete tax consultancy covering income tax, sales tax, customs, provincial taxes, and international taxation.'],
                            ['icon' => 'fas fa-shield-alt', 'title' => 'Experience', 'description' => 'Skilled team with capacity to contest cases at original and appellate forums up to High Court and Supreme Court.'],
                            ['icon' => 'fas fa-bolt', 'title' => 'Speed & Precision', 'description' => 'Known for swift response and effective solutions to complex legal issues with proven results.']
                        ];

                        foreach ($features as $feature): ?>
                            <div class="flex items-start gap-3">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="<?php echo $feature['icon']; ?> text-purple-600 text-sm"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1"><?php echo $feature['title']; ?></h4>
                                    <p class="text-sm text-gray-600 leading-relaxed"><?php echo $feature['description']; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-xl">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Client Testimonial</h3>
                            <div class="flex justify-center mb-4">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <i class="fas fa-star text-green-500"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <blockquote class="text-gray-600 italic mb-6 leading-relaxed">
                            "<?php echo SITE_NAME; ?> always offers effective solutions to complex legal issues. Their forte is their 
                            speed and swift response. We believe that they are the finest consultants a litigant can find 
                            in our legal system."
                        </blockquote>
                        
                        <div class="text-center">
                            <div class="font-semibold text-gray-900">Abdul Raheem</div>
                            <div class="text-sm text-gray-500">ARHEX Labs</div>
                        </div>
                    </div>
                    
                    <!-- Decorative elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-purple-200 rounded-full opacity-20"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-green-200 rounded-full opacity-20"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-purple-600 to-purple-800 text-white relative overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-full h-full bg-black/10"></div>
            <div class="absolute top-20 right-20 w-72 h-72 bg-white/5 rounded-full"></div>
            <div class="absolute bottom-20 left-20 w-72 h-72 bg-white/5 rounded-full"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-4xl md:text-6xl font-bold mb-6">
                    Get <span class="text-green-300">FREE</span> Tax Advice Today!
                </h2>
                
                <p class="text-xl md:text-2xl text-purple-100 mb-8 leading-relaxed">
                    <?php echo SITE_NAME; ?> offers you FREE consultation with our principal advocate to help you make 
                    informed legal decisions! No problem is too great!
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12">
                    <a href="contact.php" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg group">
                        Get Free Advice!
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="services.php" class="bg-white/20 hover:bg-white/30 text-white font-medium py-4 px-8 rounded-lg text-lg border-2 border-white/30 transition-all duration-200">
                        Learn More
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 max-w-4xl mx-auto">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-phone text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Call Us Now</h3>
                        <p class="text-purple-100"><?php echo SITE_PHONE; ?></p>
                    </div>
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Send Message</h3>
                        <p class="text-purple-100">+92 305 7612515</p>
                    </div>
                    
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-envelope text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">Email Us</h3>
                        <p class="text-purple-100"><?php echo SITE_EMAIL; ?></p>
                    </div>
                    
                    <div class="flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-clock text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
                        <p class="text-purple-100">Always Available</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
