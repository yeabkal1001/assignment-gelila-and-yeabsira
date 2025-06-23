<?php
/**
 * 404 Error Page
 * 
 * This page is displayed when a requested page is not found.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Set HTTP response code
http_response_code(404);

// Include header
$page_title = 'Page Not Found';
include 'includes/header.php';
?>

    <!-- 404 Section -->
    <section class="error-404-section">
        <div class="error-404-container">
            <div class="error-404-content">
                <h1 class="error-404-title">404</h1>
                <h2 class="error-404-subtitle">Page Not Found</h2>
                <p class="error-404-description">
                    The page you are looking for might have been removed, had its name changed, 
                    or is temporarily unavailable.
                </p>
                <div class="error-404-actions">
                    <a href="/" class="error-404-button">Return to Home</a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .error-404-section {
            padding: 6rem 0;
            background-color: var(--velora-cream);
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-404-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .error-404-content {
            text-align: center;
            background-color: var(--velora-white);
            padding: 3rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .error-404-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 6rem;
            font-weight: 600;
            color: var(--velora-gold);
            margin-bottom: 1rem;
            line-height: 1;
        }
        
        .error-404-subtitle {
            font-family: "Cormorant Garamond", serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1.5rem;
        }
        
        .error-404-description {
            font-size: 1rem;
            color: var(--velora-dark);
            margin-bottom: 2rem;
        }
        
        .error-404-actions {
            margin-top: 2rem;
        }
        
        .error-404-button {
            display: inline-block;
            background-color: var(--velora-gold);
            color: var(--velora-white);
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .error-404-button:hover {
            background-color: var(--velora-dark);
        }
    </style>

<?php
// Include footer
include 'includes/footer.php';
?>