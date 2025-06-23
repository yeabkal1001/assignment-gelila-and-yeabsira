<?php
/**
 * Newsletter Subscription API Endpoint
 * 
 * This file handles newsletter subscription requests.
 */

// Include necessary files
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get email from form
    $email = sanitize($_POST['email'] ?? '');
    
    // Validate email
    if (empty($email)) {
        setFlashMessage('error', 'Email address is required.');
        redirect($_SERVER['HTTP_REFERER'] ?? '/');
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setFlashMessage('error', 'Please enter a valid email address.');
        redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }
    
    // Check if email already exists in the database
    $stmt = $conn->prepare("SELECT id FROM newsletter_subscribers WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        setFlashMessage('info', 'You are already subscribed to our newsletter.');
        redirect($_SERVER['HTTP_REFERER'] ?? '/');
    }
    
    // Add email to newsletter subscribers
    $stmt = $conn->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
    $stmt->bind_param('s', $email);
    
    if ($stmt->execute()) {
        // Send welcome email (in a real application)
        // mail($email, 'Welcome to Velora Hotel Newsletter', 'Thank you for subscribing to our newsletter!');
        
        setFlashMessage('success', 'Thank you for subscribing to our newsletter!');
    } else {
        setFlashMessage('error', 'There was an error processing your subscription. Please try again.');
    }
    
    // Redirect back to the referring page
    redirect($_SERVER['HTTP_REFERER'] ?? '/');
} else {
    // If not a POST request, redirect to home page
    redirect('/');
}