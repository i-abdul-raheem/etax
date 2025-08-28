# eTax consultants Pakistan - Tax Consultancy Website

A modern, responsive tax consultancy website built with PHP, featuring a blog system and admin dashboard. Inspired by the design aesthetics of ElevenLabs and eTax consultants Pakistan.

## Features

### 🏠 Main Website
- **Modern Hero Section** with gradient backgrounds and animations
- **Services Showcase** displaying comprehensive tax consultancy services
- **About Section** highlighting company expertise and values
- **Client Testimonials** with star ratings
- **Contact Form** with office locations across Pakistan
- **Responsive Design** optimized for all devices

### 📝 Blog System
- **Blog Listing** with search and category filtering
- **Individual Post Pages** with markdown support
- **Category Management** for organized content
- **Search Functionality** across posts
- **Pagination** for better user experience
- **Newsletter Signup** for subscribers

### 🎛️ Admin Dashboard
- **Dashboard Overview** with statistics and quick actions
- **Blog Post Management** (Create, Edit, Delete, Publish)
- **Category Management** for organizing content
- **User Management** with role-based access
- **Contact Form Submissions** tracking
- **Settings Management** for site configuration

### 🎨 Design Features
- **Modern UI/UX** inspired by ElevenLabs
- **Tailwind CSS** for responsive styling
- **Font Awesome Icons** for visual elements
- **Smooth Animations** and hover effects
- **Gradient Backgrounds** and modern color schemes
- **Mobile-First** responsive design

## Technology Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **CSS Framework**: Tailwind CSS
- **Icons**: Font Awesome 6.0
- **Fonts**: Inter & Poppins (Google Fonts)

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- mod_rewrite enabled (for clean URLs)

## Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd taxpulse-pakistan
```

### 2. Set Up Database
1. Create a new MySQL database
2. Import the database schema:
```bash
mysql -u username -p database_name < database/schema.sql
```

### 3. Configure Database Connection
Edit `includes/config.php` and update the database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
```

### 4. Set Up Web Server
Configure your web server to point to the project directory. Ensure the following:
- PHP is properly configured
- mod_rewrite is enabled (for Apache)
- File permissions are set correctly

### 5. Access the Website
- **Main Website**: `http://your-domain.com/`
- **Admin Dashboard**: `http://your-domain.com/dashboard/`
- **Default Admin Credentials**:
  - Username: `admin`
  - Password: `admin123`

## File Structure

```
taxpulse-pakistan/
├── assets/
│   ├── css/
│   └── js/
├── dashboard/
│   ├── index.php
│   ├── posts.php
│   ├── categories.php
│   └── users.php
├── database/
│   └── schema.sql
├── includes/
│   ├── config.php
│   ├── db.php
│   ├── header.php
│   └── footer.php
├── index.php
├── blog.php
├── contact.php
├── services.php
├── about.php
└── README.md
```

## Database Tables

- **users**: User accounts and authentication
- **blog_posts**: Blog content and metadata
- **categories**: Content categorization
- **contact_submissions**: Contact form data
- **newsletter_subscribers**: Email subscription management
- **settings**: Site configuration options

## Customization

### Colors and Styling
Edit `assets/css/style.css` to customize:
- Color schemes
- Typography
- Spacing and layout
- Custom animations

### Content Management
- Update company information in `includes/config.php`
- Modify services in `index.php`
- Edit office locations in `includes/footer.php`
- Customize testimonials and content

### Blog Categories
Add new categories through the admin dashboard or directly in the database.

## Security Features

- **Password Hashing** using bcrypt
- **SQL Injection Prevention** with prepared statements
- **XSS Protection** with input sanitization
- **Session Management** with timeout controls
- **Role-Based Access Control** for admin functions

## Performance Optimization

- **Database Indexing** for faster queries
- **Optimized Images** and assets
- **Minified CSS/JS** (production ready)
- **Efficient Database Queries** with proper joins

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers (iOS Safari, Chrome Mobile)

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support and questions:
- Email: info@taxpulse-pakistan.com
- Phone: +92 21 3582 1757

## Changelog

### Version 1.0.0
- Initial release
- Complete website with blog system
- Admin dashboard
- Responsive design
- Database schema and sample data

## Roadmap

- [ ] Comment system for blog posts
- [ ] Advanced search with filters
- [ ] Multi-language support
- [ ] API endpoints for mobile apps
- [ ] Advanced analytics dashboard
- [ ] Email marketing integration
- [ ] SEO optimization tools
- [ ] Backup and restore functionality

---

**Note**: This is a demonstration website. For production use, ensure all security measures are properly implemented and tested.
