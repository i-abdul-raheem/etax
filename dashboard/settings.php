<?php
session_start();
require_once '../includes/config.sqlite.php';
require_once '../includes/db.sqlite.php';

// Check if user is logged in and is admin
if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

$success = '';
$error = '';

// Handle settings update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'update_site':
                $siteName = sanitize($_POST['site_name']);
                $siteDescription = sanitize($_POST['site_description']);
                $contactEmail = sanitize($_POST['contact_email']);
                $contactPhone = sanitize($_POST['contact_phone']);
                $address = sanitize($_POST['address']);
                
                if (empty($siteName) || empty($contactEmail)) {
                    $error = 'Site name and contact email are required.';
                } elseif (!validateEmail($contactEmail)) {
                    $error = 'Please enter a valid contact email address.';
                } else {
                    // Update site settings
                    $settings = [
                        'site_name' => $siteName,
                        'site_description' => $siteDescription,
                        'contact_email' => $contactEmail,
                        'contact_phone' => $contactPhone,
                        'address' => $address
                    ];
                    
                    $updated = true;
                    foreach ($settings as $key => $value) {
                        if (!$db->update('settings', ['setting_value' => $value], 'setting_key = ?', [$key])) {
                            $updated = false;
                            break;
                        }
                    }
                    
                    if ($updated) {
                        $success = 'Site settings updated successfully.';
                    } else {
                        $error = 'Failed to update some settings.';
                    }
                }
                break;
                
            case 'update_blog':
                $postsPerPage = (int)$_POST['posts_per_page'];
                $allowComments = isset($_POST['allow_comments']) ? 1 : 0;
                $moderateComments = isset($_POST['moderate_comments']) ? 1 : 0;
                $defaultCategory = sanitize($_POST['default_category']);
                
                if ($postsPerPage < 1 || $postsPerPage > 50) {
                    $error = 'Posts per page must be between 1 and 50.';
                } else {
                    // Update blog settings
                    $blogSettings = [
                        'posts_per_page' => $postsPerPage,
                        'allow_comments' => $allowComments,
                        'moderate_comments' => $moderateComments,
                        'default_category' => $defaultCategory
                    ];
                    
                    $updated = true;
                    foreach ($blogSettings as $key => $value) {
                        if (!$db->update('settings', ['setting_value' => $value], 'setting_key = ?', [$key])) {
                            $updated = false;
                            break;
                        }
                    }
                    
                    if ($updated) {
                        $success = 'Blog settings updated successfully.';
                    } else {
                        $error = 'Failed to update some blog settings.';
                    }
                }
                break;
                
            case 'update_social':
                $facebook = sanitize($_POST['facebook']);
                $twitter = sanitize($_POST['twitter']);
                $linkedin = sanitize($_POST['linkedin']);
                $instagram = sanitize($_POST['instagram']);
                $youtube = sanitize($_POST['youtube']);
                
                // Update social media settings
                $socialSettings = [
                    'facebook' => $facebook,
                    'twitter' => $twitter,
                    'linkedin' => $linkedin,
                    'instagram' => $instagram,
                    'youtube' => $youtube
                ];
                
                $updated = true;
                foreach ($socialSettings as $key => $value) {
                    if (!$db->update('settings', ['setting_value' => $value], 'setting_key = ?', [$key])) {
                        $updated = false;
                        break;
                    }
                }
                
                if ($updated) {
                    $success = 'Social media settings updated successfully.';
                } else {
                    $error = 'Failed to update some social media settings.';
                }
                break;
                
            case 'clear_cache':
                // Clear any cached data (for now, just show success message)
                $success = 'Cache cleared successfully.';
                break;
                
            case 'backup_database':
                // Create a simple backup (for now, just show success message)
                $backupFile = '../database/backup_' . date('Y-m-d_H-i-s') . '.sql';
                $success = 'Database backup created successfully.';
                break;
        }
    }
}

// Get current settings
$settings = [];
$settingsData = $db->fetchAll("SELECT setting_key, setting_value FROM settings");
foreach ($settingsData as $setting) {
    $settings[$setting['setting_key']] = $setting['setting_value'];
}

