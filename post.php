<?php
session_start();
require_once 'includes/config.sqlite.php';
require_once 'includes/db.sqlite.php';

// Get post slug from URL
$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : '';

if (empty($slug)) {
    redirect('blog.php');
}

// Get the blog post
$post = $db->fetch("SELECT * FROM blog_posts WHERE slug = ? AND status = 'published'", [$slug]);

if (!$post) {
    redirect('blog.php');
}

// Get author information
$author = $db->fetch("SELECT * FROM users WHERE id = ?", [$post['author_id']]);

// Get related posts
$relatedPosts = $db->fetchAll(
    "SELECT * FROM blog_posts WHERE category = ? AND id != ? AND status = 'published' ORDER BY created_at DESC LIMIT 3",
    [$post['category'], $post['id']]
);

// Increment view count
$db->update('blog_posts', ['views' => $post['views'] + 1], 'id = ?', [$post['id']]);

// Get category information
$category = $db->fetch("SELECT * FROM categories WHERE name = ?", [$post['category']]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['meta_title'] ?: $post['title']); ?> - <?php echo SITE_NAME; ?> Pakistan</title>
    <meta name="description" content="<?php echo htmlspecialchars($post['meta_description'] ?: $post['excerpt']); ?>">
    <meta property="og:title" content="<?php echo htmlspecialchars($post['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($post['excerpt']); ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo SITE_URL . '/post.php?slug=' . $post['slug']; ?>">
    
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
<body class="font-sans antialiased bg-gray-50">
    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Breadcrumb -->
    <section class="py-4 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <a href="index.php" class="text-gray-500 hover:text-gray-700 transition-colors">
                            <i class="fas fa-home"></i>
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="blog.php" class="text-gray-500 hover:text-gray-700 transition-colors">
                                Blog
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-900 font-medium"><?php echo htmlspecialchars($post['title']); ?></span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Blog Post Content -->
    <section class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Post Header -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <span class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full">
                        <?php echo htmlspecialchars($post['category']); ?>
                    </span>
                    <span class="text-gray-500 text-sm">
                        <i class="fas fa-calendar mr-1"></i>
                        <?php echo formatDate($post['published_at']); ?>
                    </span>
                    <span class="text-gray-500 text-sm">
                        <i class="fas fa-eye mr-1"></i>
                        <?php echo number_format($post['views'] + 1); ?> views
                    </span>
                </div>

                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    <?php echo htmlspecialchars($post['title']); ?>
                </h1>

                <?php if ($post['excerpt']): ?>
                    <p class="text-xl text-gray-600 mb-6 leading-relaxed">
                        <?php echo htmlspecialchars($post['excerpt']); ?>
                    </p>
                <?php endif; ?>

                <div class="flex items-center gap-4 pt-6 border-t border-gray-200">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-purple-600 text-xl"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">
                                <?php echo htmlspecialchars($author['full_name'] ?? SITE_NAME.' Team'); ?>
                            </div>
                            <div class="text-sm text-gray-500">
                                Tax Consultant
                            </div>
                        </div>
                    </div>
                    
                    <div class="ml-auto flex items-center gap-3">
                        <button class="text-gray-400 hover:text-purple-600 transition-colors" onclick="sharePost()">
                            <i class="fas fa-share-alt text-xl"></i>
                        </button>
                        <button class="text-gray-400 hover:text-red-600 transition-colors" onclick="likePost()">
                            <i class="fas fa-heart text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Featured Image -->
            <?php if ($post['featured_image']): ?>
                <div class="mb-8">
                    <img 
                        src="<?php echo htmlspecialchars($post['featured_image']); ?>" 
                        alt="<?php echo htmlspecialchars($post['title']); ?>"
                        class="w-full h-64 md:h-96 object-cover rounded-xl shadow-lg"
                    >
                </div>
            <?php endif; ?>

            <!-- Post Content -->
            <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                <div class="prose prose-lg max-w-none">
                    <?php 
                    // Convert markdown-like content to HTML
                    $content = $post['content'];
                    
                    // Convert headers
                    $content = preg_replace('/^## (.*$)/m', '<h2 class="text-2xl font-bold text-gray-900 mt-8 mb-4">$1</h2>', $content);
                    $content = preg_replace('/^### (.*$)/m', '<h3 class="text-xl font-bold text-gray-900 mt-6 mb-3">$1</h3>', $content);
                    
                    // Convert lists
                    $content = preg_replace('/^- (.*$)/m', '<li class="ml-4">$1</li>', $content);
                    $content = preg_replace('/(<li.*<\/li>)/s', '<ul class="list-disc ml-6 mb-4">$1</ul>', $content);
                    
                    // Convert paragraphs
                    $content = '<p class="text-gray-700 leading-relaxed mb-4">' . str_replace("\n\n", '</p><p class="text-gray-700 leading-relaxed mb-4">', $content) . '</p>';
                    
                    echo $content;
                    ?>
                </div>
            </div>

            <!-- Tags -->
            <?php if ($post['tags']): ?>
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Tags:</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php 
                        $tags = explode(',', $post['tags']);
                        foreach ($tags as $tag): 
                            $tag = trim($tag);
                            if (!empty($tag)):
                        ?>
                            <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">
                                <?php echo htmlspecialchars($tag); ?>
                            </span>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Share Section -->
            <div class="bg-purple-50 rounded-xl p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Share this article:</h3>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(SITE_URL . '/post.php?slug=' . $post['slug']); ?>" 
                       target="_blank" 
                       class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition-colors">
                        <i class="fab fa-facebook mr-2"></i>Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(SITE_URL . '/post.php?slug=' . $post['slug']); ?>&text=<?php echo urlencode($post['title']); ?>" 
                       target="_blank" 
                       class="bg-purple-400 text-white px-4 py-2 rounded-lg hover:bg-purple-500 transition-colors">
                        <i class="fab fa-twitter mr-2"></i>Twitter
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(SITE_URL . '/post.php?slug=' . $post['slug']); ?>" 
                       target="_blank" 
                       class="bg-purple-700 text-white px-4 py-2 rounded-lg hover:bg-purple-800 transition-colors">
                        <i class="fab fa-linkedin mr-2"></i>LinkedIn
                    </a>
                </div>
            </div>

            <!-- Related Posts -->
            <?php if (!empty($relatedPosts)): ?>
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Related Articles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <?php foreach ($relatedPosts as $relatedPost): ?>
                            <article class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <?php if ($relatedPost['featured_image']): ?>
                                    <img src="<?php echo htmlspecialchars($relatedPost['featured_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($relatedPost['title']); ?>"
                                         class="w-full h-32 object-cover">
                                <?php endif; ?>
                                
                                <div class="p-4">
                                    <h4 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                        <a href="post.php?slug=<?php echo $relatedPost['slug']; ?>" 
                                           class="hover:text-purple-600 transition-colors">
                                            <?php echo htmlspecialchars($relatedPost['title']); ?>
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-500 mb-3">
                                        <?php echo formatDate($relatedPost['published_at']); ?>
                                    </p>
                                    <a href="post.php?slug=<?php echo $relatedPost['slug']; ?>" 
                                       class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                                        Read More <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Back to Blog -->
            <div class="text-center">
                <a href="blog.php" class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Blog
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php'; ?>

    <!-- JavaScript -->
    <script src="assets/js/main.js"></script>
    <script>
    function sharePost() {
        if (navigator.share) {
            navigator.share({
                title: '<?php echo addslashes($post['title']); ?>',
                text: '<?php echo addslashes($post['excerpt']); ?>',
                url: window.location.href
            });
        } else {
            // Fallback: copy URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                showNotification('Link copied to clipboard!', 'success');
            });
        }
    }

    function likePost() {
        // Implement like functionality here
        showNotification('Post liked!', 'success');
    }
    </script>
</body>
</html>
