<?php
/**
 * Admin Login Page
 * 
 * This file handles admin authentication.
 */

// Include necessary files
require_once '../config/database.php';
require_once '../includes/functions.php';
require_once '../includes/session.php';

// Check if user is already logged in
if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    // Validate form data
    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password.';
    } else {
        // Check if user exists
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Login successful
                loginUser($user['id'], $user['username'], $user['role']);
                
                setFlashMessage('success', 'Welcome back, ' . $user['username'] . '!');
                redirect('index.php');
            } else {
                $error = 'Invalid username or password.';
            }
        } else {
            $error = 'Invalid username or password.';
        }
    }
}

// Set page title
$page_title = 'Admin Login';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Velora Hotel</title>
    <link rel="stylesheet" href="/styles.css">
    <style>
        .admin-login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background-color: var(--velora-white);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .admin-login-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 2rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .admin-login-form {
            display: flex;
            flex-direction: column;
        }
        
        .admin-login-input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            font-size: 1rem;
        }
        
        .admin-login-button {
            padding: 0.75rem;
            background-color: var(--velora-gold);
            color: var(--velora-white);
            border: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .admin-login-button:hover {
            background-color: var(--velora-dark);
        }
        
        .admin-login-error {
            color: #ff0000;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .admin-login-logo {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .admin-login-logo img {
            max-width: 150px;
        }
    </style>
</head>
<body>
    <?php echo displayFlashMessage(); ?>
    
    <div class="admin-login-container">
        <div class="admin-login-logo">
            <img src="/images/logo.png" alt="Velora Hotel Logo">
        </div>
        
        <h1 class="admin-login-title">Admin Login</h1>
        
        <?php if (!empty($error)): ?>
        <div class="admin-login-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form class="admin-login-form" method="post" action="">
            <input type="text" name="username" class="admin-login-input" placeholder="Username" required>
            <input type="password" name="password" class="admin-login-input" placeholder="Password" required>
            <button type="submit" class="admin-login-button">Login</button>
        </form>
    </div>
</body>
</html>