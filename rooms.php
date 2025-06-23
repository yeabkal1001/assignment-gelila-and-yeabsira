<?php
/**
 * Rooms Page
 *
 * This page displays all available rooms.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Get rooms data from database
$rooms = getRooms();

// Include header
$page_title = 'Our Rooms';
include_once 'includes/header.php';
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
        <h1 class="hero-title">Our Rooms & Suites</h1>
        <div class="hero-breadcrumb">
          <span class="breadcrumb-home">Home</span> / Rooms
        </div>
      </div>
    </section>

    <!-- Rooms Section -->
    <section class="rooms-page-section">
        <div class="rooms-page-container">
            <div class="rooms-page-header">
                <h2 class="rooms-page-title">Luxury Accommodations</h2>
                <p class="rooms-page-description">
                    Experience the epitome of luxury in our meticulously designed rooms and suites.
                    Each space is crafted to provide the perfect blend of comfort, elegance, and modern amenities.
                </p>
            </div>

            <div class="rooms-page-grid">
                <?php foreach ($rooms as $room): ?>
                <div class="rooms-page-card">
                    <div class="rooms-page-card-image" style="background-image: url('images/<?php echo htmlspecialchars($room['image']); ?>');">
                        <div class="rooms-page-card-price">
                            <span><?php echo formatPrice($room['price']); ?></span>
                            <span>per night</span>
                        </div>
                    </div>
                    <div class="rooms-page-card-content">
                        <div class="rooms-page-card-category"><?php echo htmlspecialchars($room['category']); ?></div>
                        <h3 class="rooms-page-card-title"><?php echo htmlspecialchars($room['name']); ?></h3>
                        <div class="rooms-page-card-details">
                            <div class="rooms-page-card-detail">
                                <span class="rooms-page-card-detail-icon">📏</span>
                                <span class="rooms-page-card-detail-text"><?php echo $room['size']; ?> SQ FT</span>
                            </div>
                            <div class="rooms-page-card-detail">
                                <span class="rooms-page-card-detail-icon">🛏️</span>
                                <span class="rooms-page-card-detail-text"><?php echo htmlspecialchars($room['bed_type']); ?></span>
                            </div>
                            <div class="rooms-page-card-detail">
                                <span class="rooms-page-card-detail-icon">👥</span>
                                <span class="rooms-page-card-detail-text">Max <?php echo $room['capacity']; ?> Guests</span>
                            </div>
                        </div>
                        <p class="rooms-page-card-description">
                            <?php echo htmlspecialchars($room['description']); ?>
                        </p>
                        <div class="rooms-page-card-actions">
                            <a href="/booking.php?room_id=<?php echo $room['id']; ?>" class="rooms-page-card-book">Book Now</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <style>
        .rooms-page-section {
            padding: 4rem 0;
            background-color: var(--velora-cream);
        }

        .rooms-page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .rooms-page-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .rooms-page-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
        }

        .rooms-page-description {
            font-size: 1rem;
            color: var(--velora-dark);
            max-width: 700px;
            margin: 0 auto;
        }

        .rooms-page-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }

        .rooms-page-card {
            background-color: var(--velora-white);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .rooms-page-card-image {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .rooms-page-card-price {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: var(--velora-gold);
            color: var(--velora-white);
            padding: 0.75rem 1.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .rooms-page-card-price span:first-child {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .rooms-page-card-price span:last-child {
            font-size: 0.75rem;
        }

        .rooms-page-card-content {
            padding: 1.5rem;
        }

        .rooms-page-card-category {
            font-size: 0.875rem;
            color: var(--velora-gold);
            margin-bottom: 0.5rem;
        }

        .rooms-page-card-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
        }

        .rooms-page-card-details {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .rooms-page-card-detail {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rooms-page-card-detail-icon {
            font-size: 1rem;
        }

        .rooms-page-card-detail-text {
            font-size: 0.875rem;
            color: var(--velora-dark);
        }

        .rooms-page-card-description {
            font-size: 0.875rem;
            color: var(--velora-dark);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .rooms-page-card-actions {
            display: flex;
            justify-content: center;
        }

        .rooms-page-card-book {
            background-color: var(--velora-gold);
            color: var(--velora-white);
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .rooms-page-card-book:hover {
            background-color: var(--velora-dark);
        }

        @media (max-width: 768px) {
            .rooms-page-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

<?php
// Include footer
include_once 'includes/footer.php';
?>
