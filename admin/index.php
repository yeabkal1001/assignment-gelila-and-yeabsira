<?php
/**
 * Admin Dashboard
 *
 * This file displays the admin dashboard with summary information.
 */

// Include necessary files
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';

// Require login
requireLogin();

// Get statistics
$stats = [
    'bookings' => 0,
    'rooms' => 0,
    'messages' => 0,
    'subscribers' => 0
];

// Count bookings
$result = $conn->query("SELECT COUNT(*) as count FROM bookings");
if ($result && $row = $result->fetch_assoc()) {
    $stats['bookings'] = $row['count'];
}

// Count rooms
$result = $conn->query("SELECT COUNT(*) as count FROM rooms");
if ($result && $row = $result->fetch_assoc()) {
    $stats['rooms'] = $row['count'];
}

// Count unread messages
$result = $conn->query("SELECT COUNT(*) as count FROM contact_messages WHERE is_read = 0");
if ($result && $row = $result->fetch_assoc()) {
    $stats['messages'] = $row['count'];
}

// Count newsletter subscribers
$result = $conn->query("SELECT COUNT(*) as count FROM newsletter_subscribers");
if ($result && $row = $result->fetch_assoc()) {
    $stats['subscribers'] = $row['count'];
}

// Get recent bookings
$recent_bookings = [];
$result = $conn->query("SELECT b.*, r.name as room_name
                        FROM bookings b
                        JOIN rooms r ON b.room_id = r.id
                        ORDER BY b.created_at DESC
                        LIMIT 5");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_bookings[] = $row;
    }
}

// Get recent messages
$recent_messages = [];
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC LIMIT 5");

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $recent_messages[] = $row;
    }
}

// Set page title
$page_title = 'Admin Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Velora Hotel</title>
    <link rel="stylesheet" href="/styles.css">
    <style>
        /* Admin Dashboard Styles */
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .admin-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--velora-dark);
        }

        .admin-user-info {
            display: flex;
            align-items: center;
        }

        .admin-username {
            margin-right: 1rem;
        }

        .admin-logout {
            padding: 0.5rem 1rem;
            background-color: var(--velora-gold);
            color: var(--velora-white);
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .admin-logout:hover {
            background-color: var(--velora-dark);
        }

        .admin-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .admin-stat-card {
            background-color: var(--velora-white);
            padding: 1.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .admin-stat-title {
            font-size: 1rem;
            color: var(--velora-dark);
            margin-bottom: 0.5rem;
        }

        .admin-stat-value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--velora-gold);
        }

        .admin-sections {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
        }

        .admin-section {
            background-color: var(--velora-white);
            padding: 1.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .admin-section-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
        }

        .admin-table th, .admin-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .admin-table th {
            font-weight: 600;
            color: var(--velora-dark);
        }

        .admin-view-all {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--velora-gold);
            text-decoration: none;
        }

        .admin-view-all:hover {
            text-decoration: underline;
        }

        .admin-navigation {
            display: flex;
            background-color: var(--velora-dark);
            margin-bottom: 2rem;
        }

        .admin-nav-link {
            padding: 1rem 1.5rem;
            color: var(--velora-white);
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .admin-nav-link:hover, .admin-nav-link.active {
            background-color: var(--velora-gold);
        }
    </style>
</head>
<body>
    <?php echo displayFlashMessage(); ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1 class="admin-title">Velora Hotel Admin</h1>

            <div class="admin-user-info">
                <span class="admin-username">Welcome, <?php echo $_SESSION['username']; ?></span>
                <a href="logout.php" class="admin-logout">Logout</a>
            </div>
        </div>

        <div class="admin-navigation">
            <a href="index.php" class="admin-nav-link active">Dashboard</a>
            <a href="bookings.php" class="admin-nav-link">Bookings</a>
            <a href="rooms.php" class="admin-nav-link">Rooms</a>
            <a href="messages.php" class="admin-nav-link">Messages</a>
            <a href="testimonials.php" class="admin-nav-link">Testimonials</a>
            <a href="facilities.php" class="admin-nav-link">Facilities</a>
            <a href="blog.php" class="admin-nav-link">Blog</a>
            <?php if (isAdmin()): ?>
            <a href="users.php" class="admin-nav-link">Users</a>
            <?php endif; ?>
        </div>

        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="admin-stat-title">Total Bookings</div>
                <div class="admin-stat-value"><?php echo $stats['bookings']; ?></div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-title">Available Rooms</div>
                <div class="admin-stat-value"><?php echo $stats['rooms']; ?></div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-title">Unread Messages</div>
                <div class="admin-stat-value"><?php echo $stats['messages']; ?></div>
            </div>

            <div class="admin-stat-card">
                <div class="admin-stat-title">Newsletter Subscribers</div>
                <div class="admin-stat-value"><?php echo $stats['subscribers']; ?></div>
            </div>
        </div>

        <div class="admin-sections">
            <div class="admin-section">
                <h2 class="admin-section-title">Recent Bookings</h2>

                <?php if (!empty($recent_bookings)): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Check-in</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['guest_name']); ?></td>
                            <td><?php echo htmlspecialchars($booking['room_name']); ?></td>
                            <td><?php echo formatDate($booking['check_in']); ?></td>
                            <td><?php echo ucfirst($booking['status']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <a href="bookings.php" class="admin-view-all">View All Bookings</a>
                <?php else: ?>
                <p>No bookings found.</p>
                <?php endif; ?>
            </div>

            <div class="admin-section">
                <h2 class="admin-section-title">Recent Messages</h2>

                <?php if (!empty($recent_messages)): ?>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_messages as $message): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($message['name']); ?></td>
                            <td><?php echo htmlspecialchars($message['subject']); ?></td>
                            <td><?php echo formatDate($message['created_at']); ?></td>
                            <td><?php echo $message['is_read'] ? 'Read' : 'Unread'; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <a href="messages.php" class="admin-view-all">View All Messages</a>
                <?php else: ?>
                <p>No messages found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
