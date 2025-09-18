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
    <title>Our Services - <?php echo SITE_NAME; ?> Pakistan</title>
    <meta name="description" content="Comprehensive tax consultancy services including litigation, compliance, advisory, and international taxation. Expert solutions for all your tax needs in Pakistan.">
    
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
                Our <span class="text-green-300">Services</span>
            </h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto">
                Comprehensive tax solutions covering all aspects of taxation in Pakistan. 
                From compliance to litigation, we're your one-window tax consultancy.
            </p>
        </div>
    </section>

    <!-- Services Overview -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Complete Tax Solutions
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We provide end-to-end tax consultancy services, ensuring your business 
                    stays compliant while optimizing your tax position.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $services = [
                    [
                        'id' => 'litigation',
                        'icon' => 'fas fa-gavel',
                        'title' => 'Litigation Services',
                        'description' => 'Preserve and protect your constitutional and legal rights through effective litigation in tax courts.',
                        'features' => ['Tax Appeals', 'Constitutional Petitions', 'High Court Representation', 'Supreme Court Cases', 'Tax Tribunal Cases'],
                        'color' => 'blue'
                    ],
                    [
                        'id' => 'compliance',
                        'icon' => 'fas fa-calculator',
                        'title' => 'Tax Compliance',
                        'description' => 'Ensure timely and accurate fulfillment of all tax obligations under applicable laws.',
                        'features' => ['Tax Returns Filing', 'Compliance Audits', 'Tax Planning', 'Regulatory Compliance', 'Deadline Management'],
                        'color' => 'green'
                    ],
                    [
                        'id' => 'advisory',
                        'icon' => 'fas fa-lightbulb',
                        'title' => 'Advisory Services',
                        'description' => 'Clear and creative tax advice for transactions, controversies, and legislation.',
                        'features' => ['Tax Strategy', 'Business Structuring', 'International Tax', 'Corporate Tax', 'Risk Assessment'],
                        'color' => 'yellow'
                    ],
                    [
                        'id' => 'retainer',
                        'icon' => 'fas fa-shield-alt',
                        'title' => 'Retainer Services',
                        'description' => 'Ongoing priority consultancy and day-to-day tax advisory for businesses.',
                        'features' => ['Monthly Retainers', 'Priority Support', 'Regular Consultations', 'Emergency Assistance', '24/7 Access'],
                        'color' => 'purple'
                    ],
                    [
                        'id' => 'corporate',
                        'icon' => 'fas fa-building',
                        'title' => 'Corporate Tax',
                        'description' => 'Comprehensive corporate tax solutions for businesses of all sizes.',
                        'features' => ['Corporate Structuring', 'Tax Optimization', 'Audit Support', 'Compliance Management', 'Mergers & Acquisitions'],
                        'color' => 'indigo'
                    ],
                    [
                        'id' => 'international',
                        'icon' => 'fas fa-globe',
                        'title' => 'International Taxation',
                        'description' => 'Expert guidance on cross-border tax matters and international business.',
                        'features' => ['Transfer Pricing', 'Double Taxation', 'Foreign Investment', 'International Compliance', 'Tax Treaties'],
                        'color' => 'red'
                    ]
                ];

                foreach ($services as $service): 
                    $colorClasses = [
                        'blue' => 'bg-purple-100 text-purple-600 hover:bg-purple-200',
                        'green' => 'bg-purple-100 text-purple-600 hover:bg-purple-200',
                        'yellow' => 'bg-green-100 text-green-600 hover:bg-green-200',
                        'purple' => 'bg-purple-100 text-purple-600 hover:bg-purple-200',
                        'indigo' => 'bg-indigo-100 text-indigo-600 hover:bg-indigo-200',
                        'red' => 'bg-red-100 text-red-600 hover:bg-red-200'
                    ];
                    $colorClass = $colorClasses[$service['color']];
                ?>
                    <div id="<?php echo $service['id']; ?>" class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6 group">
                        <div class="w-16 h-16 <?php echo $colorClass; ?> rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <i class="<?php echo $service['icon']; ?> text-2xl"></i>
                        </div>
                        
                        <h3 class="text-2xl font-semibold mb-4 text-gray-900">
                            <?php echo $service['title']; ?>
                        </h3>
                        
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            <?php echo $service['description']; ?>
                        </p>
                        
                        <ul class="space-y-3 mb-6">
                            <?php foreach ($service['features'] as $feature): ?>
                                <li class="flex items-center text-sm text-gray-600">
                                    <div class="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                                    <?php echo $feature; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <a href="contact.php?service=<?php echo urlencode($service['title']); ?>" 
                           class="inline-flex items-center text-purple-600 hover:text-purple-700 font-medium transition-colors">
                            Learn More <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Additional Services -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Specialized Tax Solutions
                    </h2>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-file-invoice text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Sales Tax & Customs</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Specialized services for sales tax, federal excise duty, and customs matters. 
                                    We handle registration, compliance, and dispute resolution.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-user-tie text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Individual Tax</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Personal tax planning and compliance for individuals and professionals. 
                                    We help optimize your tax position while ensuring full compliance.
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tax Planning</h3>
                                <p class="text-gray-600 leading-relaxed">
                                    Strategic tax planning to minimize your tax burden while remaining 
                                    compliant with all applicable laws and regulations.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="bg-white rounded-2xl p-8 shadow-xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Why Choose Our Services?</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-purple-600 text-sm"></i>
                                </div>
                                <span class="text-gray-700">20+ years of experience in tax consultancy</span>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-purple-600 text-sm"></i>
                                </div>
                                <span class="text-gray-700">Expert team of qualified tax professionals</span>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-purple-600 text-sm"></i>
                                </div>
                                <span class="text-gray-700">Proven track record of successful cases</span>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-purple-600 text-sm"></i>
                                </div>
                                <span class="text-gray-700">24/7 support and emergency assistance</span>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-purple-600 text-sm"></i>
                                </div>
                                <span class="text-gray-700">Competitive pricing with transparent fees</span>
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

    <!-- Process Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Our <span class="text-purple-600">Process</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We follow a systematic approach to ensure the best possible outcomes for our clients.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">1</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Initial Consultation</h3>
                    <p class="text-gray-600">Free consultation to understand your tax situation and requirements.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">2</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Analysis & Planning</h3>
                    <p class="text-gray-600">Comprehensive analysis and strategic planning for optimal solutions.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">3</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Implementation</h3>
                    <p class="text-gray-600">Expert execution of the planned strategy with regular updates.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl font-bold text-purple-600">4</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Ongoing Support</h3>
                    <p class="text-gray-600">Continuous support and monitoring to ensure long-term success.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-purple-600 to-purple-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Get Started?
            </h2>
            <p class="text-xl text-purple-100 mb-8">
                Contact us today for a free consultation and discover how we can help 
                optimize your tax position while ensuring full compliance.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo MEETING_LINK; ?>" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg">
                    Get Free Consultation
                </a>
                <a href="contact.php" class="bg-white/20 hover:bg-white/30 text-white font-medium py-4 px-8 rounded-lg text-lg border-2 border-white/30 transition-all duration-200">
                    Contact Us
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
