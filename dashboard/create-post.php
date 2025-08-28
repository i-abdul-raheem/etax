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

// Handle post creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize($_POST['title']);
    $excerpt = sanitize($_POST['excerpt']);
    $content = $_POST['content'];
    $category = sanitize($_POST['category']);
    $status = sanitize($_POST['status']);
    $featuredImage = sanitize($_POST['featured_image']);
    $tags = sanitize($_POST['tags']);
    
    if (empty($title) || empty($content) || empty($category)) {
        $error = 'Title, content, and category are required.';
    } else {
        $slug = generateSlug($title);
        
        // Check if slug already exists
        $existingPost = $db->fetch("SELECT id FROM blog_posts WHERE slug = ?", [$slug]);
        if ($existingPost) {
            $slug = $slug . '-' . time();
        }
        
        try {
            $postId = $db->insert('blog_posts', [
                'title' => $title,
                'slug' => $slug,
                'excerpt' => $excerpt,
                'content' => $content,
                'category' => $category,
                'status' => $status,
                'featured_image' => $featuredImage,
                'tags' => $tags,
                'author_id' => $_SESSION['user_id'],
                'views' => 0
            ]);
            
            if ($postId) {
                $success = 'Blog post created successfully!';
                // Redirect to edit page after creation
                header("Location: edit-post.php?id=" . $postId . "&created=1");
                exit();
            } else {
                $error = 'Failed to create blog post.';
            }
        } catch (Exception $e) {
            $error = 'Failed to create blog post: ' . $e->getMessage();
        }
    }
}

// Get categories for selection
$categories = $db->fetchAll("SELECT name FROM categories ORDER BY name");

// Get existing tags for suggestions
$existingTags = $db->fetchAll("SELECT DISTINCT tags FROM blog_posts WHERE tags IS NOT NULL AND tags != ''");
$tagSuggestions = [];
foreach ($existingTags as $tagData) {
    if ($tagData['tags']) {
        $tagSuggestions = array_merge($tagSuggestions, explode(',', $tagData['tags']));
    }
}
$tagSuggestions = array_unique(array_filter(array_map('trim', $tagSuggestions)));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post - Dashboard - eTax consultants Pakistan</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- SimpleMDE Markdown Editor -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
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
                <h1 class="text-2xl font-semibold text-gray-900">Create New Post</h1>
                <div class="flex items-center space-x-4">
                    <a href="posts.php" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Posts
                    </a>
                    <span class="text-sm text-gray-500">Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></span>
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="p-6">
            <?php if ($error): ?>
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Title -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Post Title *</label>
                            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg" placeholder="Enter your post title">
                        </div>

                        <!-- Content Editor -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                            <textarea id="content" name="content" required class="w-full" rows="20"><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                            <p class="text-sm text-gray-500 mt-2">Use Markdown formatting for better content structure.</p>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Publish Settings -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Publish Settings</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="draft" <?php echo ($_POST['status'] ?? 'draft') === 'draft' ? 'selected' : ''; ?>>Draft</option>
                                        <option value="published" <?php echo ($_POST['status'] ?? 'draft') === 'published' ? 'selected' : ''; ?>>Published</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <select id="category" name="category" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo htmlspecialchars($category['name']); ?>" <?php echo ($_POST['category'] ?? '') === $category['name'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                    <input type="text" id="tags" name="tags" value="<?php echo htmlspecialchars($_POST['tags'] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="tag1, tag2, tag3">
                                    <p class="text-sm text-gray-500 mt-1">Separate tags with commas</p>
                                    
                                    <?php if (!empty($tagSuggestions)): ?>
                                        <div class="mt-2">
                                            <p class="text-xs text-gray-500 mb-2">Popular tags:</p>
                                            <div class="flex flex-wrap gap-1">
                                                <?php foreach (array_slice($tagSuggestions, 0, 10) as $tag): ?>
                                                    <button type="button" onclick="addTag('<?php echo htmlspecialchars($tag); ?>')" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded">
                                                        <?php echo htmlspecialchars($tag); ?>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Featured Image</h3>
                            
                            <div>
                                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                                <input type="url" id="featured_image" name="featured_image" value="<?php echo htmlspecialchars($_POST['featured_image'] ?? ''); ?>" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="https://example.com/image.jpg">
                                <p class="text-sm text-gray-500 mt-1">Enter the URL of your featured image</p>
                            </div>
                            
                            <div id="image_preview" class="mt-4 hidden">
                                <img id="preview_img" src="" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        </div>

                        <!-- Excerpt -->
                        <div class="bg-white rounded-lg shadow p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Excerpt</h3>
                            
                            <div>
                                <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Post Excerpt</label>
                                <textarea id="excerpt" name="excerpt" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Brief description of your post (optional)"><?php echo htmlspecialchars($_POST['excerpt'] ?? ''); ?></textarea>
                                <p class="text-sm text-gray-500 mt-1">A short summary that appears in post previews</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="posts.php" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" name="action" value="save_draft" class="px-6 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Save as Draft
                    </button>
                    <button type="submit" name="action" value="publish" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>Publish Post
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    // Initialize Markdown Editor
    let simplemde = new SimpleMDE({
        element: document.getElementById('content'),
        spellChecker: false,
        autosave: {
            enabled: true,
            delay: 1000,
            uniqueId: 'create-post'
        },
        toolbar: [
            'bold', 'italic', 'heading', '|',
            'quote', 'unordered-list', 'ordered-list', '|',
            'link', 'image', 'table', '|',
            'preview', 'side-by-side', 'fullscreen', '|',
            'guide'
        ]
    });

    // Handle form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const action = e.submitter?.name === 'action' ? e.submitter.value : 'save_draft';
        
        if (action === 'publish') {
            document.getElementById('status').value = 'published';
        } else {
            document.getElementById('status').value = 'draft';
        }
    });

    // Image preview
    document.getElementById('featured_image').addEventListener('input', function() {
        const url = this.value;
        const preview = document.getElementById('image_preview');
        const img = document.getElementById('preview_img');
        
        if (url && isValidUrl(url)) {
            img.src = url;
            preview.classList.remove('hidden');
        } else {
            preview.classList.add('hidden');
        }
    });

    // Add tag function
    function addTag(tag) {
        const tagsInput = document.getElementById('tags');
        const currentTags = tagsInput.value;
        const tags = currentTags ? currentTags.split(',').map(t => t.trim()) : [];
        
        if (!tags.includes(tag)) {
            tags.push(tag);
            tagsInput.value = tags.join(', ');
        }
    }

    // URL validation
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    // Auto-save title to generate slug
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value;
        if (title) {
            // You can add slug preview here if needed
            localStorage.setItem('draft_title', title);
        }
    });

    // Load draft title if exists
    window.addEventListener('load', function() {
        const draftTitle = localStorage.getItem('draft_title');
        if (draftTitle && !document.getElementById('title').value) {
            document.getElementById('title').value = draftTitle;
        }
    });
    </script>
</body>
</html>
