<?php
session_start();
require_once 'includes/config.sqlite.php';
require_once 'includes/db.sqlite.php';

$success = '';
$error = '';

// Handle contact form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $company = sanitize($_POST['company']);
    $subject = sanitize($_POST['subject']);
    $message = sanitize($_POST['message']);
    $service = sanitize($_POST['service'] ?? '');
    
    // Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all required fields.';
    } elseif (!validateEmail($email)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            // Insert into database
            $data = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'company' => $company,
                'subject' => $subject,
                'message' => $message
            ];
            
            $db->insert('contact_submissions', $data);
            
            $success = 'Thank you for your message! We will get back to you within 24 hours.';
            
            // Clear form data
            $_POST = array();
            
        } catch (Exception $e) {
            $error = 'Sorry, there was an error sending your message. Please try again.';
        }
    }
}

// Get service from URL parameter
$selectedService = isset($_GET['service']) ? sanitize($_GET['service']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - eTax consultants Pakistan</title>
    <meta name="description" content="Get in touch with eTax consultants Pakistan for expert tax consultancy services. Contact us for free consultation and expert advice.">
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="font-sans antialiased">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                Get in <span class="text-yellow-300">Touch</span>
            </h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Ready to optimize your tax position? Contact us today for expert advice 
                and comprehensive tax solutions tailored to your needs.
            </p>
        </div>
    </section>

    <!-- Contact Form & Info -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <!-- Contact Form -->
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Send us a Message</h2>
                    
                    <?php if ($success): ?>
                        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span><?php echo htmlspecialchars($success); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-2"></i>
                                <span><?php echo htmlspecialchars($error); ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="contact.php" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    required
                                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your full name"
                                >
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your email"
                                >
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <input
                                    type="tel"
                                    id="phone"
                                    name="phone"
                                    value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your phone number"
                                >
                            </div>
                            
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                                    Company Name
                                </label>
                                <input
                                    type="text"
                                    id="company"
                                    name="company"
                                    value="<?php echo htmlspecialchars($_POST['company'] ?? ''); ?>"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                    placeholder="Enter your company name"
                                >
                            </div>
                        </div>

                        <div>
                            <label for="service" class="block text-sm font-medium text-gray-700 mb-2">
                                Service of Interest
                            </label>
                            <select
                                id="service"
                                name="service"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            >
                                <option value="">Select a service</option>
                                <option value="Litigation Services" <?php echo ($selectedService === 'Litigation Services') ? 'selected' : ''; ?>>Litigation Services</option>
                                <option value="Tax Compliance" <?php echo ($selectedService === 'Tax Compliance') ? 'selected' : ''; ?>>Tax Compliance</option>
                                <option value="Advisory Services" <?php echo ($selectedService === 'Advisory Services') ? 'selected' : ''; ?>>Advisory Services</option>
                                <option value="Retainer Services" <?php echo ($selectedService === 'Retainer Services') ? 'selected' : ''; ?>>Retainer Services</option>
                                <option value="Corporate Tax" <?php echo ($selectedService === 'Corporate Tax') ? 'selected' : ''; ?>>Corporate Tax</option>
                                <option value="International Taxation" <?php echo ($selectedService === 'International Taxation') ? 'selected' : ''; ?>>International Taxation</option>
                                <option value="Sales Tax & Customs" <?php echo ($selectedService === 'Sales Tax & Customs') ? 'selected' : ''; ?>>Sales Tax & Customs</option>
                                <option value="Individual Tax" <?php echo ($selectedService === 'Individual Tax') ? 'selected' : ''; ?>>Individual Tax</option>
                                <option value="Tax Planning" <?php echo ($selectedService === 'Tax Planning') ? 'selected' : ''; ?>>Tax Planning</option>
                                <option value="Other" <?php echo ($selectedService === 'Other') ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                Subject <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                required
                                value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                placeholder="Enter subject"
                            >
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                required
                                rows="5"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                                placeholder="Tell us about your tax needs..."
                            ><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                        </div>

                        <button
                            type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg"
                        >
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Message
                        </button>
                    </form>
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Quick Contact -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Quick Contact</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Main Office</p>
                                    <p class="font-semibold text-gray-900">+92 21 3582 1757</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-envelope text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="font-semibold text-gray-900">info@taxpulse-pakistan.com</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Business Hours</p>
                                    <p class="font-semibold text-gray-900">Mon - Fri: 9:00 AM - 6:00 PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Office Locations -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Our Offices</h3>
                        
                        <div class="space-y-6">
                            <div class="border-l-4 border-blue-500 pl-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Karachi (Head Office)</h4>
                                <p class="text-gray-600 text-sm mb-2">Suite No.14, 6th Floor, Rimpa Plaza, M.A Jinnah Road</p>
                                <p class="text-blue-600 font-medium text-sm">+92 21 3582 1757</p>
                            </div>
                            
                            <div class="border-l-4 border-green-500 pl-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Lahore</h4>
                                <p class="text-gray-600 text-sm mb-2">2nd Floor, Badar Centre, 5 Mclagon Road</p>
                                <p class="text-green-600 font-medium text-sm">+92-42-7122735</p>
                            </div>
                            
                            <div class="border-l-4 border-yellow-500 pl-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Islamabad</h4>
                                <p class="text-gray-600 text-sm mb-2">No. 1, Street 2, Sector G-11/1</p>
                                <p class="text-yellow-600 font-medium text-sm">+92 334 514 3163</p>
                            </div>
                            
                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Multan</h4>
                                <p class="text-gray-600 text-sm mb-2">2nd Floor, Ghazi Tower of Khan Center Abdali Road</p>
                                <p class="text-purple-600 font-medium text-sm">+92 305 414 3542</p>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-exclamation-triangle text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Emergency Support</h3>
                        <p class="text-red-100 mb-4">Need immediate assistance?</p>
                        <a href="tel:+923345143163" class="bg-white text-red-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                            Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                    Frequently Asked <span class="text-blue-600">Questions</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Get quick answers to common questions about our services.
                </p>
            </div>

            <div class="space-y-6">
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">How quickly can you respond to urgent tax matters?</h3>
                    <p class="text-gray-600">We pride ourselves on swift response times. For urgent matters, we typically respond within 2-4 hours during business hours.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Do you offer free initial consultations?</h3>
                    <p class="text-gray-600">Yes, we provide free initial consultations to understand your tax situation and discuss how we can help you.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">What areas of taxation do you specialize in?</h3>
                    <p class="text-gray-600">We cover all aspects of Pakistani taxation including income tax, sales tax, corporate tax, international taxation, and tax litigation.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Can you handle cases outside of Pakistan?</h3>
                    <p class="text-gray-600">Yes, we handle international tax matters and have experience with cross-border transactions and foreign investment in Pakistan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Get Started?
            </h2>
            <p class="text-xl text-blue-100 mb-8">
                Don't wait until it's too late. Contact us today for expert tax advice 
                and start optimizing your tax position.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#contact-form" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg">
                    Get Free Consultation
                </a>
                <a href="tel:+923345143163" class="bg-white/20 hover:bg-white/30 text-white font-medium py-4 px-8 rounded-lg text-lg border-2 border-white/30 transition-all duration-200">
                    Call Now
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
