<?php
session_start();
require_once '../includes/config.sqlite.php';
require_once '../includes/db.sqlite.php';

// Check if user is logged in and is admin
if (!isLoggedIn() || !isAdmin()) {
    redirect('../login.php');
}

// Get dashboard stats
$totalPosts = $db->count('blog_posts');
$publishedPosts = $db->count('blog_posts', "status = 'published'");
$draftPosts = $db->count('blog_posts', "status = 'draft'");
$totalUsers = $db->count('users');

// Get recent posts
$recentPosts = $db->fetchAll("SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 5");

// Get recent activities (you can expand this based on your needs)
$recentActivities = [
    ['type' => 'post_created', 'message' => 'New blog post "Tax Law Updates 2024" created', 'time' => '2 hours ago'],
    ['type' => 'post_published', 'message' => 'Blog post "Corporate Tax Planning" published', 'time' => '1 day ago'],
    ['type' => 'user_registered', 'message' => 'New user registered: john@example.com', 'time' => '2 days ago'],
    ['type' => 'post_updated', 'message' => 'Blog post "International Taxation" updated', 'time' => '3 days ago']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?php echo SITE_NAME; ?> Pakistan</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/img/logo-md.png">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg">
        <div class="flex items-center justify-center h-16 bg-gradient-to-r from-purple-600 to-purple-800">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-gavel text-white"></i>
                </div>
                <span class="text-white font-bold text-lg"><?php echo SITE_NAME; ?></span>
            </div>
        </div>
        
        <nav class="mt-8">
            <div class="px-4 space-y-2">
                <a href="index.php" class="flex items-center px-4 py-3 text-gray-700 bg-purple-50 border-r-4 border-purple-600 rounded-r-lg">
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
                <a href="settings.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
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
                <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-purple-600"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <main class="p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-newspaper text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Posts</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo $totalPosts; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Published</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo $publishedPosts; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-edit text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Drafts</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo $draftPosts; ?></p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Users</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo $totalUsers; ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow mb-8">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Quick Actions</h2>
                </div>
                <div class="p-6">
                    <div class="flex flex-wrap gap-4">
                        <a href="posts.php?action=new" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>New Post
                        </a>
                        <a href="categories.php?action=new" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-tag mr-2"></i>New Category
                        </a>
                        <a href="users.php?action=new" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-user-plus mr-2"></i>New User
                        </a>
                        <a href="../blog.php" target="_blank" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fas fa-eye mr-2"></i>View Blog
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Posts -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Posts</h2>
                    </div>
                    <div class="p-6">
                        <?php if (empty($recentPosts)): ?>
                            <p class="text-gray-500 text-center py-4">No posts yet</p>
                        <?php else: ?>
                            <div class="space-y-4">
                                <?php foreach ($recentPosts as $post): ?>
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900">
                                                <a href="../post.php?slug=<?php echo $post['slug']; ?>" target="_blank" class="hover:text-purple-600">
                                                    <?php echo htmlspecialchars($post['title']); ?>
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                <?php echo formatDate($post['created_at']); ?> • 
                                                <span class="capitalize"><?php echo $post['status']; ?></span>
                                            </p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <a href="posts.php?action=edit&id=<?php echo $post['id']; ?>" 
                                               class="text-purple-600 hover:text-purple-700">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="posts.php?action=delete&id=<?php echo $post['id']; ?>" 
                                               class="text-red-600 hover:text-red-700"
                                               onclick="return confirm('Are you sure you want to delete this post?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mt-4 text-center">
                                <a href="posts.php" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                                    View All Posts <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Recent Activities</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <?php foreach ($recentActivities as $activity): ?>
                                <div class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-purple-600 rounded-full mt-2"></div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900"><?php echo $activity['message']; ?></p>
                                        <p class="text-xs text-gray-500"><?php echo $activity['time']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
    // Add any JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Dashboard interactions can be added here
    });
    </script>
</body>
</html>
