<?php
/**
 * Home Page
 *
 * This is the main landing page for the Velora Hotel website.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Get rooms data from database
$rooms = getRooms();

// Get testimonials from database
$testimonials = getTestimonials(2);

// Get blog posts from database
$blog_posts = getBlogPosts(3);

// Include header
$page_title = 'Luxury Redefined';
include_once 'includes/header.php';
?>

    <!-- Hero Section -->
    <section class="hero" style="background-image: url('images/hero section.png');">
      <div class="hero-overlay"></div>

      <!-- Hero Content -->
      <div class="hero-content">
        <div class="hero-stars">
          <div class="hero-star"></div>
          <div class="hero-star"></div>
          <div class="hero-star"></div>
          <div class="hero-star"></div>
          <div class="hero-star"></div>
        </div>
        <h1 class="hero-title">The Best Luxury Hotel Velora Hotel</h1>
        <button class="hero-discover-btn" onclick="window.location.href='#rooms'">Discover More</button>
      </div>

      <!-- Phone Number -->
      <div class="hero-phone">
        <div class="hero-phone-number">+251909090909</div>
      </div>
    </section>

    <!-- Booking Section Centered Below Hero -->
    <div style="display: flex; justify-content: center; align-items: center; width: 100%; margin-top: -60px; margin-bottom: 0; z-index: 10; position: relative;">
      <div class="booking-form" id="booking">
        <form action="/api/booking_form.php" method="post">
          <!-- Check In -->
          <div class="booking-field">
            <div class="booking-field-label">Check in</div>
            <div class="booking-field-value">
              <input type="date" name="check_in" id="checkin-date" required>
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
            </div>
          </div>

          <!-- Check Out -->
          <div class="booking-field">
            <div class="booking-field-label">Check out</div>
            <div class="booking-field-value">
              <input type="date" name="check_out" id="checkout-date" required>
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
            </div>
          </div>

          <!-- Rooms -->
          <div class="booking-field">
            <div class="booking-field-value">
              <span>Rooms</span>
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <polyline points="6,9 12,15 18,9"></polyline>
              </svg>
            </div>
            <div class="booking-field-label" id="rooms-count">
              <select name="room_id" required>
                <option value="">Select a Room</option>
                <?php foreach ($rooms as $room): ?>
                <option value="<?php echo $room['id']; ?>"><?php echo htmlspecialchars($room['name']); ?> (<?php echo formatPrice($room['price']); ?>/night)</option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Guests -->
          <div class="booking-field">
            <div class="booking-field-value">
              <span>Guests</span>
              <svg
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <polyline points="6,9 12,15 18,9"></polyline>
              </svg>
            </div>
            <div class="booking-field-label" id="guests-count">
              <select name="adults" required>
                <option value="1">1 Adult</option>
                <option value="2">2 Adults</option>
                <option value="3">3 Adults</option>
                <option value="4">4 Adults</option>
              </select>
              <select name="children">
                <option value="0">0 Children</option>
                <option value="1">1 Child</option>
                <option value="2">2 Children</option>
                <option value="3">3 Children</option>
              </select>
            </div>
          </div>

          <!-- Checkout Button -->
          <button type="submit" class="booking-button">
            Check Availability
          </button>
        </form>
      </div>
    </div>

    <!-- Rooms and Suites Section: Remove extra margin/padding at the top -->
    <section id="rooms" class="rooms-section" style="margin-top: 0; padding-top: 0;">
        <div class="rooms-container">
            <!-- Header -->
            <div class="rooms-header">
                <h2 class="rooms-title">Rooms & Suites</h2>
                <p class="rooms-description">Proactively morph optimal infomediaries rather than accurate expertise. Intrinsicly progressive resources rather than resource-leveling</p>
            </div>

            <!-- Room Cards Container -->
            <div class="room-cards-container">
                <?php foreach ($rooms as $room): ?>
                <!-- Room Card -->
                <div class="room-card">
                    <div class="room-card-image" style="background-image: url('images/<?php echo htmlspecialchars($room['image']); ?>');">
                        <div class="room-price-tag">
                            <span class="room-price-text"><?php echo formatPrice($room['price']); ?>/ Night</span>
                        </div>
                    </div>
                    <div class="room-card-content">
                        <div class="room-card-category"><?php echo htmlspecialchars($room['category']); ?></div>
                        <div class="room-card-title"><?php echo htmlspecialchars($room['name']); ?></div>
                        <div class="room-card-size"><?php echo $room['size']; ?> SQ FT/Room</div>

                        <div class="room-card-footer">
                            <div class="room-bed-info">
                                <img class="room-bed-icon" src="images/Frame 60.png" alt="Bed Icon" />
                                <span class="room-bed-text"><?php echo htmlspecialchars($room['bed_type']); ?></span>
                            </div>
                            <div class="room-rating">
                                <div class="room-rating-star"></div>
                                <div class="room-rating-star"></div>
                                <div class="room-rating-star"></div>
                                <div class="room-rating-star"></div>
                                <div class="room-rating-star"></div>
                            </div>
                        </div>

                        <div class="room-divider"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="story-section">
        <div class="story-container">
            <!-- Image Section -->
            <div class="story-image-container">
                <div class="story-image-bg"></div>
                <img class="story-image" src="images/Frame 32 (1).png" alt="Velora Hotel Story" />
            </div>

            <!-- Badge -->
            <div class="story-badge">
                <span class="story-badge-text">Our Story</span>
            </div>

            <!-- Title -->
            <h2 class="story-title">Discover the art of Relaxation & Vacationing</h2>

            <!-- Description -->
            <p class="story-description">Since 1977, Velora Hotel has been a sanctuary of luxury and comfort in the heart of the city. Our commitment to exceptional service and attention to detail has made us the preferred destination for discerning travelers from around the world.</p>

            <!-- Statistics -->
            <div class="story-stats">
                <div class="story-stat">
                    <div class="story-stat-number">250+</div>
                    <div class="story-stat-label">Luxury Rooms</div>
                </div>
                <div class="story-stat">
                    <div class="story-stat-number">50+</div>
                    <div class="story-stat-label">Years Experience</div>
                </div>
                <div class="story-stat">
                    <div class="story-stat-number">1000+</div>
                    <div class="story-stat-label">Happy Guests</div>
                </div>
            </div>

            <!-- Button -->
            <button class="story-more-button" onclick="window.location.href='about.php'">
                More About
            </button>
        </div>
    </section>

    <!-- Hotel Facilities Section -->
    <section class="facilities-section">
      <h2 class="facilities-title">HOTEL'S FACILITIES</h2>
      <p class="facilities-description">
        Proactively morph optimal infomediaries rather than accurate expertise.
        Intrinsicly progressive resources rather than resource-leveling
      </p>

      <!-- Facilities Grid -->
      <div class="facilities-grid">
        <?php
        $facilities = getFacilities();
        foreach ($facilities as $index => $facility):
            if ($index >= 6) break; // Only show first 6 facilities
        ?>
        <div class="facility-card">
          <div class="facility-icon" style="background-image: url('images/<?php echo htmlspecialchars($facility['image']); ?>');"></div>
          <div class="facility-divider"></div>
          <div class="facility-text"><?php echo htmlspecialchars($facility['name']); ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </section>

    <!-- Facilities Detail Section -->
    <section class="section">
      <div class="container">
        <!-- Section Header -->
        <div class="facilities-detail-header">
          <div>
            <div class="about-badge" style="margin-bottom: 1rem">
              <span class="about-badge-text">FACILITIES</span>
            </div>
            <h2 class="about-title facilities-detail-title">
              ENJOY COMPLETE &amp;BEST QUALITY FACILITIES
            </h2>
          </div>
          <div class="why-choose-button">
            <span class="facilities-detail-view-more">view more item</span>
          </div>
        </div>

        <!-- Facilities Items -->
        <div class="facilities-detail-items">
          <?php foreach ($facilities as $index => $facility):
              if ($index >= 3) break; // Only show first 3 detailed facilities

              // Alternate layout for even/odd items
              $isEven = $index % 2 === 1;
          ?>

          <?php if (!$isEven): ?>
          <!-- Facility <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?> -->
          <div class="facility-detail-item">
            <div class="facility-detail-image" style="background-image: url('images/<?php echo htmlspecialchars($facility['image']); ?>');"></div>
            <div class="facility-detail-content">
              <div class="facility-detail-header-wrapper">
                <span class="facility-detail-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                <div class="facility-detail-info">
                  <span class="facility-detail-category"><?php echo htmlspecialchars($facility['category']); ?></span>
                  <h3 class="facility-detail-name"><?php echo htmlspecialchars($facility['name']); ?></h3>
                  <div class="facility-detail-divider"></div>
                  <p class="facility-detail-description">
                    <?php echo htmlspecialchars($facility['description']); ?>
                  </p>
                  <div class="facility-detail-arrow">
                    <div class="facility-detail-arrow-line"></div>
                    <div class="facility-detail-arrow-point"></div>
                    <div class="facility-detail-arrow-point-small"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php else: ?>
          <!-- Facility <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?> -->
          <div class="facility-detail-item">
            <div class="facility-detail-content">
              <div class="facility-detail-header-wrapper">
                <span class="facility-detail-number"><?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?></span>
                <div class="facility-detail-info">
                  <span class="facility-detail-category"><?php echo htmlspecialchars($facility['category']); ?></span>
                  <h3 class="facility-detail-name"><?php echo htmlspecialchars($facility['name']); ?></h3>
                  <div class="facility-detail-divider"></div>
                  <p class="facility-detail-description">
                    <?php echo htmlspecialchars($facility['description']); ?>
                  </p>
                  <div class="facility-detail-arrow">
                    <div class="facility-detail-arrow-line"></div>
                    <div class="facility-detail-arrow-point"></div>
                    <div class="facility-detail-arrow-point-small"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="facility-detail-image" style="background-image: url('images/<?php echo htmlspecialchars($facility['image']); ?>');"></div>
          </div>
          <?php endif; ?>

          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section
      style="
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5rem 0;
      "
    >
      <div style="display: flex; width: 1208px; height: 547px">
        <!-- Content Side -->
        <div
          style="
            width: 604px;
            height: 531px;
            background-color: var(--velora-cream);
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
          "
        >
          <div style="max-width: 455px">
            <div class="about-badge" style="margin-bottom: 1rem">
              <span class="about-badge-text">Why choose us</span>
            </div>

            <h2 class="about-title" style="margin-bottom: 1.5rem">
              Luxury, Redefined
            </h2>

            <div
              style="
                font-size: 1rem;
                font-weight: 400;
                color: var(--velora-dark);
                margin-bottom: 2rem;
              "
            >
              <p style="margin-bottom: 1rem">
                At Velora, hospitality is an art. From the moment you arrive,
                you're enveloped in refined comfort, curated design, and
                intuitive service.
              </p>
              <p style="margin-bottom: 1rem">
                <strong>Prime Location in Addis Ababa</strong><br />
                Steps from Bole International Airport and landmarks like Edna
                Mall, our hotel offers both tranquility and city access.
              </p>
              <p>
                <strong>Distinctive Design & Atmosphere</strong><br />
                Modern Ethiopian elegance meets global boutique style
                highlighted by immersive visuals, signature scents, and mood
                lighting throughout.
              </p>
            </div>

            <div class="why-choose-button" onclick="window.location.href='about.php'">
              <span>More About</span>
            </div>
          </div>
        </div>

        <!-- Image Side -->
        <div style="width: 604px; height: 547px; background-image: url('images/Frame 32 (1).png'); background-size: cover; background-position: center;"></div>
      </div>
    </section>

    <!-- Offers Section -->
    <section class="bg-cream section">
      <div class="container">
        <div style="text-center; margin-bottom: 4rem;">
          <div class="about-badge" style="margin-bottom: 1rem">
            <span class="about-badge-text">Offers</span>
          </div>
          <h2 class="about-title" style="max-width: 474px; margin: 0 auto">
            VELORA'S LIMITED PERIOD BEST OFFERS
          </h2>
          <div
            style="
              width: 100%;
              height: 0;
              background-color: rgba(0, 0, 0, 0.3);
              margin-top: 2rem;
            "
          ></div>
        </div>

        <!-- Offers Grid -->
        <div
          style="
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
          "
        >
          <?php foreach ($rooms as $index => $room):
              if ($index >= 4) break; // Only show first 4 rooms as offers
          ?>
          <div style="background-color: var(--velora-white)">
            <div
              style="position: relative; height: 313px; background-image: url('images/<?php echo htmlspecialchars($room['image']); ?>'); background-size: cover; background-position: center;"
            >
              <div
                style="
                  position: absolute;
                  top: 0.5rem;
                  left: 0.75rem;
                  border: 2px solid var(--velora-white);
                  padding: 0.5rem 1.5rem;
                "
              >
                <span
                  style="
                    color: var(--velora-white);
                    font-family: &quot;Cormorant Garamond&quot;, serif;
                    font-size: 1.25rem;
                    font-weight: 500;
                  "
                  >14% off</span
                >
              </div>
            </div>
            <div
              style="
                padding: 1.25rem;
                display: flex;
                align-items: center;
                gap: 0.75rem;
              "
            >
              <svg
                width="28"
                height="28"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
              >
                <path d="M2 4h20l-2 14H4L2 4z" />
                <path d="M6 8h12" />
              </svg>
              <span
                style="
                  font-size: 1.25rem;
                  font-weight: 500;
                  color: var(--velora-dark);
                "
                ><?php echo htmlspecialchars($room['name']); ?></span
              >
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section
      class="testimonials-section"
      style="
        background-image:
          linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
          url(&quot;images/Frame 32 (1).png&quot;);
      "
    >
      <div class="testimonials-overlay"></div>
      <div class="testimonials-content">
        <!-- Header -->
        <div class="testimonials-header">
          <div class="testimonials-logo-divider">
            <div class="testimonials-logo-line"></div>
            <div class="testimonials-logo"></div>
            <div class="testimonials-logo-line"></div>
          </div>
          <h2 class="testimonials-title">Customers Testimonial</h2>
          <p class="testimonials-description">
            At Velora Hotel, we believe that unforgettable stays speak for
            themselves. From weekend escapes to extended business trips, our
            guests share stories of comfort, elegance, and hospitality that go
            beyond expectations. Here's what makes their experience truly
            exceptional.
          </p>
        </div>

        <!-- Testimonial Cards -->
        <div class="testimonials-cards">
          <?php foreach ($testimonials as $testimonial): ?>
          <div class="testimonial-card">
            <div class="testimonial-card-bg"></div>
            <div class="testimonial-card-content">
              <!-- Stars -->
              <div class="testimonial-stars">
                <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                <div class="testimonial-star">★</div>
                <?php endfor; ?>
              </div>

              <p class="testimonial-text">
                "<?php echo htmlspecialchars($testimonial['message']); ?>"
              </p>

              <div class="testimonial-author">
                <div class="testimonial-avatar"></div>
                <div class="testimonial-author-name">
                  <?php echo htmlspecialchars($testimonial['guest_name']); ?>, <?php echo htmlspecialchars($testimonial['guest_location']); ?>
                </div>
              </div>
            </div>

            <div class="testimonial-quote">
              <div>"</div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <!-- Blog Section -->
    <section class="blog-section" id="blog">
      <div class="blog-container">
        <div class="blog-header">
          <h2 class="blog-title">LATEST POST FROM BLOG</h2>
          <p class="blog-description">
            Discover the soul of Velora through curated travel tips, cultural
            highlights, and behind-the-scenes moments. Our blog brings you
            closer to the people, places, and inspirations that shape every
            guest experience.
          </p>
        </div>

        <!-- Blog Grid -->
        <div class="blog-grid">
          <?php foreach ($blog_posts as $post): ?>
          <div class="blog-post">
            <div class="blog-post-image" style="background-image: url('images/<?php echo htmlspecialchars($post['image']); ?>');"></div>
            <div class="blog-post-content">
              <div class="blog-post-meta">
                <div class="blog-post-meta-divider"></div>
                <span class="blog-post-meta-text"><?php echo formatDate($post['published_at']); ?></span>
                <div class="blog-post-meta-divider"></div>
                <span class="blog-post-meta-text"><?php echo htmlspecialchars($post['category']); ?></span>
              </div>

              <h3 class="blog-post-title">
                "<?php echo htmlspecialchars($post['title']); ?>"
              </h3>

              <div class="blog-post-footer">
                <a href="/blog.php?slug=<?php echo htmlspecialchars($post['slug']); ?>" class="blog-post-link">More About</a>
                <div class="blog-post-arrow">
                  <div class="blog-post-arrow-line"></div>
                  <div class="blog-post-arrow-point"></div>
                  <div class="blog-post-arrow-point"></div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

<?php
// Include footer
include_once 'includes/footer.php';
?>
