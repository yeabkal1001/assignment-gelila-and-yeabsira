<?php
/**
 * Booking Confirmation Page
 *
 * This page displays the booking confirmation details.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Get booking ID from URL
$booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If no booking ID provided, redirect to booking page
if ($booking_id <= 0) {
    setFlashMessage('error', 'Invalid booking reference.');
    redirect('/booking.php');
}

// Get booking details
$stmt = $conn->prepare("SELECT b.*, r.name as room_name, r.price as room_price
                        FROM bookings b
                        JOIN rooms r ON b.room_id = r.id
                        WHERE b.id = ?");
$stmt->bind_param('i', $booking_id);
$stmt->execute();
$result = $stmt->get_result();

// If booking not found, redirect to booking page
if ($result->num_rows === 0) {
    setFlashMessage('error', 'Booking not found.');
    redirect('/booking.php');
}

// Get booking data
$booking = $result->fetch_assoc();

// Calculate total nights and price
$check_in_date = new DateTime($booking['check_in']);
$check_out_date = new DateTime($booking['check_out']);
$nights = $check_in_date->diff($check_out_date)->days;
$total_price = $booking['room_price'] * $nights;

// Include header
$page_title = 'Booking Confirmation';
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
        <h1 class="hero-title">Booking Confirmation</h1>
        <div class="hero-breadcrumb">
          <span class="breadcrumb-home">Home</span> / Booking Confirmation
        </div>
      </div>
    </section>

    <!-- Confirmation Section -->
    <section class="confirmation-section">
        <div class="confirmation-container">
            <div class="confirmation-header">
                <div class="confirmation-check-icon">✓</div>
                <h2 class="confirmation-title">Thank You for Your Booking!</h2>
                <p class="confirmation-subtitle">Your reservation has been confirmed.</p>
            </div>

            <div class="confirmation-details">
                <div class="confirmation-booking-id">
                    <span>Booking Reference:</span>
                    <strong><?php echo str_pad($booking['id'], 6, '0', STR_PAD_LEFT); ?></strong>
                </div>

                <div class="confirmation-info">
                    <div class="confirmation-info-group">
                        <h3>Guest Information</h3>
                        <div class="confirmation-info-item">
                            <span>Name:</span>
                            <span><?php echo htmlspecialchars($booking['guest_name']); ?></span>
                        </div>
                        <div class="confirmation-info-item">
                            <span>Email:</span>
                            <span><?php echo htmlspecialchars($booking['guest_email']); ?></span>
                        </div>
                        <div class="confirmation-info-item">
                            <span>Phone:</span>
                            <span><?php echo htmlspecialchars($booking['guest_phone']); ?></span>
                        </div>
                    </div>

                    <div class="confirmation-info-group">
                        <h3>Booking Details</h3>
                        <div class="confirmation-info-item">
                            <span>Room:</span>
                            <span><?php echo htmlspecialchars($booking['room_name']); ?></span>
                        </div>
                        <div class="confirmation-info-item">
                            <span>Check-in:</span>
                            <span><?php echo formatDate($booking['check_in']); ?></span>
                        </div>
                        <div class="confirmation-info-item">
                            <span>Check-out:</span>
                            <span><?php echo formatDate($booking['check_out']); ?></span>
                        </div>
                        <div class="confirmation-info-item">
                            <span>Nights:</span>
                            <span><?php echo $nights; ?></span>
                        </div>
                        <div class="confirmation-info-item">
                            <span>Guests:</span>
                            <span><?php echo $booking['adults']; ?> Adult<?php echo $booking['adults'] > 1 ? 's' : ''; ?>, <?php echo $booking['children']; ?> Child<?php echo $booking['children'] != 1 ? 'ren' : ''; ?></span>
                        </div>
                    </div>
                </div>

                <div class="confirmation-price">
                    <div class="confirmation-price-item">
                        <span>Room Rate:</span>
                        <span><?php echo formatPrice($booking['room_price']); ?> / night</span>
                    </div>
                    <div class="confirmation-price-item">
                        <span>Number of Nights:</span>
                        <span><?php echo $nights; ?></span>
                    </div>
                    <div class="confirmation-price-total">
                        <span>Total:</span>
                        <span><?php echo formatPrice($total_price); ?></span>
                    </div>
                </div>

                <?php if (!empty($booking['special_requests'])): ?>
                <div class="confirmation-special-requests">
                    <h3>Special Requests</h3>
                    <p><?php echo htmlspecialchars($booking['special_requests']); ?></p>
                </div>
                <?php endif; ?>

                <div class="confirmation-note">
                    <p>A confirmation email has been sent to your email address. Please check your inbox (and spam folder) for details.</p>
                    <p>If you have any questions or need to modify your reservation, please contact us at +251909090909 or email us at reservations@velorahotel.com.</p>
                </div>

                <div class="confirmation-actions">
                    <a href="/index.php" class="confirmation-action-button">Return to Home</a>
                </div>
            </div>
        </div>
    </section>

    <style>
        .confirmation-section {
            padding: 4rem 0;
            background-color: var(--velora-cream);
        }

        .confirmation-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .confirmation-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .confirmation-check-icon {
            width: 80px;
            height: 80px;
            background-color: var(--velora-gold);
            color: var(--velora-white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            margin: 0 auto 1.5rem;
        }

        .confirmation-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 0.5rem;
        }

        .confirmation-subtitle {
            font-size: 1.25rem;
            color: var(--velora-dark);
        }

        .confirmation-details {
            background-color: var(--velora-white);
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .confirmation-booking-id {
            text-align: center;
            padding: 1rem;
            background-color: var(--velora-cream);
            margin-bottom: 2rem;
            font-size: 1.25rem;
        }

        .confirmation-booking-id strong {
            font-weight: 600;
            color: var(--velora-gold);
            margin-left: 0.5rem;
        }

        .confirmation-info {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .confirmation-info-group {
            flex: 1;
        }

        .confirmation-info-group h3 {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .confirmation-info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .confirmation-info-item span:first-child {
            font-weight: 600;
            color: var(--velora-dark);
        }

        .confirmation-price {
            background-color: var(--velora-cream);
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .confirmation-price-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .confirmation-price-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .confirmation-special-requests {
            margin-bottom: 2rem;
        }

        .confirmation-special-requests h3 {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 0.5rem;
        }

        .confirmation-note {
            background-color: #e8f4f8;
            padding: 1.5rem;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .confirmation-note p {
            margin-bottom: 0.5rem;
        }

        .confirmation-actions {
            text-align: center;
        }

        .confirmation-action-button {
            display: inline-block;
            background-color: var(--velora-gold);
            color: var(--velora-white);
            padding: 1rem 2rem;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .confirmation-action-button:hover {
            background-color: var(--velora-dark);
        }

        @media (max-width: 768px) {
            .confirmation-info {
                flex-direction: column;
                gap: 1.5rem;
            }
        }
    </style>

<?php
// Include footer
include_once 'includes/footer.php';
?>
