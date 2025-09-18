<?php
session_start();
require_once 'includes/config.sqlite.php';
require_once 'includes/db.sqlite.php';

// Get search query
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$category = isset($_GET['category']) ? sanitize($_GET['category']) : '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$postsPerPage = POSTS_PER_PAGE;
$offset = ($page - 1) * $postsPerPage;

// Build query
$whereClause = "blog_posts.status = 'published'";
$params = [];

if ($search) {
    $whereClause .= " AND (blog_posts.title LIKE ? OR blog_posts.content LIKE ? OR blog_posts.excerpt LIKE ?)";
    $searchTerm = "%$search%";
    $params = [$searchTerm, $searchTerm, $searchTerm];
}

if ($category) {
    $whereClause .= " AND blog_posts.category = ?";
    $params[] = $category;
}

// Get total posts count
$totalPosts = $db->count('blog_posts', $whereClause, $params);
$totalPages = ceil($totalPosts / $postsPerPage);

// Get blog posts with author names
$sql = "SELECT blog_posts.*, users.full_name as author FROM blog_posts 
        LEFT JOIN users ON blog_posts.author_id = users.id 
        WHERE $whereClause ORDER BY blog_posts.created_at DESC LIMIT ? OFFSET ?";
$queryParams = array_merge($params, [$postsPerPage, $offset]);
$posts = $db->fetchAll($sql, $queryParams);

// Get categories for filter
$categories = $db->fetchAll("SELECT DISTINCT category FROM blog_posts WHERE status = 'published' ORDER BY category");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - <?php echo SITE_NAME; ?> Pakistan</title>
    <meta name="description" content="Latest tax news, updates, and insights from <?php echo SITE_NAME; ?> Pakistan. Stay informed about tax laws, regulations, and best practices.">
    
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
                Tax <span class="text-green-300">Blog</span>
            </h1>
            <p class="text-xl text-purple-100 max-w-3xl mx-auto">
                Stay updated with the latest tax news, regulations, and insights from our expert team. 
                Get valuable information to help you make informed decisions.
            </p>
        </div>
    </section>

    <!-- Search and Filters -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search Bar -->
                <div class="flex-1 max-w-md">
                    <form method="GET" action="blog.php" class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="<?php echo htmlspecialchars($search); ?>"
                            placeholder="Search blog posts..." 
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                        <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>

                <!-- Category Filter -->
                <div class="flex items-center gap-4">
                    <label for="category" class="text-sm font-medium text-gray-700">Category:</label>
                    <select 
                        id="category" 
                        name="category" 
                        onchange="filterByCategory(this.value)"
                        class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                    >
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>" 
                                    <?php echo $category === $cat['category'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['category']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Posts -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php if (empty($posts)): ?>
                <div class="text-center py-12">
                    <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-2xl font-semibold text-gray-600 mb-2">No posts found</h3>
                    <p class="text-gray-500 mb-6">
                        <?php if ($search || $category): ?>
                            No blog posts match your search criteria. Try adjusting your search terms.
                        <?php else: ?>
                            No blog posts available at the moment.
                        <?php endif; ?>
                    </p>
                    <?php if ($search || $category): ?>
                        <a href="blog.php" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                            View All Posts
                        </a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($posts as $post): ?>
                        <article class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                            <?php if ($post['featured_image']): ?>
                                <div class="aspect-w-16 aspect-h-9">
                                    <img src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($post['title']); ?>"
                                         class="w-full h-48 object-cover">
                                </div>
                            <?php endif; ?>
                            
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                        <?php echo htmlspecialchars($post['category']); ?>
                                    </span>
                                    <span class="text-sm text-gray-500">
                                        <?php echo formatDate($post['created_at']); ?>
                                    </span>
                                </div>
                                
                                <h2 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                                    <a href="post.php?slug=<?php echo $post['slug']; ?>" 
                                       class="hover:text-purple-600 transition-colors">
                                        <?php echo htmlspecialchars($post['title']); ?>
                                    </a>
                                </h2>
                                
                                <p class="text-gray-600 mb-4 leading-relaxed line-clamp-3">
                                    <?php echo htmlspecialchars($post['excerpt'] ?: truncateText($post['content'])); ?>
                                </p>
                                
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <i class="fas fa-user"></i>
                                        <span><?php echo htmlspecialchars($post['author']); ?></span>
                                    </div>
                                    
                                    <a href="post.php?slug=<?php echo $post['slug']; ?>" 
                                       class="text-purple-600 hover:text-purple-700 font-medium text-sm transition-colors">
                                        Read More <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                    <div class="mt-12 flex justify-center">
                        <nav class="flex items-center gap-2">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>" 
                                   class="px-3 py-2 text-gray-500 hover:text-gray-700 transition-colors">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <?php if ($i == $page): ?>
                                    <span class="px-3 py-2 bg-purple-600 text-white rounded-lg">
                                        <?php echo $i; ?>
                                    </span>
                                <?php else: ?>
                                    <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>" 
                                       class="px-3 py-2 text-gray-500 hover:text-gray-700 transition-colors">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&category=<?php echo urlencode($category); ?>" 
                                   class="px-3 py-2 text-gray-500 hover:text-gray-700 transition-colors">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">
                Stay Updated with Tax News
            </h2>
            <p class="text-lg text-gray-600 mb-8">
                Subscribe to our newsletter and get the latest tax updates, insights, and expert advice delivered to your inbox.
            </p>
            
            <form method="POST" action="subscribe.php" class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Enter your email address" 
                    required
                    class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    Subscribe
                </button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <script>
    function filterByCategory(category) {
        const url = new URL(window.location);
        if (category) {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }
        url.searchParams.delete('page'); // Reset to first page
        window.location.href = url.toString();
    }
    </script>
</body>
</html>
