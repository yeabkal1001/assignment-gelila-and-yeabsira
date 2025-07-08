# Velora Hotel - Luxury Hotel Website

A comprehensive full-stack hotel website featuring a modern design, complete booking system, blog management, and administrative panel. Built with PHP, MySQL, HTML, CSS, and JavaScript.

## About Velora Hotel

Velora Hotel represents luxury, elegance, and exceptional hospitality. Located in the heart of Addis Ababa, just steps from Bole International Airport, our hotel offers the perfect blend of Ethiopian tradition and modern sophistication.

## Features

- Responsive design for all devices
- Online booking system
- Room management
- Blog with categories
- Contact form
- Newsletter subscription
- Admin panel for content management
- User authentication

## Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Other**: SVG icons, Responsive design

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled

### Setup Instructions

1. **Clone the repository**

```bash
git clone https://github.com/yeabkal1001/assignment-gelila-and-yeabsira.git
cd assignment-gelila-and-yeabsira
```

2. **Create a MySQL database**

Create a new MySQL database for the project.

3. **Configure the database connection**

Edit the `config/database.php` file and update the database credentials:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_database_user');
define('DB_PASS', 'your_database_password');
define('DB_NAME', 'your_database_name');
```

4. **Initialize the database**

Run the database initialization script by visiting:

```
http://your-domain.com/config/init_db.php
```

This will create all necessary tables and insert sample data.

### Using Docker (Recommended)

This project includes a `Dockerfile` and `docker-compose.yml` for easy setup and deployment.

1.  **Ensure Docker and Docker Compose are installed.**
    If not, follow the official installation instructions for your operating system.

2.  **Build and run the containers:**
    Open a terminal in the project root directory and run:
    ```bash
    docker-compose up -d --build
    ```
    This command will build the PHP application image and start the application and MySQL database containers in detached mode.

3.  **Access the application:**
    Once the containers are running, you can access the website at:
    ```
    http://localhost:8080
    ```

4.  **Initialize the database (first time only):**
    After starting the containers for the first time, navigate to the following URL in your browser to set up the database schema and populate initial data:
    ```
    http://localhost:8080/config/init_db.php
    ```
    *Note: You only need to do this once. The MySQL data is persisted in a Docker volume (`mysql_data`).*

5.  **Access the admin panel:**
    ```
    http://localhost:8080/admin/
    ```
    Default admin credentials:
    - Username: `admin`
    - Password: `admin123`

6.  **Stopping the application:**
    To stop the containers, run:
    ```bash
    docker-compose down
    ```

7.  **Viewing logs:**
    To view the logs for the application or database:
    ```bash
    docker-compose logs app
    docker-compose logs db
    ```

5. **Set proper permissions**

Ensure the web server has write permissions to the necessary directories:

```bash
chmod -R 755 .
chmod -R 777 images
```

6. **Configure your web server**

Make sure your web server is configured to use the `.htaccess` file for URL rewriting.

## Admin Access

After installation, you can access the admin panel at:

```
http://your-domain.com/admin/
```

Default admin credentials:
- Username: `admin`
- Password: `admin123`

**Important**: Change the default admin password after first login.

## Project Structure

- `/admin` - Admin panel files
- `/api` - API endpoints for forms
- `/config` - Configuration files
- `/images` - Image assets
- `/includes` - Reusable PHP components
- `*.php` - Main website pages
- `styles.css` - Main stylesheet
- `script.js` - Main JavaScript file

## Customization

### Changing Colors

The website uses CSS variables for colors. You can modify them in the `styles.css` file:

```css
:root {
  --velora-dark: #1A1A1A;
  --velora-gold: #C4A962;
  --velora-cream: #F5F5F5;
  --velora-white: #FFFFFF;
  --velora-green: #4D6A6D;
}
```

### Adding New Rooms

You can add new rooms through the admin panel or directly in the database.

### Modifying Content

Most content can be edited through the admin panel. For structural changes, modify the PHP files directly.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Developers

This project was developed by:

- **Yeabsira Kayel** - Full Stack Developer
- **Gelila Gebeyehu** - Full Stack Developer

## Credits

- Design and Development: Yeabsira Kayel and Gelila Gebeyehu
- Images: Sample images used for demonstration purposes only