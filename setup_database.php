<?php
/**
 * Database Setup Script for eTax consultants Pakistan
 * Run this file once to set up your SQLite database
 */

echo "🚀 Setting up eTax consultants Pakistan Database...\n\n";

// Check if SQLite3 is available
if (!extension_loaded('pdo_sqlite')) {
    die("❌ SQLite3 extension is not available. Please install it first.\n");
}

// Include the SQLite database class
require_once 'includes/db.sqlite.php';

try {
    echo "✅ Database connection established\n";
    
    // Check if tables exist
    $tables = ['users', 'blog_posts', 'categories', 'contact_submissions', 'newsletter_subscribers', 'settings'];
    
    foreach ($tables as $table) {
        if ($db->tableExists($table)) {
            echo "✅ Table '$table' already exists\n";
        } else {
            echo "❌ Table '$table' does not exist\n";
        }
    }
    
    // Create tables if they don't exist
    if (!$db->tableExists('users')) {
        echo "\n📋 Creating database tables...\n";
        $db->createTables();
        echo "✅ Database tables created successfully\n";
    }
    
    // Check if admin user exists
    $adminUser = $db->fetch("SELECT * FROM users WHERE username = 'admin'");
    if ($adminUser) {
        echo "✅ Admin user already exists\n";
    } else {
        echo "❌ Admin user not found\n";
    }
    
    // Check if categories exist
    $categories = $db->fetchAll("SELECT * FROM categories");
    if (count($categories) > 0) {
        echo "✅ Categories loaded: " . count($categories) . " found\n";
    } else {
        echo "❌ No categories found\n";
    }
    
    // Check if blog posts exist
    $posts = $db->fetchAll("SELECT * FROM blog_posts");
    if (count($posts) > 0) {
        echo "✅ Blog posts loaded: " . count($posts) . " found\n";
    } else {
        echo "❌ No blog posts found\n";
    }
    
    echo "\n🎉 Database setup completed successfully!\n\n";
    echo "📱 Your website is ready at: http://localhost:8000\n";
    echo "🔐 Admin Dashboard: http://localhost:8000/dashboard/\n";
    echo "   Username: admin\n";
    echo "   Password: admin123\n\n";
    
    echo "📊 Database Statistics:\n";
    echo "   - Users: " . $db->count('users') . "\n";
    echo "   - Blog Posts: " . $db->count('blog_posts') . "\n";
    echo "   - Categories: " . $db->count('categories') . "\n";
    echo "   - Settings: " . $db->count('settings') . "\n\n";
    
} catch (Exception $e) {
    echo "❌ Error during setup: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
?>
