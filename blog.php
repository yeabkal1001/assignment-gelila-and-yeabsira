<?php
/**
 * Blog Page
 * 
 * This page displays blog posts or a single blog post if a slug is provided.
 */

// Include necessary files
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

// Check if a specific blog post is requested
$slug = isset($_GET['slug']) ? sanitize($_GET['slug']) : '';
$single_post = null;

if (!empty($slug)) {
    // Get specific blog post
    $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE slug = ? AND is_published = 1");
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $single_post = $result->fetch_assoc();
        
        // Get author info
        $author_id = $single_post['author_id'];
        $author_name = 'Admin';
        
        if ($author_id) {
            $stmt = $conn->prepare("SELECT full_name FROM users WHERE id = ?");
            $stmt->bind_param('i', $author_id);
            $stmt->execute();
            $author_result = $stmt->get_result();
            
            if ($author_result->num_rows > 0) {
                $author = $author_result->fetch_assoc();
                $author_name = $author['full_name'];
            }
        }
    } else {
        // If post not found, redirect to blog index
        setFlashMessage('error', 'Blog post not found.');
        redirect('/blog.php');
    }
} else {
    // Get all blog posts
    $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE is_published = 1 ORDER BY published_at DESC");
    $stmt->execute();
    $result = $stmt->get_result();
    $blog_posts = [];
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $blog_posts[] = $row;
        }
    }
}

// Include header
$page_title = $single_post ? htmlspecialchars($single_post['title']) : 'Blog';
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
        <h1 class="hero-title"><?php echo $single_post ? htmlspecialchars($single_post['title']) : 'Our Blog'; ?></h1>
        <div class="hero-breadcrumb">
          <span class="breadcrumb-home">Home</span> / 
          <?php if ($single_post): ?>
          <a href="/blog.php">Blog</a> / <?php echo htmlspecialchars($single_post['title']); ?>
          <?php else: ?>
          Blog
          <?php endif; ?>
        </div>
      </div>
    </section>

    <?php if ($single_post): ?>
    <!-- Single Blog Post -->
    <section class="blog-post-section">
        <div class="blog-post-container">
            <div class="blog-post-header">
                <div class="blog-post-meta">
                    <span class="blog-post-date"><?php echo formatDate($single_post['published_at']); ?></span>
                    <span class="blog-post-category"><?php echo htmlspecialchars($single_post['category']); ?></span>
                    <span class="blog-post-author">By <?php echo htmlspecialchars($author_name); ?></span>
                </div>
                
                <div class="blog-post-featured-image" style="background-image: url('images/<?php echo htmlspecialchars($single_post['image']); ?>');"></div>
            </div>
            
            <div class="blog-post-content">
                <?php echo nl2br(htmlspecialchars($single_post['content'])); ?>
            </div>
            
            <div class="blog-post-footer">
                <a href="/blog.php" class="blog-post-back-button">Back to Blog</a>
            </div>
        </div>
    </section>
    <?php else: ?>
    <!-- Blog Posts Grid -->
    <section class="blog-index-section">
        <div class="blog-index-container">
            <div class="blog-index-header">
                <h2 class="blog-index-title">Latest from Our Blog</h2>
                <p class="blog-index-description">
                    Discover the soul of Velora through curated travel tips, cultural highlights, and behind-the-scenes moments. 
                    Our blog brings you closer to the people, places, and inspirations that shape every guest experience.
                </p>
            </div>
            
            <?php if (empty($blog_posts)): ?>
            <div class="blog-index-empty">
                <p>No blog posts found. Check back soon for new content!</p>
            </div>
            <?php else: ?>
            <div class="blog-index-grid">
                <?php foreach ($blog_posts as $post): ?>
                <div class="blog-index-card">
                    <div class="blog-index-card-image" style="background-image: url('images/<?php echo htmlspecialchars($post['image']); ?>');"></div>
                    <div class="blog-index-card-content">
                        <div class="blog-index-card-meta">
                            <span class="blog-index-card-date"><?php echo formatDate($post['published_at']); ?></span>
                            <span class="blog-index-card-category"><?php echo htmlspecialchars($post['category']); ?></span>
                        </div>
                        <h3 class="blog-index-card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                        <p class="blog-index-card-excerpt">
                            <?php echo substr(htmlspecialchars($post['content']), 0, 150) . '...'; ?>
                        </p>
                        <a href="/blog.php?slug=<?php echo htmlspecialchars($post['slug']); ?>" class="blog-index-card-read-more">Read More</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php endif; ?>

    <style>
        /* Single Blog Post Styles */
        .blog-post-section {
            padding: 4rem 0;
            background-color: var(--velora-cream);
        }
        
        .blog-post-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1rem;
            background-color: var(--velora-white);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .blog-post-header {
            margin-bottom: 2rem;
        }
        
        .blog-post-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding: 1.5rem 1.5rem 0;
        }
        
        .blog-post-date,
        .blog-post-category,
        .blog-post-author {
            font-size: 0.875rem;
            color: var(--velora-dark);
        }
        
        .blog-post-category {
            color: var(--velora-gold);
        }
        
        .blog-post-featured-image {
            height: 400px;
            background-size: cover;
            background-position: center;
        }
        
        .blog-post-content {
            padding: 2rem 1.5rem;
            font-size: 1rem;
            line-height: 1.7;
            color: var(--velora-dark);
        }
        
        .blog-post-content p {
            margin-bottom: 1.5rem;
        }
        
        .blog-post-footer {
            padding: 0 1.5rem 1.5rem;
            text-align: center;
        }
        
        .blog-post-back-button {
            display: inline-block;
            background-color: var(--velora-gold);
            color: var(--velora-white);
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s;
        }
        
        .blog-post-back-button:hover {
            background-color: var(--velora-dark);
        }
        
        /* Blog Index Styles */
        .blog-index-section {
            padding: 4rem 0;
            background-color: var(--velora-cream);
        }
        
        .blog-index-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .blog-index-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .blog-index-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 2.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
        }
        
        .blog-index-description {
            font-size: 1rem;
            color: var(--velora-dark);
            max-width: 700px;
            margin: 0 auto;
        }
        
        .blog-index-empty {
            text-align: center;
            padding: 3rem;
            background-color: var(--velora-white);
        }
        
        .blog-index-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 2rem;
        }
        
        .blog-index-card {
            background-color: var(--velora-white);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .blog-index-card-image {
            height: 200px;
            background-size: cover;
            background-position: center;
        }
        
        .blog-index-card-content {
            padding: 1.5rem;
        }
        
        .blog-index-card-meta {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }
        
        .blog-index-card-date,
        .blog-index-card-category {
            font-size: 0.875rem;
            color: var(--velora-dark);
        }
        
        .blog-index-card-category {
            color: var(--velora-gold);
        }
        
        .blog-index-card-title {
            font-family: "Cormorant Garamond", serif;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--velora-dark);
            margin-bottom: 1rem;
        }
        
        .blog-index-card-excerpt {
            font-size: 0.875rem;
            color: var(--velora-dark);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }
        
        .blog-index-card-read-more {
            display: inline-block;
            color: var(--velora-gold);
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s;
        }
        
        .blog-index-card-read-more:hover {
            color: var(--velora-dark);
        }
        
        @media (max-width: 768px) {
            .blog-index-grid {
                grid-template-columns: 1fr;
            }
            
            .blog-post-featured-image {
                height: 250px;
            }
        }
    </style>

<?php
// Include footer
include 'includes/footer.php';
?>