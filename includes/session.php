<?php
/**
 * Session Management
 *
 * This file handles session initialization and management.
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Set a flash message to be displayed on the next page load
 *
 * @param string $type Message type (success, error, info, warning)
 * @param string $message Message content
 * @return void
 */
function setFlashMessage($type, $message) {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message
    ];
}

/**
 * Get and clear flash message
 *
 * @return array|null Flash message data or null if no message
 */
function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']);
        return $message;
    }
    return null;
}

/**
 * Display flash message if exists
 *
 * @return string HTML for flash message or empty string if no message
 */
function displayFlashMessage() {
    $flash = getFlashMessage();
    if ($flash) {
        return '<div class="flash-message flash-' . $flash['type'] . '">' . $flash['message'] . '</div>';
    }
    return '';
}

/**
 * Log in a user
 *
 * @param int $userId User ID
 * @param string $username Username
 * @param string $role User role
 * @return void
 */
function loginUser($userId, $username, $role) {
    $_SESSION['user_id'] = $userId;
    $_SESSION['username'] = $username;
    $_SESSION['user_role'] = $role;
    $_SESSION['logged_in_at'] = time();

    // Update last login time in database
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
}

/**
 * Log out a user
 *
 * @return void
 */
function logoutUser() {
    // Unset all session variables
    $_SESSION = [];

    // Destroy the session
    session_destroy();
}

/**
 * Require user to be logged in
 * Redirects to login page if not logged in
 *
 * @return void
 */
function requireLogin() {
    if (!isLoggedIn()) {
        setFlashMessage('error', 'You must be logged in to access this page.');
        redirect('/admin/login.php');
    }
}

/**
 * Require user to be an admin
 * Redirects to login page if not an admin
 *
 * @return void
 */
function requireAdmin() {
    requireLogin();

    if (!isAdmin()) {
        setFlashMessage('error', 'You do not have permission to access this page.');
        redirect('/admin/index.php');
    }
}

/**
 * Check if user is logged in
 *
 * @return bool True if user is logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['username']);
}

/**
 * Check if logged in user is an admin
 *
 * @return bool True if user is an admin, false otherwise
 */
function isAdmin() {
    return isLoggedIn() && $_SESSION['user_role'] === 'admin';
}
