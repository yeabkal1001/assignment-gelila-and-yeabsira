<?php
/**
 * Utility Functions
 *
 * This file contains common utility functions used throughout the application.
 */

/**
 * Sanitize user input
 *
 * @param string $data Data to sanitize
 * @return string Sanitized data
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Redirect to a specific URL
 *
 * @param string $url URL to redirect to
 * @return void
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Check if user is logged in
 *
 * @return bool True if user is logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is an admin
 *
 * @return bool True if user is an admin, false otherwise
 */
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

/**
 * Display error message
 *
 * @param string $message Error message to display
 * @return string HTML for error message
 */
function displayError($message) {
    return '<div class="error-message">' . $message . '</div>';
}

/**
 * Display success message
 *
 * @param string $message Success message to display
 * @return string HTML for success message
 */
function displaySuccess($message) {
    return '<div class="success-message">' . $message . '</div>';
}

/**
 * Format date for display
 *
 * @param string $date Date string
 * @param string $format Format string (default: 'F j, Y')
 * @return string Formatted date
 */
function formatDate($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}

/**
 * Format price for display
 *
 * @param float $price Price to format
 * @return string Formatted price
 */
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

/**
 * Get all rooms from database
 *
 * @return array Array of room data
 */
function getRooms() {
    global $conn;
    $result = $conn->query("SELECT * FROM rooms ORDER BY price ASC");
    $rooms = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }

    return $rooms;
}

/**
 * Get room by ID
 *
 * @param int $id Room ID
 * @return array|null Room data or null if not found
 */
function getRoomById($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}

/**
 * Get all facilities from database
 *
 * @return array Array of facility data
 */
function getFacilities() {
    global $conn;
    $result = $conn->query("SELECT * FROM facilities ORDER BY display_order ASC");
    $facilities = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $facilities[] = $row;
        }
    }

    return $facilities;
}

/**
 * Get approved testimonials
 *
 * @param int $limit Maximum number of testimonials to return
 * @return array Array of testimonial data
 */
function getTestimonials($limit = 2) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM testimonials WHERE is_approved = 1 ORDER BY created_at DESC LIMIT ?");
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $testimonials = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $testimonials[] = $row;
        }
    }

    return $testimonials;
}

/**
 * Get recent blog posts
 *
 * @param int $limit Maximum number of posts to return
 * @return array Array of blog post data
 */
function getBlogPosts($limit = 3) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY published_at DESC LIMIT ?");
    $stmt->bind_param('i', $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    }

    return $posts;
}

/**
 * Check if a room is available for booking
 *
 * @param int $roomId Room ID
 * @param string $checkIn Check-in date (Y-m-d format)
 * @param string $checkOut Check-out date (Y-m-d format)
 * @return bool True if room is available, false otherwise
 */
function isRoomAvailable($roomId, $checkIn, $checkOut) {
    global $conn;

    $sql = "SELECT COUNT(*) as count FROM bookings
            WHERE room_id = ?
            AND status != 'cancelled'
            AND (
                (check_in <= ? AND check_out > ?) OR
                (check_in < ? AND check_out >= ?) OR
                (check_in >= ? AND check_out <= ?)
            )";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issssss', $roomId, $checkOut, $checkIn, $checkOut, $checkIn, $checkIn, $checkOut);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return $row['count'] == 0;
}
