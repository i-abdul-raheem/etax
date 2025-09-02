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

// Handle category actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $name = sanitize($_POST['name']);
                $description = sanitize($_POST['description']);
                $slug = generateSlug($name);
                
                if (empty($name)) {
                    $error = 'Category name is required.';
                } else {
                    try {
                        $db->insert('categories', [
                            'name' => $name,
                            'slug' => $slug,
                            'description' => $description
                        ]);
                        $success = 'Category added successfully.';
                    } catch (Exception $e) {
                        $error = 'Failed to add category. Category name might already exist.';
                    }
                }
                break;
                
            case 'edit':
                $id = (int)$_POST['id'];
                $name = sanitize($_POST['name']);
                $description = sanitize($_POST['description']);
                $slug = generateSlug($name);
                
                if (empty($name)) {
                    $error = 'Category name is required.';
                } else {
                    if ($db->update('categories', [
                        'name' => $name,
                        'slug' => $slug,
                        'description' => $description
                    ], 'id = ?', [$id])) {
                        $success = 'Category updated successfully.';
                    } else {
                        $error = 'Failed to update category.';
                    }
                }
                break;
                
            case 'delete':
                $id = (int)$_POST['id'];
                
                // Check if category is being used by any posts
                $postCount = $db->count('blog_posts', 'category = (SELECT name FROM categories WHERE id = ?)', [$id]);
                
                if ($postCount > 0) {
                    $error = 'Cannot delete category. It is being used by ' . $postCount . ' post(s).';
                } else {
                    if ($db->delete('categories', 'id = ?', [$id])) {
                        $success = 'Category deleted successfully.';
                    } else {
                        $error = 'Failed to delete category.';
                    }
                }
                break;
        }
    }
}

// Get categories with post counts
$categories = $db->fetchAll(
    "SELECT c.*, COUNT(bp.id) as post_count 
     FROM categories c 
     LEFT JOIN blog_posts bp ON c.name = bp.category 
     GROUP BY c.id 
     ORDER BY c.name"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories - Dashboard - <?php echo SITE_NAME; ?> Pakistan</title>
    
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
                <a href="index.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    Dashboard
                </a>
                <a href="posts.php" class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-newspaper mr-3"></i>
                    Blog Posts
                </a>
                <a href="categories.php" class="flex items-center px-4 py-3 text-gray-700 bg-purple-50 border-r-4 border-purple-600 rounded-r-lg">
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
                <h1 class="text-2xl font-semibold text-gray-900">Categories</h1>
                <div class="flex items-center space-x-4">
                    <button onclick="openAddModal()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Category
                    </button>
                    <span class="text-sm text-gray-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-purple-600"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6">
            <?php if ($success): ?>
                <div class="bg-purple-50 border border-purple-200 text-purple-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-tags text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Categories</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo count($categories); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-newspaper text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Categories with Posts</p>
                            <p class="text-2xl font-semibold text-gray-900"><?php echo count(array_filter($categories, function($cat) { return $cat['post_count'] > 0; })); ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-chart-bar text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Most Used Category</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                <?php 
                                $mostUsed = array_reduce($categories, function($carry, $item) {
                                    return ($carry['post_count'] ?? 0) > $item['post_count'] ? $carry : $item;
                                });
                                echo $mostUsed['post_count'] ?? 0;
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">All Categories</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posts</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (empty($categories)): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No categories found.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($categories as $category): ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <code class="bg-gray-100 px-2 py-1 rounded text-xs">
                                                <?php echo htmlspecialchars($category['slug']); ?>
                                            </code>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <?php echo htmlspecialchars(truncateText($category['description'], 50)); ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $category['post_count'] > 0 ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800'; ?>">
                                                <?php echo $category['post_count']; ?> posts
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <?php echo formatDate($category['created_at']); ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium">
                                            <div class="flex items-center space-x-2">
                                                <button onclick="openEditModal(<?php echo htmlspecialchars(json_encode($category)); ?>)" class="text-purple-600 hover:text-purple-900">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <?php if ($category['post_count'] == 0): ?>
                                                    <form method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                <?php else: ?>
                                                    <span class="text-gray-400 cursor-not-allowed" title="Cannot delete category with posts">
                                                        <i class="fas fa-trash"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div id="addModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Category</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                        <input type="text" id="name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAddModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            Add Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div id="editModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Category</h3>
                <form method="POST">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="mb-4">
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                        <input type="text" id="edit_name" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    
                    <div class="mb-6">
                        <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea id="edit_description" name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
    }

    function openEditModal(category) {
        document.getElementById('edit_id').value = category.id;
        document.getElementById('edit_name').value = category.name;
        document.getElementById('edit_description').value = category.description || '';
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('bg-gray-600')) {
            closeAddModal();
            closeEditModal();
        }
    }
    </script>
</body>
</html>
