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
                            <input type="email" id="email" name="email">
                            <label for="email">Email Address (Optional)</label>
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
                                    <span class="dropdown-placeholder">Choose Your Trip</span>
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
                                    <div class="dropdown-option" data-value="russia-artic" data-location="[37.6173, 55.7558]" data-name="Russia Arctic">Russia Arctic</div>
                                    <div class="dropdown-option" data-value="russia-luxe" data-location="[37.6173, 55.7558]" data-name="Russia Luxe">Russia Luxe</div>
                                    <div class="dropdown-option" data-value="other" data-location="[0, 0]" data-name="Other">Other</div>
                                </div>
                            </div>
                            <label for="tripType">Choose Your Trip</label>
                            <div class="input-underline"></div>
                        </div>

                        <!-- Custom Countries Input - Shows when "Other" is selected -->
                        <div class="form-group custom-countries-input" id="customCountriesInput" style="display: none;">
                            <textarea id="customCountries" name="customCountries" rows="3" placeholder="Enter your desired countries (e.g., France, Italy, Spain)"></textarea>
                            <label for="customCountries">Enter Your Desired Countries</label>
                            <div class="input-underline"></div>
                            <span class="helper-text">Separate multiple countries with commas</span>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <input type="number" id="numberOfPeople" name="numberOfPeople" min="6" required>
                                <label for="numberOfPeople">Number of people in your group</label>
                                <span class="helper-text">(Minimum 6)</span>
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
                            <label for="message">Describe the drive you'd like to bring to life</label>
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
            <!-- Lock Overlay - Shows when step 1 is active -->
            <div class="map-lock-overlay" id="mapLockOverlay">
                <div class="lock-content">
                    <div class="lock-icon">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M19 11H5C3.89543 11 3 11.8954 3 13V20C3 21.1046 3.89543 22 5 22H19C20.1046 22 21 21.1046 21 20V13C21 11.8954 20.1046 11 19 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M7 11V7C7 4.23858 9.23858 2 12 2C14.7614 2 17 4.23858 17 7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Complete Step 1 to Unlock</h3>
                    <p>Fill in your details first to explore the globe</p>
                </div>
            </div>
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

