// script.js
document.addEventListener('DOMContentLoaded', function () {
    // Page loader
    window.addEventListener('load', function() {
        const pageLoader = document.querySelector('.page-loader');
        if (pageLoader) {
            setTimeout(() => {
                pageLoader.classList.add('hidden');
            }, 500);
        }
    });

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Navbar scroll effect
    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.style.padding = '10px 0';
            navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.98)';
        } else {
            navbar.style.padding = '15px 0';
            navbar.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Booking form date validation
    const checkInDate = document.getElementById('check_in_date');
    const checkOutDate = document.getElementById('check_out_date');

    if (checkInDate && checkOutDate) {
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        checkInDate.min = today;
        
        checkInDate.addEventListener('change', function () {
            const checkIn = new Date(this.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            if (checkIn < today) {
                this.value = '';
                alert('Check-in date cannot be in the past');
                return;
            }

            // Set minimum checkout date
            const nextDay = new Date(checkIn);
            nextDay.setDate(nextDay.getDate() + 1);
            checkOutDate.min = nextDay.toISOString().split('T')[0];
        });

        checkOutDate.addEventListener('change', function () {
            const checkIn = new Date(checkInDate.value);
            const checkOut = new Date(this.value);

            if (checkOut <= checkIn) {
                this.value = '';
                alert('Check-out date must be after check-in date');
            }
        });
    }

    // Gallery filter functionality
    const filterBtns = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');

    if (filterBtns.length > 0 && galleryItems.length > 0) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 100);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
    }

    // Room availability check
    const checkAvailabilityBtn = document.getElementById('check-availability');

    if (checkAvailabilityBtn) {
        checkAvailabilityBtn.addEventListener('click', function () {
            const propertyId = document.getElementById('property_id')?.value;
            const roomTypeId = document.getElementById('room_type_id')?.value;
            const checkInDate = document.getElementById('check_in_date')?.value;
            const checkOutDate = document.getElementById('check_out_date')?.value;

            if (!propertyId || !roomTypeId || !checkInDate || !checkOutDate) {
                alert('Please fill in all required fields');
                return;
            }

            // Show loading state
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking...';
            this.disabled = true;

            // Simulate API call
            setTimeout(() => {
                // Here you would make an actual API call to your Laravel backend
                const availableRooms = Math.floor(Math.random() * 10) + 1;

                if (availableRooms > 0) {
                    alert(`${availableRooms} rooms available for your selected dates!`);
                    
                    // Show availability result
                    const resultDiv = document.getElementById('availability-result');
                    const roomListDiv = document.getElementById('room-list');
                    
                    if (resultDiv && roomListDiv) {
                        roomListDiv.innerHTML = `
                            <div class="alert alert-success">
                                <strong>Great news!</strong> We found ${availableRooms} rooms available for your selected dates.
                            </div>
                        `;
                        resultDiv.style.display = 'block';
                    }
                } else {
                    alert('No rooms available for your selected dates. Please try different dates.');
                    
                    // Show no availability result
                    const resultDiv = document.getElementById('availability-result');
                    const roomListDiv = document.getElementById('room-list');
                    
                    if (resultDiv && roomListDiv) {
                        roomListDiv.innerHTML = `
                            <div class="alert alert-warning">
                                <strong>Sorry!</strong> No rooms available for your selected dates. Please try different dates.
                            </div>
                        `;
                        resultDiv.style.display = 'block';
                    }
                }

                // Reset button
                this.innerHTML = 'Check Availability';
                this.disabled = false;
            }, 1500);
        });
    }

    // Contact form submission
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            e.preventDefault();

            // Get form data
            const firstName = document.getElementById('first_name')?.value;
            const lastName = document.getElementById('last_name')?.value;
            const email = document.getElementById('email')?.value;
            const subject = document.getElementById('subject')?.value;
            const message = document.getElementById('message')?.value;

            if (!firstName || !lastName || !email || !subject || !message) {
                alert('Please fill in all required fields');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            submitBtn.disabled = true;

            // Simulate form submission
            setTimeout(() => {
                alert('Thank you for your message! We will get back to you soon.');
                this.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 1500);
        });
    }

    // Login form validation
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const email = document.getElementById('email')?.value;
            const password = document.getElementById('password')?.value;

            if (!email || !password) {
                alert('Please enter both email and password');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
            submitBtn.disabled = true;

            // Simulate login
            setTimeout(() => {
                // Here you would make an actual API call to your Laravel backend
                alert('Login successful! Redirecting to dashboard...');
                window.location.href = 'dashboard.html';
            }, 1500);
        });
    }

    // Registration form validation
    const registerForm = document.getElementById('registerForm');

    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const name = document.getElementById('name')?.value;
            const email = document.getElementById('email')?.value;
            const password = document.getElementById('password')?.value;
            const confirmPassword = document.getElementById('confirm_password')?.value;

            if (!name || !email || !password || !confirmPassword) {
                alert('Please fill in all fields');
                return;
            }

            if (password !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            if (password.length < 6) {
                alert('Password must be at least 6 characters long');
                return;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating Account...';
            submitBtn.disabled = true;

            // Simulate registration
            setTimeout(() => {
                // Here you would make an actual API call to your Laravel backend
                alert('Registration successful! Please check your email to verify your account.');
                window.location.href = 'login.html';
            }, 1500);
        });
    }

    // Password visibility toggle
    const passwordToggles = document.querySelectorAll('.password-toggle');

    passwordToggles.forEach(toggle => {
        toggle.addEventListener('click', function () {
            const passwordField = this.previousElementSibling;
            const icon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Dashboard booking cancellation
    const cancelButtons = document.querySelectorAll('.cancel-booking');

    cancelButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (confirm('Are you sure you want to cancel this booking?')) {
                const bookingItem = this.closest('.booking-item');
                const bookingStatus = bookingItem.querySelector('.booking-status');

                // Show loading state
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Cancelling...';
                this.disabled = true;

                // Simulate cancellation
                setTimeout(() => {
                    bookingStatus.textContent = 'Cancelled';
                    bookingStatus.className = 'booking-status status-cancelled';
                    this.remove();

                    alert('Booking cancelled successfully');
                }, 1500);
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // Initialize datepickers if available
    if (typeof flatpickr !== 'undefined') {
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            minDate: "today"
        });
    }

    // Add animation on scroll
    const animateOnScroll = function () {
        const elements = document.querySelectorAll('.feature-card, .room-card, .testimonial-card');

        elements.forEach(element => {
            const elementPosition = element.getBoundingClientRect().top;
            const screenPosition = window.innerHeight / 1.3;

            if (elementPosition < screenPosition) {
                element.style.opacity = '1';
                element.style.transform = 'translateY(0)';
            }
        });
    };

    // Set initial state and add scroll listener
    const animatedElements = document.querySelectorAll('.feature-card, .room-card, .testimonial-card');
    animatedElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'all 0.6s ease';
    });

    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Run once on load

    // Performance optimizations
    // Lazy load images
    const lazyImages = document.querySelectorAll('img[data-src]');
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                imageObserver.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => {
        imageObserver.observe(img);
    });
    
    // Preload critical resources
    function preloadCriticalResources() {
        const criticalResources = [
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'
        ];
        
        criticalResources.forEach(url => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = url;
            link.as = url.endsWith('.css') ? 'style' : 'script';
            document.head.appendChild(link);
        });
    }
    
    preloadCriticalResources();
    
    // Optimize form interactions
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                
                // Re-enable after 5 seconds in case of network issues
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Submit';
                }, 5000);
            }
        });
    });

    // Gallery image loading fix
    const galleryImages = document.querySelectorAll('.gallery-item img');
    
    galleryImages.forEach(img => {
        // Add error handling
        img.addEventListener('error', function() {
            // Set a placeholder image if the original fails to load
            this.src = 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3';
            this.alt = 'Image not available';
        });
        
        // Add loading state
        img.classList.add('lazy-load');
        
        // Load the image
        const tempImg = new Image();
        tempImg.onload = function() {
            img.src = img.dataset.src || img.src;
            img.classList.add('loaded');
        };
        tempImg.onerror = function() {
            // Handle error
            img.src = 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3';
            img.alt = 'Image not available';
            img.classList.add('loaded');
        };
        tempImg.src = img.dataset.src || img.src;
    });

    // Prefetch pages for faster navigation
    function prefetchPages() {
        const pages = ['index.html', 'rooms.html', 'services.html', 'about.html', 'gallery.html', 'booking.html', 'contact.html', 'login.html', 'register.html'];
        
        pages.forEach(page => {
            const link = document.createElement('link');
            link.rel = 'prefetch';
            link.href = page;
            document.head.appendChild(link);
        });
    }
    
    // Only prefetch on good connections
    if ('connection' in navigator) {
        if (navigator.connection.effectiveType === '4g' && !navigator.connection.saveData) {
            prefetchPages();
        }
    }

    // Payment form validation
    const paymentForm = document.getElementById('paymentForm');

    if (paymentForm) {
        paymentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const cardNumber = document.getElementById('card-number').value;
            const expiry = document.getElementById('expiry').value;
            const cvv = document.getElementById('cvv').value;
            const cardName = document.getElementById('card-name').value;
            
            if (!cardNumber || !expiry || !cvv || !cardName) {
                alert('Please fill in all card details');
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitBtn.disabled = true;
            
            // Simulate payment processing
            setTimeout(() => {
                alert('Payment successful! Redirecting to confirmation...');
                window.location.href = 'booking-confirmation.html';
            }, 2000);
        });
    }

    // Card number formatting
    const cardNumberInput = document.getElementById('card-number');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            let value = this.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            this.value = formattedValue;
        });
    }

    // Expiry date formatting
    const expiryInput = document.getElementById('expiry');
    if (expiryInput) {
        expiryInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            this.value = value;
        });
    }

    // FAQ accordion functionality
    const faqItems = document.querySelectorAll('.accordion-item');
    faqItems.forEach(item => {
        const button = item.querySelector('.accordion-button');
        button.addEventListener('click', function() {
            const collapse = item.querySelector('.accordion-collapse');
            const isExpanded = this.classList.contains('collapsed');
            
            if (isExpanded) {
                collapse.classList.remove('show');
                this.classList.remove('collapsed');
            } else {
                collapse.classList.add('show');
                this.classList.add('collapsed');
            }
        });
    });

    // Loyalty program tier selection
    const tierCards = document.querySelectorAll('.tier-card');
    tierCards.forEach(card => {
        card.addEventListener('click', function() {
            tierCards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');
        });
    });

    // Restaurant menu filtering
    const menuCategories = document.querySelectorAll('.menu-category');
    if (menuCategories.length > 0) {
        const filterButtons = document.querySelectorAll('.menu-filter button');
        const menuItems = document.querySelectorAll('.menu-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const category = this.getAttribute('data-category');
                
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Filter menu items
                menuItems.forEach(item => {
                    if (category === 'all' || item.getAttribute('data-category') === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    }

    // Spa treatment booking
    const bookTreatmentButtons = document.querySelectorAll('.spa-treatment .btn-custom');
    bookTreatmentButtons.forEach(button => {
        button.addEventListener('click', function() {
            const treatmentName = this.closest('.spa-treatment').querySelector('h3').textContent;
            alert(`Booking ${treatmentName}. Redirecting to booking form...`);
            window.location.href = 'booking.html';
        });
    });

    // Package booking
    const bookPackageButtons = document.querySelectorAll('.package-card .btn-custom');
    bookPackageButtons.forEach(button => {
        button.addEventListener('click', function() {
            const packageName = this.closest('.package-card').querySelector('h3').textContent;
            alert(`Booking ${packageName}. Redirecting to booking form...`);
            window.location.href = 'booking.html';
        });
    });

    // Event inquiry
    const eventInquiryButtons = document.querySelectorAll('.event-venue .btn-custom');
    eventInquiryButtons.forEach(button => {
        button.addEventListener('click', function() {
            const venueName = this.closest('.event-venue').querySelector('h3').textContent;
            alert(`Inquiring about ${venueName}. Redirecting to contact form...`);
            window.location.href = 'contact.html';
        });
    });

    // Loyalty program join
    const joinLoyaltyButton = document.querySelector('.loyalty-section .btn-custom');
    if (joinLoyaltyButton) {
        joinLoyaltyButton.addEventListener('click', function() {
            alert('Redirecting to registration form...');
            window.location.href = 'register.html';
        });
    }

    // Restaurant reservation
    const restaurantReservationButton = document.querySelector('.restaurant-info .btn-custom');
    if (restaurantReservationButton) {
        restaurantReservationButton.addEventListener('click', function() {
            alert('Redirecting to booking form...');
            window.location.href = 'booking.html';
        });
    }

    // Sitemap search functionality
    const sitemapSearch = document.querySelector('.search-box input');
    if (sitemapSearch) {
        sitemapSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const sitemapLinks = document.querySelectorAll('.sitemap-category a');
            
            sitemapLinks.forEach(link => {
                const linkText = link.textContent.toLowerCase();
                if (linkText.includes(searchTerm)) {
                    link.style.display = 'block';
                } else {
                    link.style.display = 'none';
                }
            });
        });
    }

    // 404 page search functionality
    const errorSearch = document.querySelector('.error-404 .search-box input');
    if (errorSearch) {
        errorSearch.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                const searchTerm = this.value;
                alert(`Searching for: ${searchTerm}`);
                // In a real application, this would perform an actual search
            }
        });
    }

    // Dashboard activity feed updates
    function updateActivityFeed() {
        const activities = [
            { icon: 'fa-calendar-check', text: 'New booking confirmed', time: 'Just now' },
            { icon: 'fa-star', text: 'Earned 50 loyalty points', time: '2 hours ago' },
            { icon: 'fa-user-edit', text: 'Profile updated', time: '1 day ago' }
        ];
        
        const activityFeed = document.querySelector('.dashboard-section .activity-item').parentElement;
        if (activityFeed) {
            activities.forEach(activity => {
                const activityItem = document.createElement('div');
                activityItem.className = 'activity-item';
                activityItem.innerHTML = `
                    <div class="activity-icon">
                        <i class="fas ${activity.icon}"></i>
                    </div>
                    <div class="activity-content">
                        <p>${activity.text}</p>
                        <small>${activity.time}</small>
                    </div>
                `;
                activityFeed.insertBefore(activityItem, activityFeed.firstChild);
            });
        }
    }

    // Update activity feed every 30 seconds
    setInterval(updateActivityFeed, 30000);

    // Room detail page booking form
    const roomDetailBookingForm = document.getElementById('bookingForm');
    if (roomDetailBookingForm) {
        roomDetailBookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const checkIn = document.getElementById('check_in').value;
            const checkOut = document.getElementById('check_out').value;
            const guests = document.getElementById('guests').value;
            
            if (!checkIn || !checkOut || !guests) {
                alert('Please fill in all required fields');
                return;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Booking...';
            submitBtn.disabled = true;
            
            // Simulate booking
            setTimeout(() => {
                alert('Room booked successfully! Redirecting to payment...');
                window.location.href = 'payment.html';
            }, 1500);
        });
    }

    // Similar rooms navigation
    const similarRoomLinks = document.querySelectorAll('.similar-rooms .room-card a');
    similarRoomLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const roomName = this.closest('.room-card').querySelector('h4').textContent;
            alert(`Viewing details for ${roomName}`);
            // In a real application, this would navigate to the specific room detail page
        });
    });

    // Initialize tooltips for room amenities
    const amenityIcons = document.querySelectorAll('.amenities-list i');
    amenityIcons.forEach(icon => {
        new bootstrap.Tooltip(icon, {
            title: icon.parentElement.textContent.trim(),
            placement: 'top'
        });
    });
});