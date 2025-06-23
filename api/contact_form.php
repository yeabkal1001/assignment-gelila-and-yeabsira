<?php
/**
 * Contact Form API Endpoint
 * 
 * This file handles the contact form submission.
 */

// Include necessary files
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $subject = sanitize($_POST['subject'] ?? '');
    $message = sanitize($_POST['message'] ?? '');
    
    // Validate form data
    $errors = [];
    
    if (empty($name)) {
        $errors[] = 'Name is required.';
    }
    
    if (empty($email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    
    if (empty($subject)) {
        $errors[] = 'Subject is required.';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required.';
    }
    
    // If there are no errors, save the message to the database
    if (empty($errors)) {
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssss', $name, $email, $subject, $message);
        
        if ($stmt->execute()) {
            // Send email notification (in a real application)
            // mail('admin@velorahotel.com', 'New Contact Form Submission', "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message");
            
            setFlashMessage('success', 'Thank you for your message! We will get back to you soon.');
            redirect('/contact.php');
        } else {
            setFlashMessage('error', 'There was an error sending your message. Please try again.');
            redirect('/contact.php');
        }
    } else {
        // Store errors in session and redirect back to form
        $_SESSION['contact_form_errors'] = $errors;
        $_SESSION['contact_form_data'] = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message
        ];
        
        redirect('/contact.php');
    }
} else {
    // If not a POST request, redirect to contact page
    redirect('/contact.php');
}