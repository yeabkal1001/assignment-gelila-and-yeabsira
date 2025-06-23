<?php
/**
 * Database Initialization Script
 *
 * This script creates the necessary database tables for the Velora Hotel website.
 * Run this script once to set up the database structure.
 */

// Include database configuration
require_once 'database.php';

// SQL to create rooms table
$sql_rooms = "CREATE TABLE IF NOT EXISTS rooms (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    size INT(11) NOT NULL,
    bed_type VARCHAR(100) NOT NULL,
    capacity INT(11) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

// SQL to create bookings table
$sql_bookings = "CREATE TABLE IF NOT EXISTS bookings (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    room_id INT(11) UNSIGNED NOT NULL,
    guest_name VARCHAR(255) NOT NULL,
    guest_email VARCHAR(255) NOT NULL,
    guest_phone VARCHAR(50) NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    adults INT(11) NOT NULL DEFAULT 1,
    children INT(11) NOT NULL DEFAULT 0,
    special_requests TEXT,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE
)";

// SQL to create contact_messages table
$sql_contact = "CREATE TABLE IF NOT EXISTS contact_messages (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// SQL to create newsletter_subscribers table
$sql_newsletter = "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// SQL to create users table for admin access
$sql_users = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    full_name VARCHAR(255) NOT NULL,
    role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
)";

// SQL to create testimonials table
$sql_testimonials = "CREATE TABLE IF NOT EXISTS testimonials (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    guest_name VARCHAR(255) NOT NULL,
    guest_location VARCHAR(255),
    rating INT(1) NOT NULL,
    message TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// SQL to create facilities table
$sql_facilities = "CREATE TABLE IF NOT EXISTS facilities (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    display_order INT(11) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

// SQL to create blog_posts table
$sql_blog = "CREATE TABLE IF NOT EXISTS blog_posts (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    category VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    image VARCHAR(255),
    author_id INT(11) UNSIGNED,
    is_published BOOLEAN DEFAULT FALSE,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
)";

// Execute the SQL statements
$conn->query($sql_rooms);
$conn->query($sql_bookings);
$conn->query($sql_contact);
$conn->query($sql_newsletter);
$conn->query($sql_users);
$conn->query($sql_testimonials);
$conn->query($sql_facilities);
$conn->query($sql_blog);

// Insert default admin user (password: admin123)
$default_admin_password = password_hash('admin123', PASSWORD_DEFAULT);
$sql_insert_admin = "INSERT IGNORE INTO users (username, password, email, full_name, role)
                     VALUES ('admin', ?, 'admin@velorahotel.com', 'Administrator', 'admin')";
$stmt = $conn->prepare($sql_insert_admin);
$stmt->bind_param('s', $default_admin_password);
$stmt->execute();

// Insert sample rooms data
$sample_rooms = [
    [
        'Single Room', 'Luxury Room', 150.00, 150, '1 King Bed', 1,
        'Our Single Room offers the perfect blend of comfort and luxury for the solo traveler.',
        'Frame 28 (1).png'
    ],
    [
        'Double Room', 'Luxury Room', 250.00, 200, '2 Queen Beds', 2,
        'Spacious and elegant, our Double Room is perfect for couples or small families.',
        'Frame 28 (1).png'
    ],
    [
        'Suite Room', 'Luxury Room', 400.00, 300, '1 King Suite', 2,
        'Experience the ultimate in luxury with our spacious Suite Room, featuring separate living and sleeping areas.',
        'Frame 28 (1).png'
    ]
];

$sql_insert_room = "INSERT INTO rooms (name, category, price, size, bed_type, capacity, description, image)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert_room);

foreach ($sample_rooms as $room) {
    $stmt->bind_param('ssdiisss', $room[0], $room[1], $room[2], $room[3], $room[4], $room[5], $room[6], $room[7]);
    $stmt->execute();
}

// Insert sample facilities
$sample_facilities = [
    ['Gym Training Grounds', 'Fitness', 'State-of-the-art fitness center with the latest equipment and personal trainers.', 'Frame 50 (2).png', 1],
    ['Swimming Pool', 'Fitness', 'Luxurious indoor and outdoor swimming pools with temperature control.', 'Frame 50 (1).png', 2],
    ['The Restaurant Center', 'FOODS', 'Fine dining restaurant offering international cuisine prepared by world-class chefs.', 'Frame 50 (3).png', 3],
    ['Lobby', 'EXPERIENCE', 'Elegant and spacious lobby with comfortable seating and 24/7 concierge service.', 'Frame 50 (3).png', 4],
    ['Room Service', 'Service', '24/7 room service offering a wide range of meals and beverages.', 'Frame 60.png', 5],
    ['Spa & Wellness', 'Relaxation', 'Rejuvenate your body and mind with our premium spa treatments.', 'Frame 60.png', 6]
];

$sql_insert_facility = "INSERT INTO facilities (name, category, description, image, display_order)
                        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert_facility);

foreach ($sample_facilities as $facility) {
    $stmt->bind_param('ssssi', $facility[0], $facility[1], $facility[2], $facility[3], $facility[4]);
    $stmt->execute();
}

// Insert sample testimonials
$sample_testimonials = [
    [
        'Leila Tesfaye', 'Nairobi, Kenya', 5,
        'From the warm welcome at check-in to the serene spa experience, every detail at Velora made us feel like royalty. The rooms are stunning, the staff genuinely caring, and the location perfect for exploring Addis. We extended our stay because we simply didn\'t want to leave.',
        true
    ],
    [
        'Michael Johnson', 'London, UK', 5,
        'Velora Hotel exceeded all my expectations. The attention to detail in every aspect of my stay was impressive. From the exquisite room design to the impeccable service, everything was perfect.',
        true
    ]
];

$sql_insert_testimonial = "INSERT INTO testimonials (guest_name, guest_location, rating, message, is_approved)
                          VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert_testimonial);

foreach ($sample_testimonials as $testimonial) {
    $stmt->bind_param('ssisi', $testimonial[0], $testimonial[1], $testimonial[2], $testimonial[3], $testimonial[4]);
    $stmt->execute();
}

// Insert sample blog posts
$sample_posts = [
    [
        'Inside Velora: The Art of Boutique Interior Design',
        'inside-velora-interior-design',
        'INTERIOR',
        'Discover the inspiration behind Velora\'s stunning interior design, where Ethiopian heritage meets contemporary luxury...',
        'Frame 32 (1).png',
        1,
        true
    ],
    [
        'Culinary Journey: The Flavors of Velora',
        'culinary-journey-flavors-of-velora',
        'FOOD',
        'Explore the unique culinary experiences offered at Velora Hotel, featuring local ingredients and international techniques...',
        'Frame 32 (1).png',
        1,
        true
    ],
    [
        'Wellness Retreat: Rejuvenate at Velora Spa',
        'wellness-retreat-velora-spa',
        'WELLNESS',
        'Learn about our holistic approach to wellness and the exclusive treatments available at our award-winning spa...',
        'Frame 32 (1).png',
        1,
        true
    ]
];

$sql_insert_post = "INSERT INTO blog_posts (title, slug, category, content, image, author_id, is_published, published_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $conn->prepare($sql_insert_post);

foreach ($sample_posts as $post) {
    $stmt->bind_param('sssssii', $post[0], $post[1], $post[2], $post[3], $post[4], $post[5], $post[6]);
    $stmt->execute();
}

echo "Database initialization completed successfully!";

// Close connection
$conn->close();
