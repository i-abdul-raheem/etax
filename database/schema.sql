-- eTax consultants Pakistan Database Schema
-- Create this database and run these SQL commands to set up the system

-- Create database
CREATE DATABASE IF NOT EXISTS taxpulse_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE taxpulse_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'editor', 'author') DEFAULT 'author',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Blog posts table
CREATE TABLE blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    featured_image VARCHAR(255),
    category VARCHAR(100) NOT NULL,
    tags TEXT,
    author_id INT NOT NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    views INT DEFAULT 0,
    meta_title VARCHAR(255),
    meta_description TEXT,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Categories table (for better organization)
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    parent_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Contact form submissions
CREATE TABLE contact_submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    company VARCHAR(100),
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('new', 'read', 'replied', 'archived') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Newsletter subscribers
CREATE TABLE newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) UNIQUE NOT NULL,
    status ENUM('active', 'unsubscribed') DEFAULT 'active',
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    unsubscribed_at TIMESTAMP NULL
);

-- Settings table
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    description TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password_hash, full_name, role) VALUES 
('admin', 'admin@etaxconsultants.org', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Insert default categories
INSERT INTO categories (name, slug, description) VALUES
('Tax Law Updates', 'tax-law-updates', 'Latest updates and changes in tax laws and regulations'),
('Corporate Tax', 'corporate-tax', 'Corporate taxation, planning, and compliance'),
('International Taxation', 'international-taxation', 'Cross-border tax matters and international business'),
('Sales Tax & Customs', 'sales-tax-customs', 'Sales tax, federal excise duty, and customs matters'),
('Individual Tax', 'individual-tax', 'Personal tax planning and compliance'),
('Tax Compliance', 'tax-compliance', 'Tax compliance, filing, and regulatory matters'),
('Litigation', 'litigation', 'Tax litigation, appeals, and court cases'),
('Tax Planning', 'tax-planning', 'Strategic tax planning and optimization');

-- Insert default settings
INSERT INTO settings (setting_key, setting_value, description) VALUES
('site_name', 'eTax consultants Pakistan', 'Website name'),
('site_description', 'Pakistan\'s leading tax consultancy firm', 'Website description'),
('site_email', 'info@etaxconsultants.org', 'Main contact email'),
('site_phone', '+92 21 3582 1757', 'Main contact phone'),
('posts_per_page', '6', 'Number of blog posts per page'),
('allow_comments', '1', 'Allow comments on blog posts'),
('maintenance_mode', '0', 'Maintenance mode status');

-- Insert sample blog posts
INSERT INTO blog_posts (title, slug, excerpt, content, category, author_id, status, published_at) VALUES
('Understanding Pakistan\'s New Tax Laws for 2024', 'understanding-pakistan-new-tax-laws-2024', 'Get insights into the latest tax law changes and how they affect individuals and businesses in Pakistan.', 'This is a comprehensive guide to the new tax laws introduced in Pakistan for the year 2024. The article covers all major changes, their implications, and practical advice for compliance.

## Key Changes in 2024

### 1. Income Tax Rates
The government has introduced new income tax slabs with revised rates for different income brackets.

### 2. Corporate Tax Updates
Corporate entities will see changes in tax rates and compliance requirements.

### 3. Digital Tax Initiatives
New digital tax measures have been introduced to improve tax collection and compliance.

## Impact on Businesses

Businesses need to review their tax strategies and ensure compliance with the new regulations.

## Recommendations

- Consult with tax professionals
- Review existing tax structures
- Update compliance procedures
- Plan for the new requirements

Stay informed and compliant with these changes to avoid penalties and optimize your tax position.', 'Tax Law Updates', 1, 'published', NOW()),

('Corporate Tax Planning Strategies for Pakistani Businesses', 'corporate-tax-planning-strategies-pakistani-businesses', 'Learn effective corporate tax planning strategies that can help Pakistani businesses optimize their tax position and improve profitability.', 'Corporate tax planning is crucial for businesses operating in Pakistan. This comprehensive guide explores various strategies that can help businesses minimize their tax burden while remaining compliant with local regulations.

## Understanding Corporate Tax in Pakistan

Pakistan\'s corporate tax system has specific provisions that businesses can leverage for better tax planning.

## Key Planning Strategies

### 1. Business Structure Optimization
Choosing the right business structure can significantly impact your tax liability.

### 2. Investment Incentives
Take advantage of government incentives for specific industries and investments.

### 3. Timing of Income and Expenses
Strategic timing can help optimize your tax position.

## Compliance Requirements

Ensure all planning strategies comply with Pakistani tax laws and regulations.

## Conclusion

Effective corporate tax planning requires a deep understanding of local regulations and professional guidance.', 'Corporate Tax', 1, 'published', NOW()),

('International Taxation: A Guide for Pakistani Businesses', 'international-taxation-guide-pakistani-businesses', 'Navigate the complexities of international taxation for Pakistani businesses expanding globally or dealing with foreign transactions.', 'International taxation presents unique challenges and opportunities for Pakistani businesses. This guide covers essential aspects of cross-border tax matters.

## Understanding International Tax

International tax involves dealing with tax obligations in multiple jurisdictions.

## Key Considerations

### 1. Double Taxation Agreements
Pakistan has DTAs with various countries to prevent double taxation.

### 2. Transfer Pricing
Compliance with transfer pricing regulations is essential for international operations.

### 3. Foreign Investment Rules
Understanding foreign investment regulations helps optimize international business structures.

## Compliance Requirements

International operations require careful attention to compliance in multiple jurisdictions.

## Best Practices

- Seek professional advice
- Maintain proper documentation
- Stay updated with regulations
- Plan for compliance costs', 'International Taxation', 1, 'published', NOW());

-- Create indexes for better performance
CREATE INDEX idx_blog_posts_status ON blog_posts(status);
CREATE INDEX idx_blog_posts_category ON blog_posts(category);
CREATE INDEX idx_blog_posts_author ON blog_posts(author_id);
CREATE INDEX idx_blog_posts_created ON blog_posts(created_at);
CREATE INDEX idx_blog_posts_slug ON blog_posts(slug);

CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_users_username ON users(username);
CREATE INDEX idx_users_role ON users(role);

CREATE INDEX idx_categories_slug ON categories(slug);
CREATE INDEX idx_categories_parent ON categories(parent_id);

CREATE INDEX idx_contact_status ON contact_submissions(status);
CREATE INDEX idx_contact_created ON contact_submissions(created_at);

CREATE INDEX idx_subscribers_email ON newsletter_subscribers(email);
CREATE INDEX idx_subscribers_status ON newsletter_subscribers(status);
