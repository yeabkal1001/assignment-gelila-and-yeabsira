<?php
/**
 * Contact Page
 * 
 * This page displays the contact form and contact information.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Get form data and errors from session if they exist
$form_data = $_SESSION['contact_form_data'] ?? [];
$form_errors = $_SESSION['contact_form_errors'] ?? [];

// Clear session data
unset($_SESSION['contact_form_data']);
unset($_SESSION['contact_form_errors']);

// Include header
$page_title = 'Contact Us';
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
        <h1 class="hero-title">Contact Us</h1>
        <div class="hero-breadcrumb">
          <span class="breadcrumb-home">Home</span> / Contact
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
      <!-- Contact Information -->
      <div class="contact-info">
        <div class="contact-badge">
          <span class="contact-badge-text">CONTACT US</span>
        </div>

        <h2 class="contact-title">CONTACT WITH US</h2>

        <p class="contact-description">
          Have a question or ready to book your stay? We're here to help—reach
          out anytime and our team will respond promptly.
        </p>

        <!-- Contact Details -->
        <div class="contact-details">
          <!-- Call Us -->
          <div class="contact-detail">
            <h3>Call Us Now</h3>
            <div class="contact-detail-content">
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"
                />
              </svg>
              <span>+251909090909</span>
            </div>
            <div class="contact-divider"></div>
          </div>

          <!-- Email -->
          <div class="contact-detail">
            <h3>Send Email</h3>
            <div class="contact-detail-content">
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path
                  d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"
                />
                <polyline points="22,6 12,13 2,6" />
              </svg>
              <span>EXAMPLE@GMAIL</span>
            </div>
            <div class="contact-divider"></div>
          </div>

          <!-- Location -->
          <div class="contact-detail">
            <h3>Our Location</h3>
            <div class="contact-detail-content">
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                <circle cx="12" cy="10" r="3" />
              </svg>
              <span>Bole Sub City Woreda 03, Addis Ababa, velora hotel</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form -->
      <div class="contact-form">
        <h3 class="form-title">GET IN TOUCH</h3>

        <?php if (!empty($form_errors)): ?>
        <div class="form-errors">
            <?php foreach ($form_errors as $error): ?>
            <div class="form-error"><?php echo $error; ?></div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="/api/contact_form.php" method="post">
          <div class="form-group">
            <input
              type="text"
              class="form-input"
              placeholder="Your Name"
              name="name"
              value="<?php echo htmlspecialchars($form_data['name'] ?? ''); ?>"
              required
            />
          </div>

          <div class="form-group">
            <input
              type="email"
              class="form-input"
              placeholder="Enter Email"
              name="email"
              value="<?php echo htmlspecialchars($form_data['email'] ?? ''); ?>"
              required
            />
          </div>

          <div class="form-group">
            <input
              type="text"
              class="form-input"
              placeholder="Subject One"
              name="subject"
              value="<?php echo htmlspecialchars($form_data['subject'] ?? ''); ?>"
              required
            />
          </div>

          <div class="form-group">
            <textarea
              class="form-input form-textarea"
              placeholder="Write Message;"
              name="message"
              required
            ><?php echo htmlspecialchars($form_data['message'] ?? ''); ?></textarea>
          </div>

          <button type="submit" class="form-submit">Send Message</button>
        </form>
      </div>
    </section>

<?php
// Include footer
include 'includes/footer.php';
?>