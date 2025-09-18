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
    <title>About Us - <?php echo SITE_NAME; ?> Pakistan</title>
    <meta name="description" content="Learn about <?php echo SITE_NAME; ?> Pakistan, our 20+ years of experience in tax consultancy, and our commitment to providing expert tax solutions across Pakistan.">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo-md.png">
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

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                About <span class="text-green-300"><?php echo SITE_NAME; ?></span>
            </h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto">
                Pakistan's leading tax consultancy firm with over 6 years of experience 
                in providing comprehensive tax solutions to businesses and individuals.
            </p>
        </div>
    </section>

    <!-- Company Story -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Our <span class="text-purple-600">Story</span>
                    </h2>
                    
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        Founded in 2019, <?php echo SITE_NAME; ?> has been at the forefront of tax consultancy in Pakistan, 
                        helping hundreds of clients navigate the complex landscape of Pakistani taxation.
                    </p>
                    
                    <p class="text-lg text-gray-600 mb-6 leading-relaxed">
                        What started as a small practice has grown into one of Pakistan's most trusted 
                        tax consultancy firms..
                    </p>
                    
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed">
                        Our mission is to provide expert tax advice that not only ensures compliance 
                        but also optimizes our clients' tax positions, helping them achieve their 
                        financial goals while staying within the bounds of the law.
                    </p>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-2">6+</div>
                            <div class="text-gray-600">Years Experience</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600 mb-2">1000+</div>
                            <div class="text-gray-600">Happy Clients</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-gradient-to-br from-purple-50 to-green-50 rounded-2xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Our Values</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-shield-alt text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Integrity</h4>
                                    <p class="text-sm text-gray-600">We maintain the highest ethical standards in all our dealings.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-star text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Excellence</h4>
                                    <p class="text-sm text-gray-600">We strive for excellence in every aspect of our service delivery.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-users text-purple-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Client Focus</h4>
                                    <p class="text-sm text-gray-600">Our clients' success is our primary objective.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class="fas fa-lightbulb text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-1">Innovation</h4>
                                    <p class="text-sm text-gray-600">We continuously innovate to provide better solutions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative elements -->
                    <div class="absolute -top-4 -right-4 w-20 h-20 bg-purple-200 rounded-full opacity-20"></div>
                    <div class="absolute -bottom-4 -left-4 w-16 h-16 bg-green-200 rounded-full opacity-20"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Why Choose <span class="text-purple-600"><?php echo SITE_NAME; ?></span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We combine deep legal expertise with practical business understanding to deliver 
                    exceptional results for our clients.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-gavel text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Legal Expertise</h3>
                    <p class="text-gray-600">Our team includes qualified lawyers with specialized knowledge in tax law.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-clock text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Swift Response</h3>
                    <p class="text-gray-600">Known for our speed and efficiency in handling complex tax matters.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-headset text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">24/7 Support</h3>
                    <p class="text-gray-600">Round-the-clock support to assist you anytime, anywhere in Pakistan.</p>
                </div>
                
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-trophy text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Proven Track Record</h3>
                    <p class="text-gray-600">Successfully handled thousands of cases with high success rates.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Our <span class="text-purple-600">Leadership</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Meet the experienced professionals who lead our team and drive our success.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                        <i class="fas fa-user-tie text-purple-600 text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Ubaid ur Rehman</h3>
                        <p class="text-purple-600 font-medium mb-3">Founder & Chief Advisor</p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            With over 6 years of experience in tax law, Mr. Ubaid is a leading expert 
                            in Pakistani taxation and has successfully represented clients in numerous 
                            high-profile cases.
                        </p>
                    </div>
                </div>
                
                <!-- <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                        <i class="fas fa-user-graduate text-purple-600 text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Senior Associates</h3>
                        <p class="text-purple-600 font-medium mb-3">Expert Tax Professionals</p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Our team of senior associates brings specialized expertise in various 
                            areas of taxation, ensuring comprehensive solutions for all client needs.
                        </p>
                    </div>
                </div> -->
                
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-48 bg-gradient-to-br from-purple-100 to-purple-200 flex items-center justify-center">
                        <i class="fas fa-users text-purple-600 text-6xl"></i>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Support Team</h3>
                        <p class="text-purple-600 font-medium mb-3">Dedicated Professionals</p>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            Our support team ensures smooth operations and provides excellent 
                            client service, maintaining the high standards <?php echo SITE_NAME; ?> is known for.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Office Locations -->
    <!-- <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Our <span class="text-purple-600">Offices</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Strategically located across Pakistan to serve our clients nationwide.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                <div class="bg-white rounded-xl p-6 text-center shadow-lg hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Multan</h3>
                    <p class="text-gray-600 text-sm mb-3">2nd Floor, Ghazi Tower of Khan Center Abdali Road</p>
                    <p class="text-purple-600 font-medium">+92 305 414 3542</p>
                </div>
            </div>
        </div>
    </section> -->

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-purple-600 to-purple-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Work With Us?
            </h2>
            <p class="text-xl text-purple-100 mb-8">
                Join thousands of satisfied clients who trust <?php echo SITE_NAME; ?> with their tax matters. 
                Get started with a free consultation today.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo MEETING_LINK; ?>" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg">
                    Get Free Consultation
                </a>
                <a href="services.php" class="bg-white/20 hover:bg-white/30 text-white font-medium py-4 px-8 rounded-lg text-lg border-2 border-white/30 transition-all duration-200">
                    View Services
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
</body>
</html>
