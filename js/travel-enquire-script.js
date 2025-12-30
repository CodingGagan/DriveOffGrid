// Mapbox and Form Handling
document.addEventListener('DOMContentLoaded', function() {
    const enquiryForm = document.getElementById('enquiryForm');
    const successOverlay = document.getElementById('successOverlay');
    const closeSuccess = document.getElementById('closeSuccess');
    
    // Set minimum date for travel month input (next month)
    const travelMonthInput = document.getElementById('travelMonth');
    if (travelMonthInput) {
        const today = new Date();
        const nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, 1);
        const year = nextMonth.getFullYear();
        const month = String(nextMonth.getMonth() + 1).padStart(2, '0');
        const minDate = `${year}-${month}`;
        travelMonthInput.setAttribute('min', minDate);
    }
    
    // Clear custom countries textbox on page load/refresh
    const customCountriesFieldInit = document.getElementById('customCountries');
    const customCountriesInputInit = document.getElementById('customCountriesInput');
    if (customCountriesFieldInit) {
        customCountriesFieldInit.value = '';
        customCountriesFieldInit.classList.remove('has-value');
    }
    if (customCountriesInputInit) {
        customCountriesInputInit.style.display = 'none';
    }
    
    // Generate unique form session ID for tracking this form submission
    function generateFormSessionId() {
        return 'form_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }
    let formSessionId = generateFormSessionId();
    
    // API endpoint URL - works on both localhost and production
    function getApiUrl() {
        // Get the path using urlPath function or manual construction
        let path;
        if (typeof window.urlPath === 'function') {
            path = window.urlPath('api/save_enquiry.php');
        } else {
            // Fallback: construct path manually
            const base = window.BASE_PATH || '';
            if (base === '') {
                path = '/api/save_enquiry.php';
            } else {
                // Ensure base doesn't have trailing slash and path doesn't have leading slash
                const cleanBase = base.replace(/\/$/, '');
                const cleanPath = 'api/save_enquiry.php';
                path = cleanBase + '/' + cleanPath;
            }
        }
        
        // Clean up path - remove any filesystem path artifacts
        path = path.replace(/^\/opt\/lampp\/htdocs/, '');
        path = path.replace(/^[A-Z]:\\[^\\]+\\htdocs/i, '');
        
        // Ensure it starts with / for absolute path
        if (!path.startsWith('/')) {
            path = '/' + path;
        }
        
        // Ensure .php extension is present
        if (!path.endsWith('.php')) {
            path = path.replace(/\/api\/save_enquiry$/, '/api/save_enquiry.php');
        }
        
        // Construct full absolute URL using URL constructor
        // This ensures proper URL resolution regardless of browser quirks
        let fullUrl;
        try {
            // Use URL constructor with path and origin - this is the most reliable way
            const urlObj = new URL(path, window.location.origin);
            fullUrl = urlObj.href; // Get normalized absolute URL
        } catch (e) {
            // Fallback to string concatenation if URL constructor fails
            console.warn('URL construction error, using string concatenation:', e);
            fullUrl = window.location.origin + path;
        }
        
        console.log('API Path:', path);
        console.log('API Full URL:', fullUrl);
        console.log('window.location.origin:', window.location.origin);
        console.log('window.location.href:', window.location.href);
        console.log('Constructed URL object:', new URL(path, window.location.origin));
        
        return fullUrl;
    }
    
    // Save individual field to database
    async function saveField(fieldName, fieldValue) {
        try {
            const apiUrl = getApiUrl();
            console.log('Fetching to URL:', apiUrl);
            console.log('URL type:', typeof apiUrl);
            console.log('URL is absolute:', apiUrl.startsWith('http://') || apiUrl.startsWith('https://'));
            
            const response = await fetch(apiUrl, {
                method: 'POST',
                mode: 'cors',
                cache: 'no-cache',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                redirect: 'follow',
                body: JSON.stringify({
                    action: 'save_field',
                    form_session_id: formSessionId,
                    field_name: fieldName,
                    field_value: fieldValue
                })
            });
            
            const result = await response.json();
            if (result.success) {
                console.log(`Field ${fieldName} saved successfully`);
            } else {
                console.error(`Error saving field ${fieldName}:`, result.error);
            }
        } catch (error) {
            console.error('Error saving field:', error);
            // console.error('Failed URL was:', apiUrl);
            console.error('Error details:', {
                message: error.message,
                stack: error.stack,
                name: error.name
            });
        }
    }
    
    // Step management
    let currentStep = 1;
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const stepItems = document.querySelectorAll('.step-item');
    const stepLines = document.querySelectorAll('.step-line');

    // AmCharts 5 Globe initialization
    let root;
    let chart;
    let polygonSeries;
    let previousPolygon;
    let selectedCountries = []; // Track multiple selected countries {code, name}
    let selectedCountryPolygons = {}; // Track polygon objects for selected countries
    let selectedTrips = []; // Track selected trip values (e.g., 'ireland', 'ireland-scotland') separately from country codes
    
    // Destination to country code mapping with coordinates
    const destinations = {
        'poland': { countryCode: 'PL', name: 'Poland Trip', lat: 52.2297, lon: 21.0122 },
        'ireland': { countryCode: 'IE', name: 'Ireland Trip', lat: 53.4129, lon: -8.2439 },
        'norway': { countryCode: 'NO', name: 'Norway Trip', lat: 59.9139, lon: 10.7522 },
        'oman': { countryCode: 'OM', name: 'Oman Trip', lat: 23.5859, lon: 58.4059 },
        'scotland': { countryCode: 'GB', name: 'Scotland Trip', lat: 55.9533, lon: -3.1883 },
        'srilanka': { countryCode: 'LK', name: 'Sri Lanka Trip', lat: 7.8731, lon: 80.7718 },
        'uae-oman': { countryCode: 'AE', name: 'UAE & Oman Trip', lat: 24.4539, lon: 54.3773 },
        'ireland-scotland': { countryCode: 'IE', name: 'Ireland & Scotland Trip', lat: 54.7024, lon: -4.2766 }
    };
    
    // Get all predefined trip country codes
    const predefinedTrips = Object.values(destinations).map(d => d.countryCode);
    
    // Create reverse mapping: country code -> array of dropdown values
    const countryCodeToDropdownValues = {};
    Object.keys(destinations).forEach(key => {
        const countryCode = destinations[key].countryCode;
        if (!countryCodeToDropdownValues[countryCode]) {
            countryCodeToDropdownValues[countryCode] = [];
        }
        countryCodeToDropdownValues[countryCode].push(key);
    });

    // Initialize AmCharts Globe
    function initMap() {
        // Create root element
        root = am5.Root.new("chartdiv");
        
        // Initially disable map interactions since we start on step 1
        // This will be enabled when user reaches step 2

        // Set themes
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        // Create the map chart
        // Initially disable interactions (will be enabled in step 2)
        chart = root.container.children.push(am5map.MapChart.new(root, {
            panX: "none",
            panY: "none",
            projection: am5map.geoOrthographic(),
            paddingBottom: 20,
            paddingTop: 20,
            paddingLeft: 20,
            paddingRight: 20,
            wheelY: "none"
        }));

        // Create main polygon series for countries
        polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
            geoJSON: am4geodata_worldIndiaLow
        }));

        // Configure polygon template
        polygonSeries.mapPolygons.template.setAll({
            tooltipText: "{name}",
            toggleKey: "active",
            interactive: true,
            cursorOverStyle: "pointer",
            fill: am5.color("#1a1a24"),
            stroke: am5.color("#FF974F"),
            strokeWidth: 1,
            hitDisabled: false
        });

        // Hover State Color (Point 1) - Only applies when not selected
        polygonSeries.mapPolygons.template.states.create("hover", {
            fill: am5.color("#FFB366") // Lighter orange for hover
        });

        // Active/Selected State Color (Point 3)
        polygonSeries.mapPolygons.template.states.create("active", {
            fill: am5.color("#FF6B35") // Different color for selected drive
        });

        // Highlight predefined trip countries (Point 2 - Pre-selected, already done)
        polygonSeries.mapPolygons.template.adapters.add("fill", function(fill, target) {
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                // Selected drive color takes priority (Point 3) - check if in selectedCountries array
                var isSelected = selectedCountries.some(c => c.code === countryId);
                if (isSelected) {
                    return am5.color("#FF6B35"); // Selected drive color
                }
                // Pre-selected color for predefined trips (Point 2)
                if (predefinedTrips.includes(countryId)) {
                    return am5.color("#FF974F"); // Pre-selected color
                }
            }
            return fill;
        });

        polygonSeries.mapPolygons.template.adapters.add("fillOpacity", function(fillOpacity, target) {
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                if (predefinedTrips.includes(countryId)) {
                    return 0.6; // More visible highlight for predefined trips
                }
            }
            return fillOpacity;
        });
        
        // Add subtle pulsing animation to predefined trip countries and set up click handlers
        polygonSeries.events.on("datavalidated", function() {
            polygonSeries.mapPolygons.each(function(polygon) {
                var dataItem = polygon.dataItem;
                if (dataItem) {
                    var countryId = dataItem.get("id");
                    var countryName = dataItem.get("name") || countryId;
                    
                    // Set up click handler for each polygon using pointertap
                    // Only allow interaction when on step 2
                    polygon.events.on("pointertap", function(ev) {
                        // Prevent interaction if not on step 2
                        if (currentStep !== 2) {
                            if (ev.originalEvent) {
                                ev.originalEvent.stopPropagation();
                                ev.originalEvent.preventDefault();
                            }
                            return false;
                        }
                        
                        console.log('Polygon tapped - Country:', countryId, countryName);
                        if (ev.originalEvent) {
                            ev.originalEvent.stopPropagation();
                            ev.originalEvent.preventDefault();
                        }
                        toggleCountrySelection(countryId, countryName, polygon);
                        return false;
                    });
                    
                    if (predefinedTrips.includes(countryId)) {
                        // Gentle pulsing glow effect - opacity
                        var opacityStart = 0.6;
                        var opacityEnd = 0.8;
                        var currentOpacity = opacityStart;
                        var opacityDirection = 1;
                        
                        function pulseOpacity() {
                            currentOpacity += opacityDirection * 0.01;
                            if (currentOpacity >= opacityEnd) {
                                currentOpacity = opacityEnd;
                                opacityDirection = -1;
                            } else if (currentOpacity <= opacityStart) {
                                currentOpacity = opacityStart;
                                opacityDirection = 1;
                            }
                            polygon.set("fillOpacity", currentOpacity);
                            requestAnimationFrame(pulseOpacity);
                        }
                        pulseOpacity();
                        
                        // Subtle stroke width pulse
                        var strokeStart = 1.5;
                        var strokeEnd = 2.5;
                        var currentStroke = strokeStart;
                        var strokeDirection = 1;
                        
                        function pulseStroke() {
                            currentStroke += strokeDirection * 0.02;
                            if (currentStroke >= strokeEnd) {
                                currentStroke = strokeEnd;
                                strokeDirection = -1;
                            } else if (currentStroke <= strokeStart) {
                                currentStroke = strokeStart;
                                strokeDirection = 1;
                            }
                            polygon.set("strokeWidth", currentStroke);
                            requestAnimationFrame(pulseStroke);
                        }
                        pulseStroke();
                    }
                }
            });
        });

        polygonSeries.mapPolygons.template.adapters.add("strokeWidth", function(strokeWidth, target) {
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                if (predefinedTrips.includes(countryId)) {
                    return 1.5; // Slightly thicker border for predefined trips
                }
            }
            return strokeWidth;
        });
        
        // Add subtle glow effect to predefined trip countries
        polygonSeries.mapPolygons.template.adapters.add("stroke", function(stroke, target) {
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                if (predefinedTrips.includes(countryId)) {
                    return am5.color("#FFB366"); // Brighter orange for predefined trips
                }
            }
            return stroke;
        });

        // Create series for background fill
        var backgroundSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {}));
        backgroundSeries.mapPolygons.template.setAll({
            fill: am5.color("#0a0a0f"),
            fillOpacity: 0.1,
            strokeOpacity: 0
        });
        backgroundSeries.data.push({
            geometry: am5map.getGeoRectangle(90, 180, -90, -180)
        });

        // Add graticule
        var graticuleSeries = chart.series.unshift(
            am5map.GraticuleSeries.new(root, {
                step: 10
            })
        );
        graticuleSeries.mapLines.template.set("strokeOpacity", 0.1);
        graticuleSeries.mapLines.template.set("stroke", am5.color("#FF974F"));

        // Create point series for markers on predefined trips
        var pointSeries = chart.series.push(am5map.MapPointSeries.new(root, {}));
        
        // Main marker - clear and visible with animation
        pointSeries.bullets.push(function() {
            var circle = am5.Circle.new(root, {
                radius: 8,
                fill: am5.color("#FF974F"),
                stroke: am5.color("#0a0a0f"),
                strokeWidth: 3,
                tooltipText: "{name}"
            });
            
            // Clear pulsing animation - easy to see
            // Use a simple continuous animation
            var startScale = 1;
            var endScale = 1.4;
            var currentScale = startScale;
            var direction = 1;
            
            function pulse() {
                currentScale += direction * 0.02;
                if (currentScale >= endScale) {
                    currentScale = endScale;
                    direction = -1;
                } else if (currentScale <= startScale) {
                    currentScale = startScale;
                    direction = 1;
                }
                circle.set("scale", currentScale);
                requestAnimationFrame(pulse);
            }
            pulse();
            
            return am5.Bullet.new(root, {
                sprite: circle
            });
        });

        // Outer pulsing ring - visible animation
        pointSeries.bullets.push(function() {
            var circle = am5.Circle.new(root, {
                radius: 8,
                fill: am5.color("#FF974F"),
                fillOpacity: 0.5
            });
            
            // Clear expanding pulse
            circle.animate({
                key: "scale",
                to: 3,
                duration: 1800,
                loops: Infinity,
                easing: am5.ease.out(am5.ease.cubic)
            });
            
            circle.animate({
                key: "opacity",
                to: 0,
                duration: 1800,
                loops: Infinity,
                easing: am5.ease.out(am5.ease.cubic)
            });
            
            return am5.Bullet.new(root, {
                sprite: circle
            });
        });

        // Second ring for more visibility
        pointSeries.bullets.push(function() {
            var circle = am5.Circle.new(root, {
                radius: 8,
                fill: am5.color("#FFB366"),
                fillOpacity: 0.3
            });
            
            // Delayed animation for layered effect
            setTimeout(function() {
                circle.animate({
                    key: "scale",
                    to: 3,
                    duration: 1800,
                    loops: Infinity,
                    easing: am5.ease.out(am5.ease.cubic)
                });
                
                circle.animate({
                    key: "opacity",
                    to: 0,
                    duration: 1800,
                    loops: Infinity,
                    easing: am5.ease.out(am5.ease.cubic)
                });
            }, 900);
            
            return am5.Bullet.new(root, {
                sprite: circle
            });
        });

        // Add data points for predefined trips
        var pointData = Object.values(destinations).map(dest => ({
            latitude: dest.lat,
            longitude: dest.lon,
            name: dest.name
        }));

        pointSeries.data.setAll(pointData);

        // Configure tooltips for points - better styling
        pointSeries.bulletsContainer.children.each(function(bullet) {
            var tooltip = am5.Tooltip.new(root, {
                getFillFromSprite: false,
                fill: am5.color("#1a1a24"),
                stroke: am5.color("#FF974F"),
                strokeWidth: 2,
                paddingTop: 8,
                paddingBottom: 8,
                paddingLeft: 12,
                paddingRight: 12
            });
            tooltip.label.setAll({
                fill: am5.color("#FF974F"),
                fontSize: 12,
                fontWeight: "500"
            });
            tooltip.set("labelText", "{name}");
        });

        // Set up events for hover - override default hover state
        polygonSeries.mapPolygons.template.on("pointerover", function(ev) {
            var target = ev.target;
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                // Only show hover color if not a selected country
                var isSelected = selectedCountries.some(c => c.code === countryId);
                if (!isSelected) {
                    target.set("fill", am5.color("#FFB366")); // Hover color (Point 1)
                }
                // If selected, keep selected color
            }
        });

        polygonSeries.mapPolygons.template.on("pointerout", function(ev) {
            var target = ev.target;
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                // Restore appropriate color based on state
                var isSelected = selectedCountries.some(c => c.code === countryId);
                if (isSelected) {
                    target.set("fill", am5.color("#FF6B35")); // Selected drive color (Point 3)
                } else if (predefinedTrips.includes(countryId)) {
                    target.set("fill", am5.color("#FF974F")); // Pre-selected color (Point 2)
                } else {
                    target.set("fill", am5.color("#1a1a24")); // Default color
                }
            }
        });

        // Template handler removed - using individual polygon handlers in datavalidated event

        // Chart-level click detection removed - using polygon-level handlers instead

        // Make stuff animate on load
        chart.appear(1000, 100);
        
        // Debug: Test if selectedCountries is accessible
        console.log('Map initialized. selectedCountries array:', selectedCountries);
        console.log('toggleCountrySelection function:', typeof toggleCountrySelection);
    }

    // Function to toggle country selection
    function toggleCountrySelection(countryId, countryName, polygon) {
        console.log('toggleCountrySelection called:', countryId, countryName);
        console.log('Current selectedCountries before toggle:', selectedCountries);
        
        // Check if country is already selected
        var index = selectedCountries.findIndex(c => c.code === countryId);
        
        if (index > -1) {
            // Deselect - remove from array
            selectedCountries.splice(index, 1);
            delete selectedCountryPolygons[countryId];
            console.log('Country deselected:', countryId);
            
            // Update polygon color
            if (predefinedTrips.includes(countryId)) {
                polygon.set("fill", am5.color("#FF974F")); // Pre-selected color
                polygon.set("fillOpacity", 0.6);
            } else {
                polygon.set("fill", am5.color("#1a1a24")); // Default color
                polygon.set("fillOpacity", 1);
            }
            
            // Unselect all dropdown options for this country
            const matchingDropdownValues = countryCodeToDropdownValues[countryId] || [];
            matchingDropdownValues.forEach(val => {
                const option = document.querySelector(`.dropdown-option[data-value="${val}"]`);
                if (option) {
                    option.classList.remove('selected');
                }
            });
        } else {
            // Select - add to array
            selectedCountries.push({ code: countryId, name: countryName });
            selectedCountryPolygons[countryId] = polygon;
            console.log('Country selected:', countryId, countryName);
            console.log('Selected countries after push:', selectedCountries);
            
            // Update polygon color
            polygon.set("fill", am5.color("#FF6B35")); // Selected color
            polygon.set("fillOpacity", 0.9);
            polygon.set("strokeWidth", 2.5);
            
            // Select all dropdown options for this country (if it's a predefined trip)
            const matchingDropdownValues = countryCodeToDropdownValues[countryId] || [];
            matchingDropdownValues.forEach(val => {
                const option = document.querySelector(`.dropdown-option[data-value="${val}"]`);
                if (option) {
                    option.classList.add('selected');
                }
            });
        }
        
        // Update step 2 with selected countries
        updateStep2SelectedCountries();
        
        // Update dropdown display
        updateDropdownDisplay();
        
        // Update dropdown state
        const selectedOptions = document.querySelectorAll('.dropdown-option.selected');
        const customDropdown = document.getElementById('customDropdown');
        const dropdownWrapper = customDropdown ? customDropdown.closest('.custom-dropdown-wrapper') : null;
        if (selectedOptions.length > 0 && dropdownWrapper) {
            customDropdown.classList.add('has-value');
            dropdownWrapper.classList.add('has-value');
        } else if (selectedOptions.length === 0 && dropdownWrapper) {
            customDropdown.classList.remove('has-value');
            dropdownWrapper.classList.remove('has-value');
        }
        
        // Save selected countries to database
        saveField('selectedCountries', JSON.stringify(selectedCountries));
        
        // Debug: Log selected countries
        console.log('Final selected countries:', selectedCountries);
        console.log('Selected countries length:', selectedCountries.length);
    }
    
    // Function to sync dropdown selection with globe selection (deprecated - now handled in toggleCountrySelection)
    function syncDropdownWithGlobe() {
        // This function is kept for backward compatibility but logic is now in toggleCountrySelection
        updateDropdownDisplay();
    }
    
    // Function to update dropdown display to show selected items
    function updateDropdownDisplay() {
        const dropdownSelected = document.querySelector('.custom-dropdown-selected');
        const dropdownValue = document.querySelector('.dropdown-value');
        const dropdownPlaceholder = document.querySelector('.dropdown-placeholder');
        const selectedOptions = document.querySelectorAll('.dropdown-option.selected');
        
        if (selectedOptions.length === 0) {
            dropdownPlaceholder.style.display = 'block';
            dropdownValue.style.display = 'none';
            dropdownValue.textContent = '';
        } else if (selectedOptions.length === 1) {
            dropdownPlaceholder.style.display = 'none';
            dropdownValue.style.display = 'block';
            // Use the actual selected option text, not from country code mapping
            dropdownValue.textContent = selectedOptions[0].textContent.trim();
        } else {
            dropdownPlaceholder.style.display = 'none';
            dropdownValue.style.display = 'block';
            dropdownValue.textContent = `${selectedOptions.length} trips selected`;
        }
    }

    // Function to select and zoom to a country
    function selectCountry(id) {
        var dataItem = polygonSeries.getDataItemById(id);
        var target = dataItem.get("mapPolygon");
        if (target) {
            var centroid = target.geoCentroid();
            if (centroid) {
                chart.animate({ key: "rotationX", to: -centroid.longitude, duration: 1500, easing: am5.ease.inOut(am5.ease.cubic) });
                chart.animate({ key: "rotationY", to: -centroid.latitude, duration: 1500, easing: am5.ease.inOut(am5.ease.cubic) });
            }

            setTimeout(function () {
                // Use reduced zoom level (0.2 = 20% zoom instead of default 100%)
                // This provides a subtle zoom that shows the country with plenty of surrounding context
                polygonSeries.zoomToDataItem(dataItem, 0.2);
            }, 1500);
        }
    }

    // Show error message on map
    function showMapError(message) {
        const mapContainer = document.getElementById('globeMap');
        if (mapContainer) {
            mapContainer.innerHTML = `
                <div style="
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    height: 100%;
                    padding: 20px;
                    text-align: center;
                    color: #FF974F;
                    background: rgba(26, 26, 36, 0.9);
                ">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-bottom: 20px;">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <h3 style="margin-bottom: 10px; font-family: 'Playfair Display', serif;">Globe Loading Error</h3>
                    <p style="color: #b8b8b8; max-width: 400px; line-height: 1.6;">${message}</p>
                </div>
            `;
        }
    }

    // Update globe marker based on selected trip from dropdown
    function updateMapMarker(tripValue) {
        // Get destination data
        const destination = destinations[tripValue];
        if (!destination || !chart) return;

        // Find the polygon for this country
        var dataItem = polygonSeries.getDataItemById(destination.countryCode);
        if (dataItem) {
            var polygon = dataItem.get("mapPolygon");
            // Use the country name from the dataItem if available, otherwise use destination name
            var countryName = dataItem.get("name") || destination.name;
            
            // Check if the dropdown option is now selected or unselected
            const option = document.querySelector(`.dropdown-option[data-value="${tripValue}"]`);
            const isOptionSelected = option && option.classList.contains('selected');
            
            // Track selected trips separately
            const tripIndex = selectedTrips.indexOf(tripValue);
            if (isOptionSelected && tripIndex === -1) {
                // Add to selected trips
                selectedTrips.push(tripValue);
            } else if (!isOptionSelected && tripIndex > -1) {
                // Remove from selected trips
                selectedTrips.splice(tripIndex, 1);
            }
            
            // Check if country is already selected on globe
            var isCountrySelected = selectedCountries.some(c => c.code === destination.countryCode);
            
            // Check if any trip with this country code is selected
            const hasAnyTripSelected = selectedTrips.some(trip => {
                const tripDest = destinations[trip];
                return tripDest && tripDest.countryCode === destination.countryCode;
            });
            
            if (hasAnyTripSelected && !isCountrySelected) {
                // At least one trip for this country is selected but country is not - select it on globe
                toggleCountrySelection(destination.countryCode, countryName, polygon);
                // Zoom to the country
                selectCountry(destination.countryCode);
            } else if (!hasAnyTripSelected && isCountrySelected) {
                // No trips for this country are selected, so deselect on globe
                toggleCountrySelection(destination.countryCode, countryName, polygon);
            }
        }
    }
    
    // Update step 2 with selected countries display
    function updateStep2SelectedCountries() {
        const selectedCountriesContainer = document.getElementById('selectedCountriesContainer');
        if (!selectedCountriesContainer) return;
        
        // Get custom countries from textbox (only count actual countries typed, not "Other" option)
        const customCountriesField = document.getElementById('customCountries');
        let customCountries = [];
        if (customCountriesField && customCountriesField.value.trim()) {
            // Split by comma and clean up each country name
            customCountries = customCountriesField.value
                .split(',')
                .map(country => country.trim())
                .filter(country => country.length > 0);
        }
        
        // Count predefined countries (from globe/dropdown) - exclude "other" from count
        const predefinedCount = selectedCountries.length;
        
        // Count custom countries (from textbox)
        const customCount = customCountries.length;
        
        // Total count = predefined countries + custom countries (NOT including "Other" option)
        const totalCount = predefinedCount + customCount;
        
        // Combine selected countries from globe/dropdown with custom countries for display
        const allCountries = [...selectedCountries];
        customCountries.forEach((countryName, index) => {
            allCountries.push({
                code: 'CUSTOM_' + index,
                name: countryName,
                isCustom: true
            });
        });
        
        // Update hidden input with all countries
        let selectedCountriesInput = document.getElementById('selectedCountries');
        if (!selectedCountriesInput) {
            selectedCountriesInput = document.createElement('input');
            selectedCountriesInput.type = 'hidden';
            selectedCountriesInput.id = 'selectedCountries';
            selectedCountriesInput.name = 'selectedCountries';
            enquiryForm.appendChild(selectedCountriesInput);
        }
        selectedCountriesInput.value = JSON.stringify(allCountries);
        
        if (totalCount === 0) {
            selectedCountriesContainer.innerHTML = '<p class="no-selection">No countries selected. Click on the globe or choose from dropdown.</p>';
            return;
        }
        
        // Build count display showing breakdown
        let countText = `Total: ${totalCount} ${totalCount === 1 ? 'country' : 'countries'} selected`;
        if (predefinedCount > 0 && customCount > 0) {
            countText = `Total: ${totalCount} ${totalCount === 1 ? 'country' : 'countries'} selected (${predefinedCount} predefined + ${customCount} custom)`;
        } else if (predefinedCount > 0) {
            countText = `Total: ${predefinedCount} ${predefinedCount === 1 ? 'country' : 'countries'} selected`;
        } else if (customCount > 0) {
            countText = `Total: ${customCount} ${customCount === 1 ? 'country' : 'countries'} selected`;
        }
        
        let html = `<div class="selected-countries-header"><p class="countries-count">${countText}</p></div>`;
        html += '<div class="selected-countries-list">';
        
        // Display countries from globe/dropdown
        selectedCountries.forEach((country, index) => {
            html += `
                <div class="selected-country-item" data-code="${country.code}">
                    <span class="country-name">${country.name}</span>
                    <button type="button" class="remove-country" data-code="${country.code}" aria-label="Remove ${country.name}">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            `;
        });
        
        // Display custom countries
        customCountries.forEach((countryName, index) => {
            const customCode = 'CUSTOM_' + index;
            html += `
                <div class="selected-country-item custom-country" data-code="${customCode}">
                    <span class="country-name">${countryName}</span>
                    <button type="button" class="remove-country remove-custom-country" data-code="${customCode}" data-country-name="${countryName}" aria-label="Remove ${countryName}">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            `;
        });
        
        html += '</div>';
        selectedCountriesContainer.innerHTML = html;
        
        // Add event listeners for remove buttons (globe/dropdown countries)
        selectedCountriesContainer.querySelectorAll('.remove-country:not(.remove-custom-country)').forEach(btn => {
            btn.addEventListener('click', function() {
                const code = this.getAttribute('data-code');
                const polygon = selectedCountryPolygons[code];
                if (polygon) {
                    var dataItem = polygon.dataItem;
                    var countryName = dataItem ? dataItem.get("name") : code;
                    toggleCountrySelection(code, countryName, polygon);
                }
            });
        });
        
        // Add event listeners for remove buttons (custom countries)
        selectedCountriesContainer.querySelectorAll('.remove-custom-country').forEach(btn => {
            btn.addEventListener('click', function() {
                const countryName = this.getAttribute('data-country-name');
                if (customCountriesField) {
                    // Remove the country from the textbox
                    let currentCountries = customCountriesField.value
                        .split(',')
                        .map(c => c.trim())
                        .filter(c => c.length > 0 && c !== countryName);
                    customCountriesField.value = currentCountries.join(', ');
                    
                    // Update has-value class
                    if (currentCountries.length === 0) {
                        customCountriesField.classList.remove('has-value');
                    }
                    
                    // Trigger update to refresh display
                    updateStep2SelectedCountries();
                }
            });
        });
    }

    // Step navigation functions
    function updateStepIndicator() {
        stepItems.forEach((item, index) => {
            const stepNum = index + 1;
            if (stepNum < currentStep) {
                item.classList.add('completed');
                item.classList.remove('active');
            } else if (stepNum === currentStep) {
                item.classList.add('active');
                item.classList.remove('completed');
            } else {
                item.classList.remove('active', 'completed');
            }
        });
        
        stepLines.forEach((line, index) => {
            if (index + 1 < currentStep) {
                line.classList.add('completed');
            } else {
                line.classList.remove('completed');
            }
        });
    }
    
    function showStep(step) {
        // Prevent going to step 2 if step 1 is not validated
        if (step === 2 && !validateStep1()) {
            alert('Please complete all fields in Step 1 before proceeding.');
            return;
        }
        
        // Note: Country selection is NOT required to go to Step 2
        // Country selection will be required when submitting the form in Step 2
        
        // Hide all steps
        step1.classList.remove('active');
        step2.classList.remove('active');
        
        // Show current step
        if (step === 1) {
            step1.classList.add('active');
        } else if (step === 2) {
            step2.classList.add('active');
            // Update selected countries display
            updateStep2SelectedCountries();
        }
        
        currentStep = step;
        updateStepIndicator();
        
        // Show/hide map lock overlay based on current step
        const mapLockOverlay = document.getElementById('mapLockOverlay');
        if (mapLockOverlay) {
            if (step === 1) {
                mapLockOverlay.classList.remove('hidden');
            } else if (step === 2) {
                mapLockOverlay.classList.add('hidden');
            }
        }
        
        // Disable/enable map interactions based on step
        if (chart) {
            if (step === 1) {
                // Disable map interactions
                chart.set('wheelY', 'none');
                chart.set('panX', 'none');
                chart.set('panY', 'none');
            } else if (step === 2) {
                // Enable map interactions
                chart.set('wheelY', 'zoom');
                chart.set('panX', 'rotateX');
                chart.set('panY', 'rotateY');
            }
        }
    }
    
    function validateStep1() {
        const firstName = document.getElementById('firstName');
        const email = document.getElementById('email');
        const phone = document.getElementById('phone');
        
        let isValid = true;
        
        // Validate required fields (firstName and phone are required, email is optional)
        [firstName, phone].forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.parentElement.classList.add('error');
                setTimeout(() => {
                    input.parentElement.classList.remove('error');
                }, 1000);
            } else {
                input.parentElement.classList.remove('error');
            }
        });
        
        // Email validation - only validate format if email is provided (optional field)
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value && email.value.trim() && !emailRegex.test(email.value)) {
            isValid = false;
            email.parentElement.classList.add('error');
            setTimeout(() => {
                email.parentElement.classList.remove('error');
            }, 1000);
        } else if (email.value && email.value.trim()) {
            // Clear error if email is valid
            email.parentElement.classList.remove('error');
        }
        
        return isValid;
    }
    
    // Next button handler
    nextBtn.addEventListener('click', function() {
        console.log('=== Next Button Clicked ===');
        console.log('Step 1 validation:', validateStep1());
        console.log('Selected countries array:', selectedCountries);
        console.log('Selected countries length:', selectedCountries.length);
        
        if (validateStep1()) {
            // Step 1 can proceed to Step 2 without country selection
            // Country selection will be required when submitting the form
            console.log('Proceeding to step 2');
            showStep(2);
            // Focus first input in step 2
            setTimeout(() => {
                const numberOfPeopleInput = document.getElementById('numberOfPeople');
                if (numberOfPeopleInput) {
                    numberOfPeopleInput.focus();
                }
            }, 300);
        } else {
            // Shake animation
            step1.style.animation = 'shake 0.5s';
            setTimeout(() => {
                step1.style.animation = '';
            }, 500);
        }
    });
    
    // Previous button handler
    prevBtn.addEventListener('click', function() {
        showStep(1);
        // Focus first input in step 1
        setTimeout(() => {
            document.getElementById('firstName').focus();
        }, 300);
    });

    // Custom Dropdown Functionality
    const customDropdown = document.getElementById('customDropdown');
    const dropdownSelected = customDropdown.querySelector('.custom-dropdown-selected');
    const dropdownMenu = customDropdown.querySelector('.custom-dropdown-menu');
    const dropdownOptions = dropdownMenu.querySelectorAll('.dropdown-option');
    const tripTypeInput = document.getElementById('tripType');
    const dropdownValue = customDropdown.querySelector('.dropdown-value');
    const dropdownPlaceholder = customDropdown.querySelector('.dropdown-placeholder');
    const dropdownWrapper = customDropdown.closest('.custom-dropdown-wrapper');

    // Toggle dropdown
    dropdownSelected.addEventListener('click', function(e) {
        e.stopPropagation();
        customDropdown.classList.toggle('active');
    });

    // Select option - now supports multiple selection
    dropdownOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.stopPropagation();
            const value = this.getAttribute('data-value');
            const isOther = value === 'other';
            
            // Toggle selected class on option
            const isNowSelected = !this.classList.contains('selected');
            this.classList.toggle('selected');
            
            // Track selected trips
            if (isNowSelected) {
                if (selectedTrips.indexOf(value) === -1) {
                    selectedTrips.push(value);
                }
            } else {
                const tripIndex = selectedTrips.indexOf(value);
                if (tripIndex > -1) {
                    selectedTrips.splice(tripIndex, 1);
                }
            }
            
            // Show/hide custom countries input based on "Other" selection
            const customCountriesInput = document.getElementById('customCountriesInput');
            const customCountriesField = document.getElementById('customCountries');
            const hasOtherSelected = selectedTrips.indexOf('other') > -1;
            
            if (customCountriesInput && customCountriesField) {
                if (hasOtherSelected) {
                    // If "Other" is selected, show the input
                    customCountriesInput.style.display = 'block';
                    
                    // Clear textbox when "Other" is clicked (whether selecting or re-selecting)
                    if (isOther) {
                        customCountriesField.value = '';
                        customCountriesField.classList.remove('has-value');
                        // Update display to reflect cleared textbox
                        updateStep2SelectedCountries();
                    }
                    
                    // Focus on the textarea after a short delay
                    setTimeout(() => {
                        if (customCountriesField) {
                            customCountriesField.focus();
                        }
                    }, 100);
                } else {
                    // If "Other" is deselected, hide and clear the input
                    customCountriesInput.style.display = 'none';
                    customCountriesField.value = '';
                    customCountriesField.classList.remove('has-value');
                    // Update display to reflect cleared textbox
                    updateStep2SelectedCountries();
                }
            }
            
            // Update map marker - this will toggle the country selection (skip for "other")
            if (!isOther) {
                updateMapMarker(value);
            }
            
            // Update dropdown display
            updateDropdownDisplay();
            
            // Update dropdown state
            const selectedOptions = document.querySelectorAll('.dropdown-option.selected');
            if (selectedOptions.length > 0) {
            customDropdown.classList.add('has-value');
            dropdownWrapper.classList.add('has-value');
            } else {
                customDropdown.classList.remove('has-value');
                dropdownWrapper.classList.remove('has-value');
            }
            
            // Save trip selection to database
            const selectedTripValues = Array.from(selectedOptions).map(opt => opt.getAttribute('data-value'));
            saveField('tripType', JSON.stringify(selectedTripValues));
            
            // Remove error state
            dropdownWrapper.classList.remove('error');
            
            // Don't close dropdown automatically - allow multiple selections
            // User can click outside or press Escape to close
            
            // Note: Country selection is not required to proceed to Step 2
            // It will be required when submitting the form
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!customDropdown.contains(e.target)) {
            customDropdown.classList.remove('active');
        }
    });

    // Close dropdown on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && customDropdown.classList.contains('active')) {
            customDropdown.classList.remove('active');
        }
    });

    // Form input animations
    const inputs = enquiryForm.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], input[type="month"], textarea, #customCountries');
    
    inputs.forEach(input => {
        // Check if input has value on load
        if (input.value) {
            input.classList.add('has-value');
        }

        // Handle focus
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });

        // Handle blur - save field to database
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
            if (this.value) {
                this.classList.add('has-value');
                
                // Save field to database
                const fieldName = this.name || this.id;
                let fieldValue = this.value;
                
                // Clean phone number for storage (remove formatting)
                if (fieldName === 'phone') {
                    fieldValue = fieldValue.replace(/\D/g, '');
                }
                
                if (fieldName && fieldValue) {
                    saveField(fieldName, fieldValue);
                }
            } else {
                this.classList.remove('has-value');
            }
        });

        // Handle input changes
        input.addEventListener('input', function() {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
        
        // Handle change for month input
        input.addEventListener('change', function() {
            if (this.value) {
                this.classList.add('has-value');
            } else {
                this.classList.remove('has-value');
            }
        });
    });
    
    // Special handling for custom countries textarea - update display in real-time
    const customCountriesField = document.getElementById('customCountries');
    if (customCountriesField) {
        customCountriesField.addEventListener('input', function() {
            // Update the selected countries display when user types
            updateStep2SelectedCountries();
        });
        
        customCountriesField.addEventListener('blur', function() {
            // Save custom countries to database
            if (this.value.trim()) {
                saveField('customCountries', this.value.trim());
            }
        });
    }

    // Phone number formatting
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (value.length <= 3) {
                value = value;
            } else if (value.length <= 6) {
                value = `(${value.slice(0, 3)}) ${value.slice(3)}`;
            } else {
                value = `(${value.slice(0, 3)}) ${value.slice(3, 6)}-${value.slice(6, 10)}`;
            }
        }
        e.target.value = value;
    });

    // Form submission
    enquiryForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Make sure we're on step 2
        if (currentStep !== 2) {
            showStep(2);
            return;
        }

        // Validate form
        let isValid = true;
        
        // Validate step 1 fields
        if (!validateStep1()) {
            isValid = false;
            showStep(1);
        }
        
        // Validate that at least one country is selected
        if (selectedCountries.length === 0) {
            isValid = false;
            alert('Please select at least one country from the globe or dropdown.');
        }
        
        // Validate step 2 fields
        const numberOfPeopleInput = document.getElementById('numberOfPeople');
        const travelMonthInput = document.getElementById('travelMonth');
        const messageInput = document.getElementById('message');
        
        if (numberOfPeopleInput && numberOfPeopleInput.hasAttribute('required') && (!numberOfPeopleInput.value || parseInt(numberOfPeopleInput.value) < 1)) {
            isValid = false;
            numberOfPeopleInput.parentElement.classList.add('error');
            setTimeout(() => {
                numberOfPeopleInput.parentElement.classList.remove('error');
            }, 1000);
        } else if (numberOfPeopleInput) {
            numberOfPeopleInput.parentElement.classList.remove('error');
        }
        
        if (travelMonthInput && travelMonthInput.hasAttribute('required') && !travelMonthInput.value) {
            isValid = false;
            travelMonthInput.parentElement.classList.add('error');
            setTimeout(() => {
                travelMonthInput.parentElement.classList.remove('error');
            }, 1000);
        } else if (travelMonthInput) {
            travelMonthInput.parentElement.classList.remove('error');
        }
        
        if (messageInput && messageInput.hasAttribute('required') && !messageInput.value.trim()) {
            isValid = false;
            messageInput.parentElement.classList.add('error');
            setTimeout(() => {
                messageInput.parentElement.classList.remove('error');
            }, 1000);
        } else if (messageInput) {
            messageInput.parentElement.classList.remove('error');
        }

        if (!isValid) {
            // Shake animation
            step2.style.animation = 'shake 0.5s';
            setTimeout(() => {
                step2.style.animation = '';
            }, 500);
            return;
        }

        // Show loading state
        const submitBtn = enquiryForm.querySelector('.submit-btn');
        const submitText = submitBtn.querySelector('.submit-text');
        const originalText = submitText.textContent;
        
        submitText.textContent = 'Sending...';
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.7';
        submitBtn.style.cursor = 'not-allowed';

        // Capture selected dropdown trips BEFORE resetting form
        const selectedDropdownOptions = document.querySelectorAll('.dropdown-option.selected');
        const selectedTripValues = Array.from(selectedDropdownOptions).map(opt => opt.getAttribute('data-value'));
        
        // Prepare form data for submission
        const customCountriesField = document.getElementById('customCountries');
        const customCountries = customCountriesField ? customCountriesField.value.trim() : '';
        
        const formData = {
            firstName: document.getElementById('firstName').value,
            email: document.getElementById('email').value,
            phone: document.getElementById('phone').value.replace(/\D/g, ''), // Clean phone number
            tripType: JSON.stringify(selectedTripValues),
            selectedCountries: JSON.stringify(selectedCountries),
            customCountries: customCountries,
            numberOfPeople: parseInt(document.getElementById('numberOfPeople').value) || null,
            travelMonth: document.getElementById('travelMonth').value,
            message: document.getElementById('message').value
        };
        
        // Submit form to API
        async function submitFormToAPI() {
            try {
                const apiUrl = getApiUrl();
                console.log('Form submission - Fetching to URL:', apiUrl);
                console.log('Form submission - URL type:', typeof apiUrl);
                
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    mode: 'cors',
                    cache: 'no-cache',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    redirect: 'follow',
                    body: JSON.stringify({
                        action: 'submit_form',
                        form_session_id: formSessionId,
                        ...formData
                    })
                });
                
                const result = await response.json();
                if (result.success) {
                    console.log('Form submitted successfully:', result);
                    return true;
                } else {
                    console.error('Error submitting form:', result.error);
                    alert('There was an error submitting your form. Please try again.');
                    return false;
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('There was an error submitting your form. Please try again.');
                return false;
            }
        }
        
        // Map trip values to display names and gallery URLs
        const tripDisplayNames = {
            'poland': 'Poland',
            'ireland': 'Ireland',
            'norway': 'Norway',
            'oman': 'Oman',
            'scotland': 'Scotland',
            'srilanka': 'Sri Lanka',
            'uae-oman': 'UAE & Oman',
            'ireland-scotland': 'Ireland & Scotland'
        };
        
        // Function to generate gallery URL for a trip
        function getTripGalleryUrl(tripValue) {
            // Use urlPath function if available (from contact_us.php), otherwise construct manually
            if (typeof window.urlPath === 'function') {
                return window.urlPath(tripValue + '/memories');
            } else {
                // Fallback: construct URL manually
                const base = window.BASE_PATH || '';
                return (base ? base + '/' : '/') + tripValue + '/memories';
            }
        }
        
        // Generate trip links HTML
        function generateTripLinks(selectedTrips) {
            if (selectedTrips.length === 0) {
                return '';
            }
            
            const links = selectedTrips.map(tripValue => {
                const displayName = tripDisplayNames[tripValue] || tripValue;
                const galleryUrl = getTripGalleryUrl(tripValue);
                return `<a href="${galleryUrl}" class="trip-link">Visit ${displayName} Gallery</a>`;
            });
            
            return links.join('');
        }

        // Submit form to API
        submitFormToAPI().then(success => {
            if (!success) {
                // Reset button if submission failed
                submitText.textContent = originalText;
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
                return;
            }
            
            // Show success message
            successOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
            
            // Display trip links if any dropdown trips were selected
            const tripLinksContainer = document.getElementById('tripLinksContainer');
            const tripLinksList = document.getElementById('tripLinksList');
            
            if (selectedTripValues.length > 0 && tripLinksContainer && tripLinksList) {
                const linksHtml = generateTripLinks(selectedTripValues);
                tripLinksList.innerHTML = linksHtml;
                tripLinksContainer.style.display = 'block';
            } else if (tripLinksContainer) {
                tripLinksContainer.style.display = 'none';
            }

            // Reset form
            enquiryForm.reset();
            inputs.forEach(input => {
                input.classList.remove('has-value');
                input.parentElement.classList.remove('focused');
            });
            
            // Reset custom dropdown
            tripTypeInput.value = '';
            dropdownOptions.forEach(opt => opt.classList.remove('selected'));
            updateDropdownDisplay();
            customDropdown.classList.remove('has-value');
            dropdownWrapper.classList.remove('has-value');
            customDropdown.classList.remove('active');
            
            // Reset custom countries input
            const customCountriesInput = document.getElementById('customCountriesInput');
            const customCountriesField = document.getElementById('customCountries');
            if (customCountriesInput) {
                customCountriesInput.style.display = 'none';
            }
            if (customCountriesField) {
                customCountriesField.value = '';
                customCountriesField.classList.remove('has-value');
            }
            
            // Reset step 2 fields
            const numberOfPeopleInput = document.getElementById('numberOfPeople');
            const travelMonthInput = document.getElementById('travelMonth');
            if (numberOfPeopleInput) numberOfPeopleInput.value = '';
            if (travelMonthInput) travelMonthInput.value = '';
            
            // Reset to step 1
            showStep(1);
            
            // Reset globe view
            if (chart && previousPolygon) {
                previousPolygon.set("active", false);
                previousPolygon = null;
            }
            
            // Reset selected countries and trips
            selectedCountries = [];
            selectedCountryPolygons = {};
            selectedTrips = [];
            
            // Generate new form session ID for next submission
            formSessionId = generateFormSessionId();
            
            // Reset all polygons to their default/pre-selected states
            if (polygonSeries) {
                polygonSeries.mapPolygons.each(function(polygon) {
                    var dataItem = polygon.dataItem;
                    if (dataItem) {
                        var countryId = dataItem.get("id");
                        if (predefinedTrips.includes(countryId)) {
                            // Reset to pre-selected color
                            polygon.set("fill", am5.color("#FF974F"));
                            polygon.set("fillOpacity", 0.6);
                            polygon.set("strokeWidth", 1.5);
                        } else {
                            // Reset to default
                            polygon.set("fill", am5.color("#1a1a24"));
                            polygon.set("fillOpacity", 1);
                            polygon.set("strokeWidth", 1);
                        }
                    }
                });
            }
            
            // Update step 2 display
            updateStep2SelectedCountries();
            
            if (chart) {
                chart.animate({ key: "rotationX", to: 0, duration: 1500, easing: am5.ease.inOut(am5.ease.cubic) });
                chart.animate({ key: "rotationY", to: 0, duration: 1500, easing: am5.ease.inOut(am5.ease.cubic) });
            }

            // Reset button
            submitText.textContent = originalText;
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
            submitBtn.style.cursor = 'pointer';

            // Here you would normally send the data to your server:
            // const formData = new FormData(enquiryForm);
            // fetch('/api/enquiry', {
            //     method: 'POST',
            //     body: formData
            // })
            // .then(response => response.json())
            // .then(data => {
            //     // Handle success
            // })
            // .catch(error => {
            //     // Handle error
            // });
        }, 1500);
    });

    // Close success overlay
    closeSuccess.addEventListener('click', function() {
        successOverlay.classList.remove('active');
        document.body.style.overflow = '';

        window.location.href = '/home';
    });

    // Close success on overlay click
    successOverlay.addEventListener('click', function(e) {
        if (e.target === successOverlay) {
            successOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // Add shake animation style
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px); }
            20%, 40%, 60%, 80% { transform: translateX(10px); }
        }
        .form-group.error input,
        .form-group.error textarea {
            border-bottom-color: #f5576c !important;
            animation: shake 0.5s;
        }
        .custom-dropdown-wrapper.error .custom-dropdown-selected {
            border-bottom-color: #f5576c !important;
            animation: shake 0.5s;
        }
        .custom-marker {
            position: relative;
            width: 40px;
            height: 40px;
        }
        .marker-pulse {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 151, 79, 0.4);
            animation: pulse-marker 2s infinite;
        }
        @keyframes pulse-marker {
            0% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 1;
            }
            100% {
                transform: translate(-50%, -50%) scale(2);
                opacity: 0;
            }
        }
        .marker-pin {
            position: relative;
            z-index: 1;
            width: 40px;
            height: 40px;
        }
        .marker-pin svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.3));
        }
    `;
    document.head.appendChild(style);

    // Initialize globe when AmCharts is ready
    if (typeof am5 !== 'undefined' && typeof am5map !== 'undefined') {
        initMap();
        // Set initial lock overlay state (step 1 is active by default)
        const mapLockOverlay = document.getElementById('mapLockOverlay');
        if (mapLockOverlay && currentStep === 1) {
            mapLockOverlay.classList.remove('hidden');
        }
    } else {
        // Wait for libraries to load
        setTimeout(() => {
            if (typeof am5 !== 'undefined' && typeof am5map !== 'undefined') {
                initMap();
                // Set initial lock overlay state (step 1 is active by default)
                const mapLockOverlay = document.getElementById('mapLockOverlay');
                if (mapLockOverlay && currentStep === 1) {
                    mapLockOverlay.classList.remove('hidden');
                }
            }
        }, 500);
    }
    
    // Expose functions for debugging (remove in production)
    window.debugGlobe = {
        getSelectedCountries: function() {
            console.log('Selected countries:', selectedCountries);
            return selectedCountries;
        },
        testToggle: function(countryCode) {
            if (polygonSeries) {
                var dataItem = polygonSeries.getDataItemById(countryCode);
                if (dataItem) {
                    var polygon = dataItem.get("mapPolygon");
                    var countryName = dataItem.get("name") || countryCode;
                    toggleCountrySelection(countryCode, countryName, polygon);
                } else {
                    console.error('Country not found:', countryCode);
                }
            } else {
                console.error('Polygon series not initialized');
            }
        },
        clearSelection: function() {
            selectedCountries = [];
            selectedCountryPolygons = {};
            updateStep2SelectedCountries();
            console.log('Selection cleared');
        }
    };
});
