<?php
/**
 * Facilities Page
 * 
 * This page displays all hotel facilities.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Get facilities data from database
$facilities = getFacilities();

// Include header
$page_title = 'Our Facilities';
include 'includes/header.php';
?>

    <!-- Hero Section -->
    <section
      class="hero"
      style="
        background-image:
          linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
          url(&quot;images/hero section.png&quot;);
        height: 514px;
      "
    >
      <!-- Hero Content -->
      <div class="hero-content">
        <h1 class="hero-title">Our Facilities</h1>
        <div class="hero-breadcrumb">
          <span class="breadcrumb-home">Home</span> / Facilities
        </div>
      </div>
    </section>

    <!-- Facilities Section -->
    <section class="facilities-page-section">
        <div class="facilities-page-container">
            <div class="facilities-page-header">
                <h2 class="facilities-page-title">HOTEL'S FACILITIES</h2>
                <p class="facilities-page-description">
                    Proactively morph optimal infomediaries rather than accurate expertise.
                    Intrinsicly progressive resources rather than resource-leveling
                </p>
            </div>

            <div class="facilities-page-grid">
                <?php foreach ($facilities as $facility): ?>
                <div class="facilities-page-card">
                    <div class="facilities-page-card-image" style="background-image: url('images/<?php echo htmlspecialchars($facility['image']); ?>');"></div>
                    <div class="facilities-page-card-content">
                        <div class="facilities-page-card-category"><?php echo htmlspecialchars($facility['category']); ?></div>
                        <h3 class="facilities-page-card-title"><?php echo htmlspecialchars($facility['name']); ?></h3>
                        <p class="facilities-page-card-description">
                            <?php echo htmlspecialchars($facility['description']); ?>
                        </p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <style>
        .facilities-page-section {
            padding: 4rem 0;
            background-color: var(--velora-cream);
        }
        
        .facilities-page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .facilities-page-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .facilities-page-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
        }
        
        .facilities-page-description {
            font-size: 1rem;
            color: var(--velora-dark);
            max-width: 700px;
            margin: 0 auto;
        }
        
        .facilities-page-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .facilities-page-card {
            background-color: var(--velora-white);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .facilities-page-card-image {
            height: 250px;
            background-size: cover;
            background-position: center;
        }
        
        .facilities-page-card-content {
            padding: 1.5rem;
        }
        
        .facilities-page-card-category {
            font-size: 0.875rem;
            color: var(--velora-gold);
            margin-bottom: 0.5rem;
        }
        
        .facilities-page-card-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
        }
        
        .facilities-page-card-description {
            font-size: 0.875rem;
            color: var(--velora-dark);
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            .facilities-page-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

<?php
// Include footer
include 'includes/footer.php';
?>