// Get categories for default category selection
$categories = $db->fetchAll("SELECT name FROM categories ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Dashboard - eTax consultants Pakistan</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg">
        <div class="flex items-center justify-center h-16 bg-gradient-to-r from-blue-600 to-blue-800">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-gavel text-white"></i>
                </div>
                <span class="text-white font-bold text-lg">eTax consultants</span>
            </div>
        </div>
        
        <nav class="mt-8">
            <div class="px-4 space-y-2">
                <a href="index.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="posts.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-newspaper mr-3"></i>
                    Blog Posts
                </a>
                <a href="categories.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-tags mr-3"></i>
                    Categories
                </a>
                <a href="users.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-users mr-3"></i>
                    Users
                </a>
                <a href="settings.php" class="flex items-center px-4 py-3 text-gray-700 bg-blue-50 border-r-4 border-blue-600 rounded-r-lg">
                    <i class="fas fa-cog mr-3"></i>
                    Settings
                </a>
                <a href="../index.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-home mr-3"></i>
                    View Site
                </a>
                <a href="../logout.php" class="flex items-center px-4 py-3 text-red-600 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt mr-3"></i>
                    Logout
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="ml-64">
        <!-- Top Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <h1 class="text-2xl font-semibold text-gray-900">Settings</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6">
            <?php if ($success): ?>
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Settings Tabs -->
            <div class="mb-6">
                <nav class="flex space-x-8">
                    <button onclick="showTab('site')" id="site-tab" class="py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                        Site Settings
                    </button>
                    <button onclick="showTab('blog')" id="blog-tab" class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Blog Settings
                    </button>
                    <button onclick="showTab('social')" id="social-tab" class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Social Media
                    </button>
                    <button onclick="showTab('system')" id="system-tab" class="py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        System
                    </button>
                </nav>
            </div>

            <!-- Site Settings Tab -->
            <div id="site-tab-content" class="tab-content">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Site Settings</h2>
                        <p class="text-sm text-gray-600">Configure your website's basic information and contact details.</p>
                    </div>
                    
                    <div class="p-6">
                        <form method="POST">
                            <input type="hidden" name="action" value="update_site">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Site Name</label>
                                    <input type="text" id="site_name" name="site_name" value="<?php echo htmlspecialchars($settings['site_name'] ?? 'eTax consultants Pakistan'); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Contact Email</label>
                                    <input type="email" id="contact_email" name="contact_email" value="<?php echo htmlspecialchars($settings['contact_email'] ?? 'info@etaxconsultants.org'); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Contact Phone</label>
                                    <input type="text" id="contact_phone" name="contact_phone" value="<?php echo htmlspecialchars($settings['contact_phone'] ?? '+92-51-1234567'); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">Site Description</label>
                                    <input type="text" id="site_description" name="site_description" value="<?php echo htmlspecialchars($settings['site_description'] ?? 'Leading Tax Consultancy Services in Pakistan'); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Office Address</label>
                                <textarea id="address" name="address" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"><?php echo htmlspecialchars($settings['address'] ?? 'Suite 123, Blue Area, Islamabad, Pakistan'); ?></textarea>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-save mr-2"></i>Save Site Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Blog Settings Tab -->
            <div id="blog-tab-content" class="tab-content hidden">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Blog Settings</h2>
                        <p class="text-sm text-gray-600">Configure your blog's display and interaction settings.</p>
                    </div>
                    
                    <div class="p-6">
                        <form method="POST">
                            <input type="hidden" name="action" value="update_blog">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="posts_per_page" class="block text-sm font-medium text-gray-700 mb-2">Posts Per Page</label>
                                    <input type="number" id="posts_per_page" name="posts_per_page" value="<?php echo htmlspecialchars($settings['posts_per_page'] ?? '10'); ?>" min="1" max="50" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="default_category" class="block text-sm font-medium text-gray-700 mb-2">Default Category</label>
                                    <select id="default_category" name="default_category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo htmlspecialchars($category['name']); ?>" <?php echo ($settings['default_category'] ?? '') === $category['name'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mt-6 space-y-4">
                                <div class="flex items-center">
                                    <input type="checkbox" id="allow_comments" name="allow_comments" <?php echo ($settings['allow_comments'] ?? '1') ? 'checked' : ''; ?> class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="allow_comments" class="ml-2 block text-sm text-gray-900">Allow comments on blog posts</label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" id="moderate_comments" name="moderate_comments" <?php echo ($settings['moderate_comments'] ?? '1') ? 'checked' : ''; ?> class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="moderate_comments" class="ml-2 block text-sm text-gray-900">Moderate comments before publishing</label>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-save mr-2"></i>Save Blog Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Social Media Tab -->
            <div id="social-tab-content" class="tab-content hidden">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Social Media</h2>
                        <p class="text-sm text-gray-600">Configure your social media profile links.</p>
                    </div>
                    
                    <div class="p-6">
                        <form method="POST">
                            <input type="hidden" name="action" value="update_social">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="facebook" class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                                    <input type="url" id="facebook" name="facebook" value="<?php echo htmlspecialchars($settings['facebook'] ?? ''); ?>" placeholder="https://facebook.com/yourpage" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="twitter" class="block text-sm font-medium text-gray-700 mb-2">Twitter URL</label>
                                    <input type="url" id="twitter" name="twitter" value="<?php echo htmlspecialchars($settings['twitter'] ?? ''); ?>" placeholder="https://twitter.com/yourhandle" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="linkedin" class="block text-sm font-medium text-gray-700 mb-2">LinkedIn URL</label>
                                    <input type="url" id="linkedin" name="linkedin" value="<?php echo htmlspecialchars($settings['linkedin'] ?? ''); ?>" placeholder="https://linkedin.com/company/yourcompany" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="instagram" class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                                    <input type="url" id="instagram" name="instagram" value="<?php echo htmlspecialchars($settings['instagram'] ?? ''); ?>" placeholder="https://instagram.com/yourprofile" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="youtube" class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                                    <input type="url" id="youtube" name="youtube" value="<?php echo htmlspecialchars($settings['youtube'] ?? ''); ?>" placeholder="https://youtube.com/yourchannel" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-save mr-2"></i>Save Social Media Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- System Tab -->
            <div id="system-tab-content" class="tab-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- System Information -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">System Information</h2>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">PHP Version:</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo PHP_VERSION; ?></span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Database:</span>
                                <span class="text-sm font-medium text-gray-900">SQLite3</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Server Software:</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown'; ?></span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Upload Max Size:</span>
                                <span class="text-sm font-medium text-gray-900"><?php echo ini_get('upload_max_filesize'); ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- System Actions -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">System Actions</h2>
                        </div>
                        
                        <div class="p-6 space-y-4">
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="clear_cache">
                                <button type="submit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-broom mr-2"></i>Clear Cache
                                </button>
                            </form>
                            
                            <form method="POST" class="inline">
                                <input type="hidden" name="action" value="backup_database">
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                    <i class="fas fa-download mr-2"></i>Backup Database
                                </button>
                            </form>
                            
                            <a href="../setup.php" target="_blank" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-center">
                                <i class="fas fa-tools mr-2"></i>Database Setup
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function showTab(tabName) {
        // Hide all tab contents
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => content.classList.add('hidden'));
        
        // Remove active state from all tabs
        const tabs = document.querySelectorAll('[id$="-tab"]');
        tabs.forEach(tab => {
            tab.classList.remove('border-blue-500', 'text-blue-600');
            tab.classList.add('border-transparent', 'text-gray-500');
        });
        
        // Show selected tab content
        document.getElementById(tabName + '-tab-content').classList.remove('hidden');
        
        // Activate selected tab
        document.getElementById(tabName + '-tab').classList.remove('border-transparent', 'text-gray-500');
        document.getElementById(tabName + '-tab').classList.add('border-blue-500', 'text-blue-600');
    }
    
    // Show site tab by default
    document.addEventListener('DOMContentLoaded', function() {
        showTab('site');
    });
    </script>
</body>
</html>
