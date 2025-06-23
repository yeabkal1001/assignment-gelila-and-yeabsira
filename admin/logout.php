<?php
/**
 * Admin Logout
 * 
 * This file handles admin logout.
 */

// Include necessary files
require_once '../includes/session.php';

// Log out the user
logoutUser();

// Redirect to login page
setFlashMessage('success', 'You have been logged out successfully.');
redirect('login.php');