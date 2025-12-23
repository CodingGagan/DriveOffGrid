<?php
$page_title = "Contact Us - DriveOffGrid";
$additional_css = ['css/travel-enquire-styles.css'];
include 'includes/header.php';
?>
    <!-- Main Container -->
    <div class="main-container contact-page-container">
        <!-- Left Side: Form -->
        <div class="form-section">
            <div class="form-wrapper">
                <div class="form-header">
                    <div class="form-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h1>Start The Engine</h1>
                    <p>Tell us about your dream drive</p>
                </div>

                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step-item active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Your Details</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Your Dream Drive</div>
                    </div>
                </div>

                <form id="enquiryForm" class="enquiry-form">
                    <!-- Step 1: Basic Information -->
                    <div class="form-step active" id="step1">
                        <div class="form-row">
                            <div class="form-group">
                                <input type="text" id="firstName" name="firstName" required>
                                <label for="firstName">Name</label>
                                <div class="input-underline"></div>
                            </div>

                        </div>

                        <div class="form-group">
                            <input type="email" id="email" name="email" required>
                            <label for="email">Email Address</label>
                            <div class="input-underline"></div>
                        </div>

                        <div class="form-group">
                            <input type="tel" id="phone" name="phone" required>
                            <label for="phone">Phone Number</label>
                            <div class="input-underline"></div>
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="next-btn" id="nextBtn">
                                <span>Next Step</span>
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 5L19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Destination Information -->
                    <div class="form-step" id="step2">
                        <!-- Selected Countries Display -->
                        <div class="form-group" id="selectedCountriesContainer">
                            <p class="no-selection">No countries selected. Click on the globe or choose from dropdown.</p>
                        </div>

                        <div class="form-group custom-dropdown-wrapper">
                            <input type="hidden" id="tripType" name="tripType">
                            <div class="custom-dropdown" id="customDropdown">
                                <div class="custom-dropdown-selected">
                                    <span class="dropdown-placeholder">Choose Your Trip (Optional)</span>
                                    <span class="dropdown-value"></span>
                                </div>
                                <div class="custom-dropdown-arrow">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="custom-dropdown-menu">
                                    <div class="dropdown-option" data-value="poland" data-location="[21.0122, 52.2297]" data-name="Poland">Poland</div>
                                    <div class="dropdown-option" data-value="ireland" data-location="[-8.2439, 53.4129]" data-name="Ireland">Ireland</div>
                                    <div class="dropdown-option" data-value="norway" data-location="[10.7522, 59.9139]" data-name="Norway">Norway</div>
                                    <div class="dropdown-option" data-value="oman" data-location="[58.4059, 23.5859]" data-name="Oman">Oman</div>
                                    <div class="dropdown-option" data-value="scotland" data-location="[-3.1883, 55.9533]" data-name="Scotland">Scotland</div>
                                    <div class="dropdown-option" data-value="srilanka" data-location="[80.7718, 7.8731]" data-name="Sri Lanka">Sri Lanka</div>
                                    <div class="dropdown-option" data-value="uae-oman" data-location="[54.3773, 24.4539]" data-name="UAE & Oman">UAE & Oman</div>
                                    <div class="dropdown-option" data-value="ireland-scotland" data-location="[-4.2766, 54.7024]" data-name="Ireland & Scotland">Ireland & Scotland</div>
                                </div>
                            </div>
                            <label for="tripType">Choose Your Trip (Optional)</label>
                            <div class="input-underline"></div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <input type="number" id="numberOfPeople" name="numberOfPeople" min="6" required>
                                <label for="numberOfPeople">Number of people in your group (Minimum 6)</label>
                                <div class="input-underline"></div>
                            </div>

                            <div class="form-group">
                                <input type="month" id="travelMonth" name="travelMonth" required>
                                <label for="travelMonth">Tentative Month / Year of Travel</label>
                                <div class="input-underline"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea id="message" name="message" rows="4" required></textarea>
                            <label for="message">Tell us more about how you’d like the drive</label>
                            <div class="input-underline"></div>
                        </div>

                        <div class="form-navigation">
                            <button type="button" class="prev-btn" id="prevBtn">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19 12H5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12 19L5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Previous</span>
                            </button>
                            <button type="submit" class="submit-btn">
                                <span class="submit-text">Submit</span>
                                <span class="submit-icon">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 2L11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: Globe Map -->
        <div class="map-section">
            <div class="map-title">
                <h2>Explore Your Dream Drive</h2>
                <p>Click on countries or choose from dropdown to select your dream drive</p>
            </div>
            <div class="map-overlay"></div>
            <div id="chartdiv" class="globe-map"></div>
        </div>
    </div>

    <!-- Success Message -->
    <div class="success-overlay" id="successOverlay">
        <div class="success-content">
            <div class="success-icon-wrapper">
                <div class="success-checkmark">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
            <h2>Thank You for Your Submission</h2>
            <p class="success-message-text">
                Thank you for reaching out! Our travel experts will craft a personalized itinerary 
                just for you. We'll contact you within 24 hours to start planning your unforgettable adventure.
            </p>
            <div id="tripLinksContainer" class="trip-links-container" style="display: none;">
                <p class="trip-links-intro">Explore your selected dream drive:</p>
                <div id="tripLinksList" class="trip-links-list"></div>
            </div>
            <p class="success-quote">
                "Travel is the only thing you buy that makes you richer"
            </p>
            <button class="close-success-btn" id="closeSuccess">Continue Exploring</button>
        </div>
    </div>

    <!-- Contact Info Section -->
    <div class="contact-info">
        <div class="info-card">
            <div class="info-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21 10C21 17 12 23 12 23C12 23 3 17 3 10C3 7.61305 3.94821 5.32387 5.63604 3.63604C7.32387 1.94821 9.61305 1 12 1C14.3869 1 16.6761 1.94821 18.364 3.63604C20.0518 5.32387 21 7.61305 21 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Visit Us</h3>
            <p>C-20, G Block, Near MCA<br>Bandra Kurla Complex, Bandra (East)<br>Mumbai - 400051</p>
        </div>

        <div class="info-card">
            <div class="info-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 16.92V19.92C22.0011 20.1985 21.9441 20.4742 21.8325 20.7292C21.7209 20.9841 21.5573 21.2126 21.3518 21.3999C21.1463 21.5872 20.9033 21.7293 20.6391 21.8167C20.3749 21.9041 20.0955 21.9351 19.82 21.9077C16.7428 21.4986 13.787 20.4471 11.19 18.8377C8.77382 17.4017 6.72533 15.3522 5.29001 12.935C3.67995 10.3373 2.62824 7.38031 2.22 4.302C2.19262 4.02659 2.22364 3.74726 2.31101 3.48319C2.39838 3.21912 2.54038 2.97626 2.72764 2.77089C2.9149 2.56552 3.14337 2.40208 3.39831 2.29064C3.65325 2.1792 3.92892 2.12228 4.20732 2.12345H7.20732C7.68197 2.12054 8.13755 2.30657 8.47732 2.64345C8.81709 2.98033 9.01526 3.44312 9.02732 3.92745C9.17244 5.05919 9.45672 6.16981 9.87232 7.23245C10.0079 7.60364 10.0761 8.00018 10.0723 8.39945C10.0685 8.79872 9.9929 9.19359 9.84932 9.56245L8.38932 12.9525C10.1019 15.6252 12.3748 17.8981 15.0473 19.6105L18.4373 18.1505C18.8062 18.0069 19.201 17.9313 19.6003 17.9275C19.9996 17.9237 20.3961 17.9919 20.7673 18.1275C21.8299 18.5431 22.9405 18.8274 24.0723 18.9725C24.5582 18.9845 25.0224 19.1832 25.3603 19.5235C25.6982 19.8638 25.8842 20.3208 25.8803 20.7975L22.8803 20.7975" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Call Us</h3>
            <p><a href="tel:+919323167788">+91-9323167788</a></p>
        </div>

        <div class="info-card">
            <div class="info-icon">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 4H20C21.1 4 22 4.9 22 6V18C22 19.1 21.1 20 20 20H4C2.9 20 2 19.1 2 18V6C2 4.9 2.9 4 4 4Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M22 6L12 13L2 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h3>Email Us</h3>
            <p><a href="mailto:hello@driveoffgrid.com">hello@driveoffgrid.com</a></p>
        </div>
    </div>

    <!-- Pass base path to JavaScript -->
    <script>
        // Make base path available to JavaScript
        window.BASE_PATH = '<?php echo addslashes($BASE_PATH); ?>';
        
        // Debug: Log BASE_PATH to console (remove in production)
        console.log('BASE_PATH:', window.BASE_PATH);
        
        // Helper function to build URLs (matches PHP url_path function)
        window.urlPath = function(path) {
            const base = window.BASE_PATH || '';
            if (path === '') {
                return (base === '') ? '/' : (base + '/');
            }
            if (path[0] === '#' || path[0] === '?') {
                return ((base === '') ? '/' : (base + '/')) + path;
            }
            // Remove leading slash from path if present, then add base + /
            const cleanPath = path.replace(/^\//, '');
            return base + '/' + cleanPath;
        };
    </script>
    
    <!-- AmCharts 5 - Globe Library -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/map.js"></script>
    <!-- <script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script> -->
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/maps.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://www.amcharts.com/lib/4/geodata/worldIndiaLow.js"></script>
    <script src="js/travel-enquire-script.js"></script>
<?php include 'includes/footer.php'; ?>

