// Velora Hotel JavaScript Functionality

// Booking form functionality
function handleBooking(event) {
  // Form is now handled by the server-side PHP
  // This function is kept for any client-side validation if needed
  if (!validateForm(event.target)) {
    event.preventDefault();
    return false;
  }
  return true;
}

// Contact form functionality
function handleContactForm(event) {
  // Form is now handled by the server-side PHP
  // This function is kept for any client-side validation if needed
  if (!validateForm(event.target)) {
    event.preventDefault();
    return false;
  }
  return true;
}

// Smooth scrolling for navigation links
document.addEventListener("DOMContentLoaded", function () {
  // Smooth scroll for anchor links
  const links = document.querySelectorAll('a[href^="#"]');

  links.forEach((link) => {
    link.addEventListener("click", function (e) {
      e.preventDefault();

      const targetId = this.getAttribute("href");
      const targetSection = document.querySelector(targetId);

      if (targetSection) {
        targetSection.scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      }
    });
  });

  // Mobile menu toggle (if needed in the future)
  const mobileMenuButton = document.getElementById("mobile-menu-button");
  const mobileMenu = document.getElementById("mobile-menu");

  if (mobileMenuButton && mobileMenu) {
    mobileMenuButton.addEventListener("click", function () {
      mobileMenu.classList.toggle("hidden");
    });
  }

  // Date picker functionality for booking form
  setupDatePickers();

  // Newsletter subscription
  setupNewsletterSubscription();

  // Scroll animations
  setupScrollAnimations();
});

// Date picker setup
function setupDatePickers() {
  const checkinElement = document.getElementById("checkin-date");
  const checkoutElement = document.getElementById("checkout-date");

  if (checkinElement) {
    checkinElement.addEventListener("click", function () {
      // Here you would integrate with a date picker library
      const today = new Date();
      const dateString = today.toLocaleDateString();
      this.textContent = dateString;
    });
  }

  if (checkoutElement) {
    checkoutElement.addEventListener("click", function () {
      // Here you would integrate with a date picker library
      const tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      const dateString = tomorrow.toLocaleDateString();
      this.textContent = dateString;
    });
  }
}

// Newsletter subscription
function setupNewsletterSubscription() {
  const newsletterForm = document.querySelector(".footer-newsletter-form");
  
  if (newsletterForm) {
    newsletterForm.addEventListener("submit", function(event) {
      const emailInput = this.querySelector(".footer-newsletter-input");
      
      if (!emailInput.value.trim()) {
        event.preventDefault();
        emailInput.style.borderColor = "#ff0000";
        return false;
      }
      
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(emailInput.value)) {
        event.preventDefault();
        emailInput.style.borderColor = "#ff0000";
        return false;
      }
      
      // Form will be submitted to the server-side PHP handler
      return true;
    });
  }
}

// Scroll animations
function setupScrollAnimations() {
  const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px",
  };

  const observer = new IntersectionObserver(function (entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.style.opacity = "1";
        entry.target.style.transform = "translateY(0)";
      }
    });
  }, observerOptions);

  // Observe elements that should animate on scroll
  const animateElements = document.querySelectorAll(
    ".facility-card, .team-member, .blog-post",
  );

  animateElements.forEach((element) => {
    element.style.opacity = "0";
    element.style.transform = "translateY(20px)";
    element.style.transition = "opacity 0.6s ease, transform 0.6s ease";
    observer.observe(element);
  });
}

// Room and guest counter functionality
function updateRoomsCount(change) {
  const roomsElement = document.getElementById("rooms-count");
  if (roomsElement) {
    let current = parseInt(roomsElement.textContent) || 1;
    current = Math.max(1, current + change);
    roomsElement.textContent = current + " Room" + (current > 1 ? "s" : "");
  }
}

function updateGuestsCount(adults, children) {
  const guestsElement = document.getElementById("guests-count");
  if (guestsElement) {
    const adultsText = adults + " Adult" + (adults > 1 ? "s" : "");
    const childrenText = children + " Child" + (children > 1 ? "ren" : "");
    guestsElement.textContent = adultsText + ", " + childrenText;
  }
}

// Image lazy loading
function setupLazyLoading() {
  const images = document.querySelectorAll("img[data-src]");

  const imageObserver = new IntersectionObserver(function (entries) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        const img = entry.target;
        img.src = img.dataset.src;
        img.classList.remove("lazy");
        imageObserver.unobserve(img);
      }
    });
  });

  images.forEach((img) => imageObserver.observe(img));
}

// Form validation
function validateForm(form) {
  const inputs = form.querySelectorAll("input[required], textarea[required]");
  let isValid = true;

  inputs.forEach((input) => {
    if (!input.value.trim()) {
      input.style.borderColor = "#ff0000";
      isValid = false;
    } else {
      input.style.borderColor = "";
    }

    if (input.type === "email" && input.value) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(input.value)) {
        input.style.borderColor = "#ff0000";
        isValid = false;
      }
    }
  });

  return isValid;
}

// Testimonial carousel (if needed)
function setupTestimonialCarousel() {
  const testimonials = document.querySelectorAll(".testimonial-card");
  let currentTestimonial = 0;

  function showTestimonial(index) {
    testimonials.forEach((testimonial, i) => {
      testimonial.style.display = i === index ? "block" : "none";
    });
  }

  function nextTestimonial() {
    currentTestimonial = (currentTestimonial + 1) % testimonials.length;
    showTestimonial(currentTestimonial);
  }

  // Auto-rotate testimonials every 5 seconds
  if (testimonials.length > 1) {
    setInterval(nextTestimonial, 5000);
  }
}

// Search functionality (if needed)
function setupSearch() {
  const searchInput = document.getElementById("search-input");
  const searchButton = document.getElementById("search-button");

  if (searchInput && searchButton) {
    searchButton.addEventListener("click", function () {
      const query = searchInput.value.trim();
      if (query) {
        // Implement search functionality
        alert("Search functionality for: " + query);
      }
    });

    searchInput.addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        searchButton.click();
      }
    });
  }
}

// Utility function to debounce events
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Window resize handler
window.addEventListener(
  "resize",
  debounce(function () {
    // Handle responsive adjustments if needed
    const isMobile = window.innerWidth < 768;

    if (isMobile) {
      // Mobile-specific adjustments
      document.body.classList.add("mobile");
    } else {
      document.body.classList.remove("mobile");
    }
  }, 250),
);

// Initialize everything when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  setupLazyLoading();
  setupTestimonialCarousel();
  setupSearch();
});

// Export functions for global use
window.handleBooking = handleBooking;
window.handleContactForm = handleContactForm;
window.updateRoomsCount = updateRoomsCount;
window.updateGuestsCount = updateGuestsCount;
