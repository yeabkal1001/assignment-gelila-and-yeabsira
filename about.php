<?php
/**
 * About Page
 *
 * This page displays information about the hotel.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Get testimonials from database
$testimonials = getTestimonials(2);

// Get blog posts from database
$blog_posts = getBlogPosts(3);

// Include header
$page_title = 'About Us';
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
        <h1 class="hero-title">About Us</h1>
        <div class="hero-breadcrumb">
          <span class="breadcrumb-home">Home</span> / About US
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section class="about-section">
      <div class="about-container">
        <!-- Image Side -->
        <div class="about-image">
          <div class="about-image-bg"></div>
          <div class="about-image-main"></div>
        </div>

        <!-- Content Side -->
        <div class="about-content">
          <div class="about-badge">
            <span class="about-badge-text">About</span>
          </div>

          <h2 class="about-title">Luxury, Redefined</h2>

          <div class="about-text">
            <p>
              At Velora, hospitality is an art. From the moment you arrive,
              you're enveloped in refined comfort, curated design, and intuitive
              service.
            </p>
            <p>
              <strong>Prime Location in Addis Ababa</strong><br />
              Steps from Bole International Airport and landmarks like Edna
              Mall, our hotel offers both tranquility and city access.
            </p>
            <p>
              <strong>Distinctive Design & Atmosphere</strong><br />
              Modern Ethiopian elegance meets global boutique style highlighted
              by immersive visuals, signature scents, and mood lighting
              throughout.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-section">
      <div class="why-choose-container">
        <!-- Image Side -->
        <div class="why-choose-image"></div>

        <!-- Content Side -->
        <div class="why-choose-content">
          <div class="why-choose-content-inner">
            <div class="about-badge">
              <span class="about-badge-text">Why choose us</span>
            </div>

            <h2 class="about-title" style="color: var(--velora-dark)">
              Luxury, Redefined
            </h2>

            <div class="about-text" style="margin-bottom: 2rem">
              <p>
                At Velora, hospitality is an art. From the moment you arrive,
                you're enveloped in refined comfort, curated design, and
                intuitive service.
              </p>
              <p>
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

            <a href="#" class="why-choose-button">More About</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Meet The Expert Members Section -->
    <section class="team-section">
      <div class="team-container">
        <!-- Header -->
        <div class="team-header">
          <div class="team-logo-divider">
            <div class="team-logo-line"></div>
            <div class="team-logo"></div>
            <div class="team-logo-line"></div>
          </div>
          <h2 class="team-title">MEET THE EXPERT MEMBERS</h2>
          <p class="team-description">
            At Velora Hotel, we believe that unforgettable stays speak for
            themselves. From weekend escapes to extended business trips, our
            guests share stories of comfort, elegance, and hospitality that go
            beyond expectations. Here's what makes their experience truly
            exceptional.
          </p>
        </div>

        <!-- Team Members Grid -->
        <div class="team-grid">
          <div class="team-member">
            <div class="team-member-image"></div>
            <h3 class="team-member-name">Yeabsira Kayel</h3>
            <p class="team-member-role">General Manager</p>
          </div>
          <div class="team-member">
            <div class="team-member-image"></div>
            <h3 class="team-member-name">Yeabsira Kayel</h3>
            <p class="team-member-role">General Manager</p>
          </div>
          <div class="team-member">
            <div class="team-member-image"></div>
            <h3 class="team-member-name">Yeabsira Kayel</h3>
            <p class="team-member-role">General Manager</p>
          </div>
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
    <section class="blog-section">
      <div class="blog-container">
        <!-- Header with Logo -->
        <div class="blog-header">
          <div class="blog-logo"></div>
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
