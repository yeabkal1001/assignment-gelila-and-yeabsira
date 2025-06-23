<?php
/**
 * Booking Form API Endpoint
 * 
 * This file handles the booking form submission.
 */

// Include necessary files
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $room_id = isset($_POST['room_id']) ? (int)$_POST['room_id'] : 0;
    $guest_name = sanitize($_POST['guest_name'] ?? '');
    $guest_email = sanitize($_POST['guest_email'] ?? '');
    $guest_phone = sanitize($_POST['guest_phone'] ?? '');
    $check_in = sanitize($_POST['check_in'] ?? '');
    $check_out = sanitize($_POST['check_out'] ?? '');
    $adults = isset($_POST['adults']) ? (int)$_POST['adults'] : 1;
    $children = isset($_POST['children']) ? (int)$_POST['children'] : 0;
    $special_requests = sanitize($_POST['special_requests'] ?? '');
    
    // Validate form data
    $errors = [];
    
    if ($room_id <= 0) {
        $errors[] = 'Please select a valid room.';
    }
    
    if (empty($guest_name)) {
        $errors[] = 'Name is required.';
    }
    
    if (empty($guest_email)) {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($guest_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }
    
    if (empty($guest_phone)) {
        $errors[] = 'Phone number is required.';
    }
    
    if (empty($check_in)) {
        $errors[] = 'Check-in date is required.';
    }
    
    if (empty($check_out)) {
        $errors[] = 'Check-out date is required.';
    }
    
    // Validate dates
    $check_in_date = strtotime($check_in);
    $check_out_date = strtotime($check_out);
    $today = strtotime(date('Y-m-d'));
    
    if ($check_in_date < $today) {
        $errors[] = 'Check-in date cannot be in the past.';
    }
    
    if ($check_out_date <= $check_in_date) {
        $errors[] = 'Check-out date must be after check-in date.';
    }
    
    // Check if room is available for the selected dates
    if ($room_id > 0 && $check_in_date && $check_out_date && $check_out_date > $check_in_date) {
        if (!isRoomAvailable($room_id, date('Y-m-d', $check_in_date), date('Y-m-d', $check_out_date))) {
            $errors[] = 'The selected room is not available for the chosen dates.';
        }
    }
    
    // If there are no errors, save the booking to the database
    if (empty($errors)) {
        $sql = "INSERT INTO bookings (room_id, guest_name, guest_email, guest_phone, check_in, check_out, adults, children, special_requests) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        $check_in_formatted = date('Y-m-d', $check_in_date);
        $check_out_formatted = date('Y-m-d', $check_out_date);
        
        $stmt->bind_param('isssssiss', $room_id, $guest_name, $guest_email, $guest_phone, $check_in_formatted, $check_out_formatted, $adults, $children, $special_requests);
        
        if ($stmt->execute()) {
            $booking_id = $conn->insert_id;
            
            // Send email confirmation (in a real application)
            // mail($guest_email, 'Booking Confirmation - Velora Hotel', "Thank you for your booking!\n\nBooking ID: $booking_id\nCheck-in: $check_in_formatted\nCheck-out: $check_out_formatted");
            
            setFlashMessage('success', 'Thank you for your booking! We have sent a confirmation to your email.');
            redirect('/booking_confirmation.php?id=' . $booking_id);
        } else {
            setFlashMessage('error', 'There was an error processing your booking. Please try again.');
            redirect('/booking.php');
        }
    } else {
        // Store errors in session and redirect back to form
        $_SESSION['booking_form_errors'] = $errors;
        $_SESSION['booking_form_data'] = [
            'room_id' => $room_id,
            'guest_name' => $guest_name,
            'guest_email' => $guest_email,
            'guest_phone' => $guest_phone,
            'check_in' => $check_in,
            'check_out' => $check_out,
            'adults' => $adults,
            'children' => $children,
            'special_requests' => $special_requests
        ];
        
        redirect('/booking.php' . ($room_id > 0 ? '?room_id=' . $room_id : ''));
    }
} else {
    // If not a POST request, redirect to booking page
    redirect('/booking.php');
}