    <!-- Footer -->
    <footer class="footer">
      <!-- Top Banner -->
      <div class="footer-banner">
        <div class="footer-banner-item">
          <div class="footer-banner-logo"></div>
          <span class="footer-banner-text">VELORA</span>
        </div>
        <div class="footer-banner-item">
          <div class="footer-banner-logo"></div>
          <span class="footer-banner-text">LUXURIOUS</span>
        </div>
        <div class="footer-banner-item">
          <div class="footer-banner-logo"></div>
          <span class="footer-banner-text">HOTEL</span>
        </div>
      </div>

      <!-- Main Footer -->
      <div class="footer-main">
        <!-- Company Info -->
        <div class="footer-company">
          <div class="footer-company-header">
            <div class="footer-company-logo"></div>
            <div>
              <div class="footer-company-name">VELORA</div>
              <div class="footer-company-tagline">Luxurious Hotel</div>
            </div>
          </div>

          <h3 class="footer-contact-title">CONTACT INFO</h3>
          <div class="footer-contact-divider"></div>

          <div class="footer-contact-details">
            <div class="footer-contact-detail">
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

            <div class="footer-contact-detail">
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

            <div class="footer-contact-detail">
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

          <!-- Social Media -->
          <div class="footer-social">
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
              <path d="m16 11.37-7-4v8l7-4z" />
            </svg>
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
              <path d="m16 11.37-7-4v8l7-4z" />
            </svg>
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
              <path d="m16 11.37-7-4v8l7-4z" />
            </svg>
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="currentColor"
              stroke-width="2"
            >
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
              <path d="m16 11.37-7-4v8l7-4z" />
            </svg>
          </div>
        </div>

        <!-- Links and Newsletter -->
        <div class="footer-content">
          <div class="footer-grid">
            <!-- Useful Links -->
            <div class="footer-section">
              <h3>USEFUL LINKS</h3>
              <div class="footer-section-divider"></div>
              <div class="footer-links">
                <a href="/index.php">Home</a>
                <a href="/about.php">About</a>
                <a href="/rooms.php">Rooms</a>
                <a href="/blog.php">Blog</a>
                <a href="/contact.php">Contact</a>
              </div>
            </div>

            <!-- Gallery -->
            <div class="footer-section">
              <h3>GALLERY</h3>
              <div class="footer-section-divider"></div>
              <div class="footer-gallery">
                <div class="footer-gallery-item"></div>
                <div class="footer-gallery-item"></div>
                <div class="footer-gallery-item"></div>
                <div class="footer-gallery-item"></div>
                <div class="footer-gallery-item"></div>
                <div class="footer-gallery-item"></div>
              </div>
            </div>

            <!-- Newsletter -->
            <div class="footer-section footer-newsletter">
              <h3>NEWSLETTER</h3>
              <div class="footer-section-divider"></div>
              <p>Subscribe our Newsletter</p>
              <form action="/api/subscribe_newsletter.php" method="post" class="footer-newsletter-form">
                <input type="email" name="email" class="footer-newsletter-input" placeholder="Enter Email" required>
                <button type="submit" class="footer-newsletter-submit">Subscribe</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <script src="/script.js"></script>
    <?php if (isset($additional_js)): ?>
    <script src="<?php echo $additional_js; ?>"></script>
    <?php endif; ?>
  </body>
</html>
