<?php
/**
 * Booking Page
 * 
 * This page displays the booking form.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Get room ID from URL if provided
$room_id = isset($_GET['room_id']) ? (int)$_GET['room_id'] : 0;
$selected_room = null;

if ($room_id > 0) {
    $selected_room = getRoomById($room_id);
}

// Get all rooms for selection
$rooms = getRooms();

// Get form data and errors from session if they exist
$form_data = $_SESSION['booking_form_data'] ?? [];
$form_errors = $_SESSION['booking_form_errors'] ?? [];

// Clear session data
unset($_SESSION['booking_form_data']);
unset($_SESSION['booking_form_errors']);

// Include header
$page_title = 'Book Your Stay';
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
        <h1 class="hero-title">Book Your Stay</h1>
        <div class="hero-breadcrumb">
          <span class="breadcrumb-home">Home</span> / Booking
        </div>
      </div>
    </section>

    <!-- Booking Section -->
    <section class="booking-page-section">
        <div class="booking-page-container">
            <div class="booking-page-header">
                <h2 class="booking-page-title">Make a Reservation</h2>
                <p class="booking-page-description">
                    Complete the form below to book your stay at Velora Hotel. We look forward to welcoming you.
                </p>
            </div>

            <?php if (!empty($form_errors)): ?>
            <div class="booking-page-errors">
                <?php foreach ($form_errors as $error): ?>
                <div class="booking-page-error"><?php echo $error; ?></div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="booking-page-content">
                <!-- Room Selection -->
                <?php if ($selected_room): ?>
                <div class="booking-page-selected-room">
                    <h3>Selected Room: <?php echo htmlspecialchars($selected_room['name']); ?></h3>
                    <div class="booking-page-room-details">
                        <div class="booking-page-room-image" style="background-image: url('images/<?php echo htmlspecialchars($selected_room['image']); ?>');"></div>
                        <div class="booking-page-room-info">
                            <div class="booking-page-room-category"><?php echo htmlspecialchars($selected_room['category']); ?></div>
                            <div class="booking-page-room-price"><?php echo formatPrice($selected_room['price']); ?> / night</div>
                            <div class="booking-page-room-size"><?php echo $selected_room['size']; ?> SQ FT</div>
                            <div class="booking-page-room-bed"><?php echo htmlspecialchars($selected_room['bed_type']); ?></div>
                            <div class="booking-page-room-capacity">Max Occupancy: <?php echo $selected_room['capacity']; ?> guests</div>
                            <div class="booking-page-room-description"><?php echo htmlspecialchars($selected_room['description']); ?></div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Booking Form -->
                <form action="/api/booking_form.php" method="post" class="booking-page-form">
                    <?php if ($selected_room): ?>
                    <input type="hidden" name="room_id" value="<?php echo $selected_room['id']; ?>">
                    <?php else: ?>
                    <div class="booking-page-form-group">
                        <label for="room_id">Select Room:</label>
                        <select name="room_id" id="room_id" required>
                            <option value="">-- Select a Room --</option>
                            <?php foreach ($rooms as $room): ?>
                            <option value="<?php echo $room['id']; ?>" <?php echo (isset($form_data['room_id']) && $form_data['room_id'] == $room['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($room['name']); ?> (<?php echo formatPrice($room['price']); ?>/night)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>

                    <div class="booking-page-form-row">
                        <div class="booking-page-form-group">
                            <label for="check_in">Check-in Date:</label>
                            <input type="date" name="check_in" id="check_in" value="<?php echo htmlspecialchars($form_data['check_in'] ?? ''); ?>" required>
                        </div>

                        <div class="booking-page-form-group">
                            <label for="check_out">Check-out Date:</label>
                            <input type="date" name="check_out" id="check_out" value="<?php echo htmlspecialchars($form_data['check_out'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="booking-page-form-row">
                        <div class="booking-page-form-group">
                            <label for="adults">Adults:</label>
                            <select name="adults" id="adults" required>
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo (isset($form_data['adults']) && $form_data['adults'] == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?> Adult<?php echo $i > 1 ? 's' : ''; ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="booking-page-form-group">
                            <label for="children">Children:</label>
                            <select name="children" id="children">
                                <?php for ($i = 0; $i <= 3; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo (isset($form_data['children']) && $form_data['children'] == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?> Child<?php echo $i != 1 ? 'ren' : ''; ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="booking-page-form-group">
                        <label for="guest_name">Full Name:</label>
                        <input type="text" name="guest_name" id="guest_name" value="<?php echo htmlspecialchars($form_data['guest_name'] ?? ''); ?>" required>
                    </div>

                    <div class="booking-page-form-row">
                        <div class="booking-page-form-group">
                            <label for="guest_email">Email:</label>
                            <input type="email" name="guest_email" id="guest_email" value="<?php echo htmlspecialchars($form_data['guest_email'] ?? ''); ?>" required>
                        </div>

                        <div class="booking-page-form-group">
                            <label for="guest_phone">Phone:</label>
                            <input type="tel" name="guest_phone" id="guest_phone" value="<?php echo htmlspecialchars($form_data['guest_phone'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="booking-page-form-group">
                        <label for="special_requests">Special Requests:</label>
                        <textarea name="special_requests" id="special_requests" rows="4"><?php echo htmlspecialchars($form_data['special_requests'] ?? ''); ?></textarea>
                    </div>

                    <div class="booking-page-form-submit">
                        <button type="submit" class="booking-page-submit-button">Book Now</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <style>
        .booking-page-section {
            padding: 4rem 0;
            background-color: var(--velora-cream);
        }
        
        .booking-page-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .booking-page-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .booking-page-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
        }
        
        .booking-page-description {
            font-size: 1rem;
            color: var(--velora-dark);
            max-width: 600px;
            margin: 0 auto;
        }
        
        .booking-page-errors {
            background-color: #ffebee;
            border-left: 4px solid #f44336;
            padding: 1rem;
            margin-bottom: 2rem;
        }
        
        .booking-page-error {
            color: #d32f2f;
            margin-bottom: 0.5rem;
        }
        
        .booking-page-content {
            background-color: var(--velora-white);
            padding: 2rem;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .booking-page-selected-room {
            margin-bottom: 2rem;
            padding-bottom: 2rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .booking-page-selected-room h3 {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
        }
        
        .booking-page-room-details {
            display: flex;
            gap: 2rem;
        }
        
        .booking-page-room-image {
            width: 300px;
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        
        .booking-page-room-info {
            flex: 1;
        }
        
        .booking-page-room-category {
            font-size: 0.875rem;
            color: var(--velora-gold);
            margin-bottom: 0.5rem;
        }
        
        .booking-page-room-price {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 0.5rem;
        }
        
        .booking-page-room-size,
        .booking-page-room-bed,
        .booking-page-room-capacity {
            font-size: 0.875rem;
            color: var(--velora-dark);
            margin-bottom: 0.5rem;
        }
        
        .booking-page-room-description {
            font-size: 0.875rem;
            color: var(--velora-dark);
            margin-top: 1rem;
        }
        
        .booking-page-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }
        
        .booking-page-form-row {
            display: flex;
            gap: 1rem;
        }
        
        .booking-page-form-row .booking-page-form-group {
            flex: 1;
        }
        
        .booking-page-form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 0.5rem;
        }
        
        .booking-page-form-group input,
        .booking-page-form-group select,
        .booking-page-form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 1rem;
        }
        
        .booking-page-form-submit {
            margin-top: 1rem;
        }
        
        .booking-page-submit-button {
            background-color: var(--velora-gold);
            color: var(--velora-white);
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .booking-page-submit-button:hover {
            background-color: var(--velora-dark);
        }
        
        @media (max-width: 768px) {
            .booking-page-room-details {
                flex-direction: column;
            }
            
            .booking-page-room-image {
                width: 100%;
                height: 200px;
            }
            
            .booking-page-form-row {
                flex-direction: column;
                gap: 1.5rem;
            }
        }
    </style>

<?php
// Include footer
include 'includes/footer.php';
?>