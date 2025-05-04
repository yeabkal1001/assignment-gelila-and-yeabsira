<?php
/**
 * Header Include File
 *
 * This file contains the common header elements for all pages.
 */

// Include necessary files
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/session.php';

// Get current page for navigation highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($page_title) ? $page_title . ' - Velora Hotel' : 'Velora Hotel - Luxury Redefined'; ?></title>
    <link rel="stylesheet" href="/styles.css" />
    <?php if (isset($additional_css)): ?>
    <link rel="stylesheet" href="<?php echo $additional_css; ?>" />
    <?php endif; ?>
  </head>
  <body>
    <?php echo displayFlashMessage(); ?>

    <!-- Navigation Bar -->
    <nav class="navbar">
      <div class="nav-container">
        <!-- Logo -->
        <div class="nav-logo">
          <img
            src="/images/logo.png"
            alt="Velora Logo"
          />
        </div>

        <!-- Navigation Links -->
        <ul class="nav-links">
          <li><a href="/index.php" <?php echo $current_page == 'index.php' ? 'class="active"' : ''; ?>>Home</a></li>
          <li><a href="/about.php" <?php echo $current_page == 'about.php' ? 'class="active"' : ''; ?>>About</a></li>
          <li><a href="/rooms.php" <?php echo $current_page == 'rooms.php' ? 'class="active"' : ''; ?>>Rooms</a></li>
          <li><a href="/blog.php" <?php echo $current_page == 'blog.php' ? 'class="active"' : ''; ?>>Blog</a></li>
          <li><a href="/contact.php" <?php echo $current_page == 'contact.php' ? 'class="active"' : ''; ?>>Contact</a></li>
          <li><a href="/facilities.php" <?php echo $current_page == 'facilities.php' ? 'class="active"' : ''; ?>>Services</a></li>
        </ul>

        <!-- Book Now Button -->
        <a href="/booking.php" class="nav-button">Book Online</a>
      </div>
    </nav>
