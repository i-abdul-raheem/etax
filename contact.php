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
    <title>Contact Us - <?php echo SITE_NAME; ?> Pakistan</title>
    <meta name="description" content="Get in touch with <?php echo SITE_NAME; ?> Pakistan for expert tax consultancy services. Contact us for free consultation and expert advice.">

    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo-md.png">
</head>

<body class="font-sans antialiased">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Page Header -->
    <section class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                Get in <span class="text-green-300">Touch</span>
            </h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto">
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
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Schedule a call with us</h2>

                    <?php if ($success): ?>
                        <div class="bg-purple-50 border border-purple-200 text-purple-700 px-4 py-3 rounded-lg mb-6">
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

                    <!-- Calendly inline widget begin -->
                    <div
                        class="calendly-inline-widget w-full"
                        data-url="https://calendly.com/etaxconsultants-org/30min"
                        style="min-width:320px; height:700px;">
                    </div>
                    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
                    <!-- Calendly inline widget end -->
                </div>

                <!-- Contact Information -->
                <div class="space-y-8">
                    <!-- Quick Contact -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Quick Contact</h3>

                        <div class="space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-phone text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Main Office</p>
                                    <p class="font-semibold text-gray-900"><?php echo SITE_PHONE; ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-envelope text-purple-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="font-semibold text-gray-900"><?php echo SITE_EMAIL; ?></p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-green-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Business Hours</p>
                                    <p class="font-semibold text-gray-900">24/7 Available</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Office Locations -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Our Offices</h3>

                        <div class="space-y-6">

                            <div class="border-l-4 border-purple-500 pl-4">
                                <h4 class="font-semibold text-gray-900 mb-2">Multan</h4>
                                <p class="text-gray-600 text-sm mb-2"><?php echo COMPANY_ADDRESS; ?></p>
                                <p class="text-purple-600 font-medium text-sm"><?php echo SITE_PHONE; ?></p>
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
                        <a href="tel:<?php echo SITE_PHONE; ?>" class="bg-white text-red-600 font-bold py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">
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
                    Frequently Asked <span class="text-purple-600">Questions</span>
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
    <section class="py-16 bg-gradient-to-r from-purple-600 to-purple-800 text-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">
                Ready to Get Started?
            </h2>
            <p class="text-xl text-purple-100 mb-8">
                Don't wait until it's too late. Contact us today for expert tax advice
                and start optimizing your tax position.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="<?php echo MEETING_LINK; ?>" class="bg-green-500 hover:bg-green-600 text-white font-bold py-4 px-8 rounded-lg text-lg transition-all duration-200 transform hover:scale-105 hover:shadow-lg">
                    Get Free Consultation
                </a>
                <a href="tel:<?php echo SITE_PHONE; ?>" class="bg-white/20 hover:bg-white/30 text-white font-medium py-4 px-8 rounded-lg text-lg border-2 border-white/30 transition-all duration-200">
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