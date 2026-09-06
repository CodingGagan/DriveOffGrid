<?php
$page_title = "Reach Out | Plan Your Luxury Self-Drive Journey";
$meta_description = "Reach out to DriveOffGrid to plan your luxury self-drive journey. Explore destinations, enquire about bookings and start your curated road trip experience.";
$meta_keywords = "reach out travel enquiry, self drive tour contact, luxury journey planning, travel booking enquiry, curated trip assistance, road trip planning help, travel support services, custom travel enquiry";
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
                        <div class="form-group phone-input-group">
                            <div class="phone-input-wrapper">
                                <select id="phoneCountryCode" name="phoneCountryCode" class="country-code-select">
                                    <option value="+91" selected>+91 (India)</option>
                                    <option value="+1">+1 (USA/Canada)</option>
                                    <option value="+44">+44 (UK)</option>
                                    <option value="+33">+33 (France)</option>
                                    <option value="+49">+49 (Germany)</option>
                                    <option value="+39">+39 (Italy)</option>
                                    <option value="+34">+34 (Spain)</option>
                                    <option value="+31">+31 (Netherlands)</option>
                                    <option value="+32">+32 (Belgium)</option>
                                    <option value="+41">+41 (Switzerland)</option>
                                    <option value="+43">+43 (Austria)</option>
                                    <option value="+45">+45 (Denmark)</option>
                                    <option value="+46">+46 (Sweden)</option>
                                    <option value="+47">+47 (Norway)</option>
                                    <option value="+48">+48 (Poland)</option>
                                    <option value="+351">+351 (Portugal)</option>
                                    <option value="+353">+353 (Ireland)</option>
                                    <option value="+358">+358 (Finland)</option>
                                    <option value="+7">+7 (Russia/Kazakhstan)</option>
                                    <option value="+81">+81 (Japan)</option>
                                    <option value="+82">+82 (South Korea)</option>
                                    <option value="+86">+86 (China)</option>
                                    <option value="+852">+852 (Hong Kong)</option>
                                    <option value="+853">+853 (Macau)</option>
                                    <option value="+886">+886 (Taiwan)</option>
                                    <option value="+65">+65 (Singapore)</option>
                                    <option value="+60">+60 (Malaysia)</option>
                                    <option value="+62">+62 (Indonesia)</option>
                                    <option value="+63">+63 (Philippines)</option>
                                    <option value="+66">+66 (Thailand)</option>
                                    <option value="+84">+84 (Vietnam)</option>
                                    <option value="+61">+61 (Australia)</option>
                                    <option value="+64">+64 (New Zealand)</option>
                                    <option value="+971">+971 (UAE)</option>
                                    <option value="+974">+974 (Qatar)</option>
                                    <option value="+973">+973 (Bahrain)</option>
                                    <option value="+965">+965 (Kuwait)</option>
                                    <option value="+966">+966 (Saudi Arabia)</option>
                                    <option value="+968">+968 (Oman)</option>
                                    <option value="+961">+961 (Lebanon)</option>
                                    <option value="+962">+962 (Jordan)</option>
                                    <option value="+972">+972 (Israel)</option>
                                    <option value="+20">+20 (Egypt)</option>
                                    <option value="+27">+27 (South Africa)</option>
                                    <option value="+234">+234 (Nigeria)</option>
                                    <option value="+254">+254 (Kenya)</option>
                                    <option value="+94">+94 (Sri Lanka)</option>
                                    <option value="+880">+880 (Bangladesh)</option>
                                    <option value="+92">+92 (Pakistan)</option>
                                    <option value="+880">+880 (Bangladesh)</option>
                                    <option value="+977">+977 (Nepal)</option>
                                    <option value="+95">+95 (Myanmar)</option>
                                    <option value="+855">+855 (Cambodia)</option>
                                    <option value="+856">+856 (Laos)</option>
                                    <option value="+673">+673 (Brunei)</option>
                                    <option value="+670">+670 (East Timor)</option>
                                    <option value="+55">+55 (Brazil)</option>
                                    <option value="+52">+52 (Mexico)</option>
                                    <option value="+54">+54 (Argentina)</option>
                                    <option value="+56">+56 (Chile)</option>
                                    <option value="+57">+57 (Colombia)</option>
                                    <option value="+51">+51 (Peru)</option>
                                    <option value="+58">+58 (Venezuela)</option>
                                    <option value="+593">+593 (Ecuador)</option>
                                    <option value="+595">+595 (Paraguay)</option>
                                    <option value="+598">+598 (Uruguay)</option>
                                    <option value="+591">+591 (Bolivia)</option>
                                    <option value="+506">+506 (Costa Rica)</option>
                                    <option value="+507">+507 (Panama)</option>
                                    <option value="+502">+502 (Guatemala)</option>
                                    <option value="+504">+504 (Honduras)</option>
                                    <option value="+505">+505 (Nicaragua)</option>
                                    <option value="+503">+503 (El Salvador)</option>
                                    <option value="+501">+501 (Belize)</option>
                                    <option value="+30">+30 (Greece)</option>
                                    <option value="+90">+90 (Turkey)</option>
                                    <option value="+380">+380 (Ukraine)</option>
                                    <option value="+375">+375 (Belarus)</option>
                                    <option value="+40">+40 (Romania)</option>
                                    <option value="+36">+36 (Hungary)</option>
                                    <option value="+420">+420 (Czech Republic)</option>
                                    <option value="+421">+421 (Slovakia)</option>
                                    <option value="+385">+385 (Croatia)</option>
                                    <option value="+386">+386 (Slovenia)</option>
                                    <option value="+387">+387 (Bosnia)</option>
                                    <option value="+382">+382 (Montenegro)</option>
                                    <option value="+381">+381 (Serbia)</option>
                                    <option value="+389">+389 (North Macedonia)</option>
                                    <option value="+355">+355 (Albania)</option>
                                    <option value="+359">+359 (Bulgaria)</option>
                                    <option value="+370">+370 (Lithuania)</option>
                                    <option value="+371">+371 (Latvia)</option>
                                    <option value="+372">+372 (Estonia)</option>
                                    <option value="+354">+354 (Iceland)</option>
                                    <option value="+356">+356 (Malta)</option>
                                    <option value="+357">+357 (Cyprus)</option>
                                    <option value="+961">+961 (Lebanon)</option>
                                    <option value="+212">+212 (Morocco)</option>
                                    <option value="+213">+213 (Algeria)</option>
                                    <option value="+216">+216 (Tunisia)</option>
                                    <option value="+218">+218 (Libya)</option>
                                    <option value="+249">+249 (Sudan)</option>
                                    <option value="+251">+251 (Ethiopia)</option>
                                    <option value="+255">+255 (Tanzania)</option>
                                    <option value="+256">+256 (Uganda)</option>
                                    <option value="+257">+257 (Burundi)</option>
                                    <option value="+250">+250 (Rwanda)</option>
                                    <option value="+233">+233 (Ghana)</option>
                                    <option value="+234">+234 (Nigeria)</option>
                                    <option value="+236">+236 (Central African Republic)</option>
                                    <option value="+237">+237 (Cameroon)</option>
                                    <option value="+238">+238 (Cape Verde)</option>
                                    <option value="+239">+239 (São Tomé)</option>
                                    <option value="+240">+240 (Equatorial Guinea)</option>
                                    <option value="+241">+241 (Gabon)</option>
                                    <option value="+242">+242 (Congo)</option>
                                    <option value="+243">+243 (DR Congo)</option>
                                    <option value="+244">+244 (Angola)</option>
                                    <option value="+245">+245 (Guinea-Bissau)</option>
                                    <option value="+246">+246 (British Indian Ocean)</option>
                                    <option value="+248">+248 (Seychelles)</option>
                                    <option value="+252">+252 (Somalia)</option>
                                    <option value="+253">+253 (Djibouti)</option>
                                    <option value="+254">+254 (Kenya)</option>
                                    <option value="+260">+260 (Zambia)</option>
                                    <option value="+261">+261 (Madagascar)</option>
                                    <option value="+262">+262 (Réunion)</option>
                                    <option value="+263">+263 (Zimbabwe)</option>
                                    <option value="+264">+264 (Namibia)</option>
                                    <option value="+265">+265 (Malawi)</option>
                                    <option value="+266">+266 (Lesotho)</option>
                                    <option value="+267">+267 (Botswana)</option>
                                    <option value="+268">+268 (Swaziland)</option>
                                    <option value="+269">+269 (Comoros)</option>
                                    <option value="+290">+290 (Saint Helena)</option>
                                    <option value="+291">+291 (Eritrea)</option>
                                    <option value="+297">+297 (Aruba)</option>
                                    <option value="+298">+298 (Faroe Islands)</option>
                                    <option value="+299">+299 (Greenland)</option>
                                    <option value="+350">+350 (Gibraltar)</option>
                                    <option value="+351">+351 (Portugal)</option>
                                    <option value="+352">+352 (Luxembourg)</option>
                                    <option value="+353">+353 (Ireland)</option>
                                    <option value="+354">+354 (Iceland)</option>
                                    <option value="+356">+356 (Malta)</option>
                                    <option value="+357">+357 (Cyprus)</option>
                                    <option value="+358">+358 (Finland)</option>
                                    <option value="+359">+359 (Bulgaria)</option>
                                    <option value="+370">+370 (Lithuania)</option>
                                    <option value="+371">+371 (Latvia)</option>
                                    <option value="+372">+372 (Estonia)</option>
                                    <option value="+373">+373 (Moldova)</option>
                                    <option value="+374">+374 (Armenia)</option>
                                    <option value="+375">+375 (Belarus)</option>
                                    <option value="+376">+376 (Andorra)</option>
                                    <option value="+377">+377 (Monaco)</option>
                                    <option value="+378">+378 (San Marino)</option>
                                    <option value="+380">+380 (Ukraine)</option>
                                    <option value="+381">+381 (Serbia)</option>
                                    <option value="+382">+382 (Montenegro)</option>
                                    <option value="+383">+383 (Kosovo)</option>
                                    <option value="+385">+385 (Croatia)</option>
                                    <option value="+386">+386 (Slovenia)</option>
                                    <option value="+387">+387 (Bosnia)</option>
                                    <option value="+389">+389 (North Macedonia)</option>
                                    <option value="+420">+420 (Czech Republic)</option>
                                    <option value="+421">+421 (Slovakia)</option>
                                    <option value="+423">+423 (Liechtenstein)</option>
                                </select>
                                <input type="tel" id="phone" name="phone" required>
                            </div>
                            <label for="phone">Phone Number</label>
                            <div class="input-underline"></div>
                        </div>

                        <div class="form-group">
                            <input type="email" id="email" name="email">
                            <label for="email">Email Address (Optional)</label>
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
                            <p class="no-selection">No countries selected. Click on the below globe or choose from dropdown.</p>
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
                                    <!-- <div class="dropdown-option" data-value="ireland-scotland" data-location="[-5.5, 54.5]" data-name="Ireland & Scotland">Ireland & Scotland</div> -->
                                    <div class="dropdown-option" data-value="russia-artic" data-location="[37.6173, 55.7558]" data-name="Russia Arctic">Russia Arctic</div>
                                    <div class="dropdown-option" data-value="russia-luxe" data-location="[37.6173, 55.7558]" data-name="Russia Luxe">Russia Luxe</div>
                                    <div class="dropdown-option" data-value="mongolia" data-location="[103.8467, 46.8625]" data-name="Mongolia">Mongolia</div>
                                    <div class="dropdown-option" data-value="tibet" data-location="[88.7879, 31.6927]" data-name="Tibet">Tibet</div>
                                    <div class="dropdown-option" data-value="iceland" data-location="[-19.0208, 64.9631]" data-name="Iceland">Iceland</div>
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

                        <div class="form-row form-row-single-line">
                            <div class="form-group">
                                <input type="number" id="numberOfPeople" name="numberOfPeople" min="6" required>
                                <label for="numberOfPeople">Number of people in your group</label>
                                <!-- <span class="helper-text">(Minimum 6)</span> -->
                                
                            </div>

                            <div class="form-group month-year-picker">
                                <div class="month-year-selects">
                                    <select id="travelMonth" name="travelMonth" required>
                                        <option value="">Month</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <select id="travelYear" name="travelYear" required>
                                        <option value="">Year</option>
                                    </select>
                                </div>
                                <label for="travelMonth">Tentative Month / Year of Travel</label>
                                <input type="hidden" id="travelMonthYear" name="travelMonthYear" required>
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
            <h2>Let's get going</h2>
            <p class="success-message-text">
            A wonderful choice. We’re looking forward to connecting with you. Our team will be in touch within 24 hours to begin crafting your personalized journey.            </p>
            <div id="tripLinksContainer" class="trip-links-container" style="display: none;">
                <p class="trip-links-intro">Explore your selected dream drive:</p>
                <div id="tripLinksList" class="trip-links-list"></div>
            </div>
            <p class="success-quote">
            Some roads lead outward. </br> The best ones lead inward.
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
    
    <!-- AmCharts 5 - Globe Library (load synchronously for proper initialization) -->
    <script src="js/vendor/amcharts/index.js"></script>
    <script src="js/vendor/amcharts/map.js"></script>
    <!-- <script src="js/vendor/amcharts/worldLow.js"></script> -->
    <script src="js/vendor/amcharts/core.js"></script>
    <script src="js/vendor/amcharts/maps.js"></script>
    <script src="js/vendor/amcharts/Animated.js"></script>
    <script src="js/vendor/amcharts/worldIndiaLow.js"></script>
    <script src="js/travel-enquire-script.js?v=1.1" defer></script>
<?php include 'includes/footer.php'; ?>

