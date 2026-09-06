// Mapbox and Form Handling
document.addEventListener('DOMContentLoaded', function() {
    const enquiryForm = document.getElementById('enquiryForm');
    const successOverlay = document.getElementById('successOverlay');
    const closeSuccess = document.getElementById('closeSuccess');
    
    // Initialize month/year picker - populate years starting from next month
    const travelMonthSelect = document.getElementById('travelMonth');
    const travelYearSelect = document.getElementById('travelYear');
    const travelMonthYearHidden = document.getElementById('travelMonthYear');
    
    if (travelMonthSelect && travelYearSelect && travelMonthYearHidden) {
        const today = new Date();
        const nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, 1);
        const currentYear = today.getFullYear();
        const currentMonth = today.getMonth() + 1;
        const nextMonthValue = nextMonth.getMonth() + 1;
        const nextYear = nextMonth.getFullYear();
        
        // Populate years (next year to 5 years ahead)
        for (let year = nextYear; year <= nextYear + 5; year++) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            travelYearSelect.appendChild(option);
        }
        
        // Disable current month if we're in the current year
        if (travelYearSelect.value === currentYear.toString() || !travelYearSelect.value) {
            Array.from(travelMonthSelect.options).forEach((option, index) => {
                if (index > 0 && parseInt(option.value) < nextMonthValue) {
                    option.disabled = true;
                }
            });
        }
        
        // Update hidden input when month or year changes
        function updateMonthYearValue() {
            const month = travelMonthSelect.value;
            const year = travelYearSelect.value;
            if (month && year) {
                const monthYear = `${year}-${month.padStart(2, '0')}`;
                travelMonthYearHidden.value = monthYear;
                travelMonthYearHidden.classList.add('has-value');
                
                // Enable/disable months based on selected year
                if (year === currentYear.toString()) {
                    Array.from(travelMonthSelect.options).forEach((option, index) => {
                        if (index > 0) {
                            if (parseInt(option.value) < nextMonthValue) {
                                option.disabled = true;
                            } else {
                                option.disabled = false;
                            }
                        }
                    });
                } else {
                    // Enable all months for future years
                    Array.from(travelMonthSelect.options).forEach((option) => {
                        option.disabled = false;
                    });
                }
            } else {
                travelMonthYearHidden.value = '';
                travelMonthYearHidden.classList.remove('has-value');
            }
        }
        
        // Update label position when selects change
        function updateLabelPosition() {
            const monthYearPicker = travelMonthSelect.closest('.month-year-picker');
            if (monthYearPicker) {
                if (travelMonthSelect.value && travelYearSelect.value) {
                    monthYearPicker.classList.add('has-value');
                } else {
                    monthYearPicker.classList.remove('has-value');
                }
            }
        }
        
        travelMonthSelect.addEventListener('change', function() {
            updateMonthYearValue();
            updateLabelPosition();
        });
        
        travelYearSelect.addEventListener('change', function() {
            updateMonthYearValue();
            // Re-check month availability when year changes
            if (this.value === currentYear.toString()) {
                Array.from(travelMonthSelect.options).forEach((option, index) => {
                    if (index > 0 && parseInt(option.value) < nextMonthValue) {
                        option.disabled = true;
                        // If current selection is disabled, reset it
                        if (travelMonthSelect.value === option.value) {
                            travelMonthSelect.value = '';
                        }
                    } else {
                        option.disabled = false;
                    }
                });
            } else {
                Array.from(travelMonthSelect.options).forEach((option) => {
                    option.disabled = false;
                });
            }
            updateLabelPosition();
        });
        
        // Check if there's a saved value
        const savedMonthYear = travelMonthYearHidden.value;
        if (savedMonthYear) {
            const [savedYear, savedMonth] = savedMonthYear.split('-');
            travelYearSelect.value = savedYear;
            travelMonthSelect.value = savedMonth;
            updateMonthYearValue();
            updateLabelPosition();
        }
        
        // Handle focus/blur for label styling
        function handleSelectFocus() {
            const monthYearPicker = travelMonthSelect.closest('.month-year-picker');
            if (monthYearPicker) {
                monthYearPicker.classList.add('focused');
            }
        }
        
        function handleSelectBlur() {
            const monthYearPicker = travelMonthSelect.closest('.month-year-picker');
            if (monthYearPicker) {
                // Remove focused class after a short delay to allow for option selection
                setTimeout(() => {
                    if (monthYearPicker) {
                        monthYearPicker.classList.remove('focused');
                    }
                }, 200);
            }
        }
        
        travelMonthSelect.addEventListener('focus', handleSelectFocus);
        travelMonthSelect.addEventListener('blur', handleSelectBlur);
        travelYearSelect.addEventListener('focus', handleSelectFocus);
        travelYearSelect.addEventListener('blur', handleSelectBlur);
        
        // Initial label position check
        updateLabelPosition();
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
        // Skip while a trip is being pre-selected from ?trip= - the visitor hasn't
        // entered anything yet, and the value is still sent on real form submission.
        if (suppressFieldSave) return;
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
    let suppressFieldSave = false; // true while pre-selecting, so landing on the page doesn't write a draft row
    let preselectApplied = false;  // ?trip= is only ever applied once
    
    // Destination to country code mapping with coordinates
    const destinations = {
        'poland': { countryCode: 'PL', name: 'Poland Trip', lat: 52.2297, lon: 21.0122 },
        'ireland': { countryCode: 'IE', name: 'Ireland Trip', lat: 53.4129, lon: -8.2439 },
        'norway': { countryCode: 'NO', name: 'Norway Trip', lat: 59.9139, lon: 10.7522 },
        'oman': { countryCode: 'OM', name: 'Oman Trip', lat: 23.5859, lon: 58.4059 },
        'scotland': { countryCode: 'GB', name: 'Scotland Trip', lat: 55.9533, lon: -3.1883 },
        'srilanka': { countryCode: 'LK', name: 'Sri Lanka Trip', lat: 7.8731, lon: 80.7718 },
        'uae-oman': { countryCode: 'AE', name: 'UAE & Oman Trip', lat: 24.4539, lon: 54.3773 },
        'ireland-scotland': { countryCode: 'IE', name: 'Ireland & Scotland Trip', lat: 54.5, lon: -5.5 },
        // NOTE: 'russia-artic' and 'russia-luxe' are deliberately absent. Both are the
        // same country (RU), and this map is keyed by country, so adding them makes
        // selecting either trip select both. They stay unhighlighted until the globe
        // can distinguish two trips in one country.
        'mongolia': { countryCode: 'MN', name: 'Mongolia Trip', lat: 46.8625, lon: 103.8467 },
        // Tibet is not a separate country on the map, so it highlights China (CN).
        'tibet': { countryCode: 'CN', name: 'Tibet Trip', lat: 31.6927, lon: 88.7879 },
        'iceland': { countryCode: 'IS', name: 'Iceland Trip', lat: 64.9631, lon: -19.0208 }
    };
    
    // Country code to country name mapping (ISO 3166-1 alpha-2)
    const countryCodeToName = {
        'AD': 'Andorra', 'AE': 'United Arab Emirates', 'AF': 'Afghanistan', 'AG': 'Antigua and Barbuda',
        'AI': 'Anguilla', 'AL': 'Albania', 'AM': 'Armenia', 'AO': 'Angola', 'AQ': 'Antarctica',
        'AR': 'Argentina', 'AS': 'American Samoa', 'AT': 'Austria', 'AU': 'Australia', 'AW': 'Aruba',
        'AX': 'Åland Islands', 'AZ': 'Azerbaijan', 'BA': 'Bosnia and Herzegovina', 'BB': 'Barbados',
        'BD': 'Bangladesh', 'BE': 'Belgium', 'BF': 'Burkina Faso', 'BG': 'Bulgaria', 'BH': 'Bahrain',
        'BI': 'Burundi', 'BJ': 'Benin', 'BL': 'Saint Barthélemy', 'BM': 'Bermuda', 'BN': 'Brunei',
        'BO': 'Bolivia', 'BQ': 'Caribbean Netherlands', 'BR': 'Brazil', 'BS': 'Bahamas', 'BT': 'Bhutan',
        'BV': 'Bouvet Island', 'BW': 'Botswana', 'BY': 'Belarus', 'BZ': 'Belize', 'CA': 'Canada',
        'CC': 'Cocos Islands', 'CD': 'Democratic Republic of the Congo', 'CF': 'Central African Republic',
        'CG': 'Republic of the Congo', 'CH': 'Switzerland', 'CI': 'Côte d\'Ivoire', 'CK': 'Cook Islands',
        'CL': 'Chile', 'CM': 'Cameroon', 'CN': 'China', 'CO': 'Colombia', 'CR': 'Costa Rica',
        'CU': 'Cuba', 'CV': 'Cape Verde', 'CW': 'Curaçao', 'CX': 'Christmas Island', 'CY': 'Cyprus',
        'CZ': 'Czech Republic', 'DE': 'Germany', 'DJ': 'Djibouti', 'DK': 'Denmark', 'DM': 'Dominica',
        'DO': 'Dominican Republic', 'DZ': 'Algeria', 'EC': 'Ecuador', 'EE': 'Estonia', 'EG': 'Egypt',
        'EH': 'Western Sahara', 'ER': 'Eritrea', 'ES': 'Spain', 'ET': 'Ethiopia', 'FI': 'Finland',
        'FJ': 'Fiji', 'FK': 'Falkland Islands', 'FM': 'Micronesia', 'FO': 'Faroe Islands', 'FR': 'France',
        'GA': 'Gabon', 'GB': 'United Kingdom', 'GD': 'Grenada', 'GE': 'Georgia', 'GF': 'French Guiana',
        'GG': 'Guernsey', 'GH': 'Ghana', 'GI': 'Gibraltar', 'GL': 'Greenland', 'GM': 'Gambia',
        'GN': 'Guinea', 'GP': 'Guadeloupe', 'GQ': 'Equatorial Guinea', 'GR': 'Greece', 'GS': 'South Georgia',
        'GT': 'Guatemala', 'GU': 'Guam', 'GW': 'Guinea-Bissau', 'GY': 'Guyana', 'HK': 'Hong Kong',
        'HM': 'Heard Island', 'HN': 'Honduras', 'HR': 'Croatia', 'HT': 'Haiti', 'HU': 'Hungary',
        'ID': 'Indonesia', 'IE': 'Ireland', 'IL': 'Israel', 'IM': 'Isle of Man', 'IN': 'India',
        'IO': 'British Indian Ocean Territory', 'IQ': 'Iraq', 'IR': 'Iran', 'IS': 'Iceland', 'IT': 'Italy',
        'JE': 'Jersey', 'JM': 'Jamaica', 'JO': 'Jordan', 'JP': 'Japan', 'KE': 'Kenya', 'KG': 'Kyrgyzstan',
        'KH': 'Cambodia', 'KI': 'Kiribati', 'KM': 'Comoros', 'KN': 'Saint Kitts and Nevis', 'KP': 'North Korea',
        'KR': 'South Korea', 'KW': 'Kuwait', 'KY': 'Cayman Islands', 'KZ': 'Kazakhstan', 'LA': 'Laos',
        'LB': 'Lebanon', 'LC': 'Saint Lucia', 'LI': 'Liechtenstein', 'LK': 'Sri Lanka', 'LR': 'Liberia',
        'LS': 'Lesotho', 'LT': 'Lithuania', 'LU': 'Luxembourg', 'LV': 'Latvia', 'LY': 'Libya',
        'MA': 'Morocco', 'MC': 'Monaco', 'MD': 'Moldova', 'ME': 'Montenegro', 'MF': 'Saint Martin',
        'MG': 'Madagascar', 'MH': 'Marshall Islands', 'MK': 'North Macedonia', 'ML': 'Mali', 'MM': 'Myanmar',
        'MN': 'Mongolia', 'MO': 'Macao', 'MP': 'Northern Mariana Islands', 'MQ': 'Martinique', 'MR': 'Mauritania',
        'MS': 'Montserrat', 'MT': 'Malta', 'MU': 'Mauritius', 'MV': 'Maldives', 'MW': 'Malawi',
        'MX': 'Mexico', 'MY': 'Malaysia', 'MZ': 'Mozambique', 'NA': 'Namibia', 'NC': 'New Caledonia',
        'NE': 'Niger', 'NF': 'Norfolk Island', 'NG': 'Nigeria', 'NI': 'Nicaragua', 'NL': 'Netherlands',
        'NO': 'Norway', 'NP': 'Nepal', 'NR': 'Nauru', 'NU': 'Niue', 'NZ': 'New Zealand',
        'OM': 'Oman', 'PA': 'Panama', 'PE': 'Peru', 'PF': 'French Polynesia', 'PG': 'Papua New Guinea',
        'PH': 'Philippines', 'PK': 'Pakistan', 'PL': 'Poland', 'PM': 'Saint Pierre and Miquelon',
        'PN': 'Pitcairn', 'PR': 'Puerto Rico', 'PS': 'Palestine', 'PT': 'Portugal', 'PW': 'Palau',
        'PY': 'Paraguay', 'QA': 'Qatar', 'RE': 'Réunion', 'RO': 'Romania', 'RS': 'Serbia',
        'RU': 'Russia', 'RW': 'Rwanda', 'SA': 'Saudi Arabia', 'SB': 'Solomon Islands', 'SC': 'Seychelles',
        'SD': 'Sudan', 'SE': 'Sweden', 'SG': 'Singapore', 'SH': 'Saint Helena', 'SI': 'Slovenia',
        'SJ': 'Svalbard and Jan Mayen', 'SK': 'Slovakia', 'SL': 'Sierra Leone', 'SM': 'San Marino',
        'SN': 'Senegal', 'SO': 'Somalia', 'SR': 'Suriname', 'SS': 'South Sudan', 'ST': 'São Tomé and Príncipe',
        'SV': 'El Salvador', 'SX': 'Sint Maarten', 'SY': 'Syria', 'SZ': 'Eswatini', 'TC': 'Turks and Caicos Islands',
        'TD': 'Chad', 'TF': 'French Southern Territories', 'TG': 'Togo', 'TH': 'Thailand', 'TJ': 'Tajikistan',
        'TK': 'Tokelau', 'TL': 'Timor-Leste', 'TM': 'Turkmenistan', 'TN': 'Tunisia', 'TO': 'Tonga',
        'TR': 'Turkey', 'TT': 'Trinidad and Tobago', 'TV': 'Tuvalu', 'TW': 'Taiwan', 'TZ': 'Tanzania',
        'UA': 'Ukraine', 'UG': 'Uganda', 'UM': 'United States Minor Outlying Islands', 'US': 'United States',
        'UY': 'Uruguay', 'UZ': 'Uzbekistan', 'VA': 'Vatican City', 'VC': 'Saint Vincent and the Grenadines',
        'VE': 'Venezuela', 'VG': 'British Virgin Islands', 'VI': 'United States Virgin Islands', 'VN': 'Vietnam',
        'VU': 'Vanuatu', 'WF': 'Wallis and Futuna', 'WS': 'Samoa', 'YE': 'Yemen', 'YT': 'Mayotte',
        'ZA': 'South Africa', 'ZM': 'Zambia', 'ZW': 'Zimbabwe'
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

        // Create series for background fill FIRST (so it renders behind countries)
        var backgroundSeries = am5map.MapPolygonSeries.new(root, {});
        chart.series.unshift(backgroundSeries);
        backgroundSeries.mapPolygons.template.setAll({
            fill: am5.color("#87CEFA"), // Ocean color
            fillOpacity: 0.8,
            strokeOpacity: 0
        });
        backgroundSeries.data.push({
            geometry: am5map.getGeoRectangle(90, 180, -90, -180)
        });

        // Create main polygon series for countries (after background, so it renders on top)
        polygonSeries = chart.series.push(am5map.MapPolygonSeries.new(root, {
            geoJSON: am4geodata_worldIndiaLow
        }));

        // Configure polygon template
        polygonSeries.mapPolygons.template.setAll({
            tooltipText: "{name}",
            toggleKey: "active",
            interactive: true,
            cursorOverStyle: "pointer",
            fill: am5.color("#50595f"), // Grey for land/countries
            stroke: am5.color("#FF974F"),
            strokeWidth: 1,
            hitDisabled: false
        });

        // Hover State Color (Point 1) - Only applies when not selected
        polygonSeries.mapPolygons.template.states.create("hover", {
            fill: am5.color("#1e3a5f") // Hover color (swapped with ocean)
        });

        // Active/Selected State Color (Point 3)
        polygonSeries.mapPolygons.template.states.create("active", {
            fill: am5.color("#FFB366") // Light orange for selected
        });

        // Removed fill adapter - we'll handle colors directly in datavalidated event
        // This prevents adapter from overriding manual color sets

        polygonSeries.mapPolygons.template.adapters.add("fillOpacity", function(fillOpacity, target) {
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                if (predefinedTrips.includes(countryId)) {
                    return 1.0; // Full opacity for predefined trips (same as selected)
                }
            }
            return fillOpacity;
        });
        
        // Add subtle pulsing animation to predefined trip countries and set up click handlers
        polygonSeries.events.on("datavalidated", function() {
            var polygonCount = 0;
            polygonSeries.mapPolygons.each(function(polygon) {
                polygonCount++;
                var dataItem = polygon.dataItem;
                if (dataItem) {
                    var countryId = dataItem.get("id");
                    // Try multiple possible property names for country name
                    var countryName = dataItem.get("name") || 
                                     dataItem.get("NAME") || 
                                     dataItem.get("NAME_EN") || 
                                     dataItem.get("name_en") ||
                                     dataItem.get("NAME_LONG") ||
                                     dataItem.get("name_long") ||
                                     countryCodeToName[countryId] || // Use mapping if available
                                     countryId;
                    
                    // If still just a code, try to get from dataContext
                    if (countryName === countryId || (countryName.length <= 3 && !countryCodeToName[countryId])) {
                        var dataContext = dataItem.dataContext;
                        if (dataContext) {
                            countryName = dataContext.name || 
                                         dataContext.NAME || 
                                         dataContext.NAME_EN ||
                                         dataContext.name_en ||
                                         countryCodeToName[countryId] ||
                                         countryName;
                        }
                    }
                    
                    // Final fallback to mapping
                    if (countryName === countryId || (countryName.length <= 3 && countryCodeToName[countryId])) {
                        countryName = countryCodeToName[countryId] || countryName;
                    }
                    
                    // Set initial colors based on state (no adapter interference)
                    var isSelected = selectedCountries.some(c => c.code === countryId);
                    if (isSelected) {
                        polygon.set("fill", am5.color("#FFB366")); // Light orange for selected
                        polygon.set("fillOpacity", 0.9);
                        polygon.set("strokeWidth", 2.5);
                    } else if (predefinedTrips.includes(countryId)) {
                        polygon.set("fill", am5.color("#2C4B3B")); // Green for pre-selected
                    } else {
                        polygon.set("fill", am5.color("#50595f")); // Grey for default
                        polygon.set("fillOpacity", 1);
                    }
                    
                    // Set up click handler for each polygon
                    // Only allow interaction when on step 2
                    polygon.events.on("click", function(ev) {
                        // Prevent interaction if not on step 2
                        if (currentStep !== 2) {
                            if (ev.originalEvent) {
                                ev.originalEvent.stopPropagation();
                                ev.originalEvent.preventDefault();
                            }
                            return false;
                        }
                        
                        console.log('Polygon clicked - Country:', countryId, countryName);
                        if (ev.originalEvent) {
                            ev.originalEvent.stopPropagation();
                            ev.originalEvent.preventDefault();
                        }
                        toggleCountrySelection(countryId, countryName, polygon);
                        return false;
                    });
                    
                    // Also handle pointertap as backup
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
                    
                    // Add pulsing animation for predefined trips
                    if (predefinedTrips.includes(countryId)) {
                        // Removed pulsing opacity - pre-selected countries now have full opacity
                        
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
            console.log('Set up click handlers for ' + polygonCount + ' polygons');
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
        // Filter out entries with invalid coordinates (0, 0 or null/undefined) and exclude ireland-scotland
        var pointData = Object.entries(destinations)
            .filter(([key, dest]) => {
                // Exclude ireland-scotland from markers
                if (key === 'ireland-scotland') return false;
                // Exclude entries with (0, 0) coordinates or missing coordinates
                return dest && 
                       dest.lat !== null && 
                       dest.lat !== undefined && 
                       dest.lon !== null && 
                       dest.lon !== undefined &&
                       !(dest.lat === 0 && dest.lon === 0);
            })
            .map(([key, dest]) => ({
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

        // Set up events for hover - manually set hover color (no adapter)
        polygonSeries.mapPolygons.template.on("pointerover", function(ev) {
            var target = ev.target;
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                // Only show hover color if not a selected country
                var isSelected = selectedCountries.some(c => c.code === countryId);
                if (!isSelected) {
                    // Directly set fill - no adapter to interfere
                    target.set("fill", am5.color("#1e3a5f")); // Hover color (swapped with ocean)
                }
                // If selected, keep selected color (green)
            }
        });

        polygonSeries.mapPolygons.template.on("pointerout", function(ev) {
            var target = ev.target;
            var dataItem = target.dataItem;
            if (dataItem) {
                var countryId = dataItem.get("id");
                // Restore appropriate color based on state (no adapter)
                var isSelected = selectedCountries.some(c => c.code === countryId);
                if (isSelected) {
                    target.set("fill", am5.color("#FFB366")); // Light orange for selected
                    target.set("fillOpacity", 0.9);
                } else if (predefinedTrips.includes(countryId)) {
                    target.set("fill", am5.color("#2C4B3B")); // Green for pre-selected
                } else {
                    target.set("fill", am5.color("#50595f")); // Grey for land
                    target.set("fillOpacity", 1);
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
        console.log('=== toggleCountrySelection CALLED ===');
        console.log('Country ID:', countryId);
        console.log('Country Name:', countryName);
        
        try {
            // Ensure countryName is valid - use mapping or countryId as fallback if name is missing
            if (!countryName || countryName.trim() === '') {
                countryName = countryCodeToName[countryId] || countryId;
                console.warn('Country name was empty, using mapping or countryId:', countryId, '->', countryName);
            }
            
            // If countryName is still just a code (2-3 characters), try to get from mapping
            if (countryName === countryId || (countryName.length <= 3 && countryCodeToName[countryId])) {
                countryName = countryCodeToName[countryId] || countryName;
            }
            
            // Check if country is already selected
            var index = selectedCountries.findIndex(c => c.code === countryId);
            
            // Also check if it's a non-predefined country in the textarea
            const customCountriesField = document.getElementById('customCountries');
            let isInTextarea = false;
            if (customCountriesField && customCountriesField.value.trim() && !predefinedTrips.includes(countryId)) {
                const currentCountries = customCountriesField.value.split(',').map(c => c.trim()).filter(c => c);
                const countryNameLower = countryName.toLowerCase();
                isInTextarea = currentCountries.some(c => c.toLowerCase() === countryNameLower);
            }
            
            console.log('Index in selectedCountries:', index);
            console.log('Is in textarea:', isInTextarea);
            console.log('Is predefined trip:', predefinedTrips.includes(countryId));
            
            if (index > -1 || isInTextarea) {
            // Deselect - remove from array if it exists there
            if (index > -1) {
                selectedCountries.splice(index, 1);
            }
            delete selectedCountryPolygons[countryId];
            console.log('Country deselected:', countryId);
            
            // Check if it's a predefined trip or custom country
            const isPredefinedTrip = predefinedTrips.includes(countryId);
            
            if (isPredefinedTrip) {
                // Unselect all dropdown options for this country
                const matchingDropdownValues = countryCodeToDropdownValues[countryId] || [];
                matchingDropdownValues.forEach(val => {
                    const option = document.querySelector(`.dropdown-option[data-value="${val}"]`);
                    if (option) {
                        option.classList.remove('selected');
                        // Remove from selectedTrips
                        const tripIndex = selectedTrips.indexOf(val);
                        if (tripIndex > -1) {
                            selectedTrips.splice(tripIndex, 1);
                        }
                    }
                });
                
                // Update polygon color - directly set fill (no adapter)
                polygon.set("fill", am5.color("#2C4B3B")); // Green for pre-selected
                
                // Save trip type
                const selectedTripValues = Array.from(document.querySelectorAll('.dropdown-option.selected')).map(opt => opt.getAttribute('data-value'));
                saveField('tripType', JSON.stringify(selectedTripValues));
            } else {
                // If country was in "Other" textarea, remove it
                // Update polygon color first
                polygon.set("fill", am5.color("#50595f")); // Grey for land
                polygon.set("fillOpacity", 1);
                polygon.set("strokeWidth", 1);
                
                const customCountriesField = document.getElementById('customCountries');
                if (customCountriesField && customCountriesField.value.trim()) {
                    let currentCountries = customCountriesField.value.split(',').map(c => c.trim()).filter(c => c);
                    const countryNameLower = countryName.toLowerCase();
                    currentCountries = currentCountries.filter(c => c.toLowerCase() !== countryNameLower);
                    
                    if (currentCountries.length > 0) {
                        customCountriesField.value = currentCountries.join(', ');
                        customCountriesField.classList.add('has-value');
                        saveField('customCountries', customCountriesField.value.trim());
                    } else {
                        customCountriesField.value = '';
                        customCountriesField.classList.remove('has-value');
                        saveField('customCountries', '');
                        
                        // Unselect "Other" option if no more custom countries
                        const otherOption = document.querySelector('.dropdown-option[data-value="other"]');
                        if (otherOption) {
                            otherOption.classList.remove('selected');
                            const otherIndex = selectedTrips.indexOf('other');
                            if (otherIndex > -1) {
                                selectedTrips.splice(otherIndex, 1);
                            }
                            
                            // Update dropdown state
                            const customDropdown = document.getElementById('customDropdown');
                            const dropdownWrapper = customDropdown ? customDropdown.closest('.custom-dropdown-wrapper') : null;
                            if (dropdownWrapper) {
                                customDropdown.classList.remove('has-value');
                                dropdownWrapper.classList.remove('has-value');
                            }
                            
                            // Save trip type
                            const selectedTripValues = Array.from(document.querySelectorAll('.dropdown-option.selected')).map(opt => opt.getAttribute('data-value'));
                            saveField('tripType', JSON.stringify(selectedTripValues));
                        }
                        
                        // Hide custom countries input if empty
                        const customCountriesInput = document.getElementById('customCountriesInput');
                        if (customCountriesInput) {
                            customCountriesInput.style.display = 'none';
                        }
                    }
                }
            }
        } else {
            // Select - add to array with proper name
            selectedCountries.push({ code: countryId, name: countryName });
            selectedCountryPolygons[countryId] = polygon;
            console.log('Country selected from globe:', countryId, countryName);
            console.log('Selected countries after push:', selectedCountries);
            
            // Update polygon color - directly set fill (no adapter)
            polygon.set("fill", am5.color("#FFB366")); // Light orange for selected
            polygon.set("fillOpacity", 0.9);
            polygon.set("strokeWidth", 2.5);
            
            // Check if country is in predefined trips
            const isPredefinedTrip = predefinedTrips.includes(countryId);
            
            if (isPredefinedTrip) {
                console.log('Country is predefined trip, selecting dropdown options');
                // Select all dropdown options for this country (predefined trip)
                const matchingDropdownValues = countryCodeToDropdownValues[countryId] || [];
                console.log('Country ID:', countryId, 'Matching dropdown values:', matchingDropdownValues);
                
                if (matchingDropdownValues.length === 0) {
                    console.warn('No dropdown values found for country:', countryId);
                    return;
                }
                
                // Select each matching dropdown option
                matchingDropdownValues.forEach(val => {
                    const option = document.querySelector(`.dropdown-option[data-value="${val}"]`);
                    console.log('Looking for option with value:', val, 'Found:', !!option);
                    
                    if (option && !option.classList.contains('selected')) {
                        console.log('Selecting dropdown option:', val);
                        
                        // Manually perform all the dropdown selection logic
                        const isOther = val === 'other';
                        
                        // Add selected class
                        option.classList.add('selected');
                        
                        // Handle mutual exclusivity for Ireland/Scotland/Ireland & Scotland
                        if (val === 'ireland-scotland') {
                            const irelandOption = document.querySelector('.dropdown-option[data-value="ireland"]');
                            const scotlandOption = document.querySelector('.dropdown-option[data-value="scotland"]');
                            if (irelandOption && irelandOption.classList.contains('selected')) {
                                irelandOption.classList.remove('selected');
                                const irelandIndex = selectedTrips.indexOf('ireland');
                                if (irelandIndex > -1) {
                                    selectedTrips.splice(irelandIndex, 1);
                                    updateMapMarker('ireland');
                                }
                            }
                            if (scotlandOption && scotlandOption.classList.contains('selected')) {
                                scotlandOption.classList.remove('selected');
                                const scotlandIndex = selectedTrips.indexOf('scotland');
                                if (scotlandIndex > -1) {
                                    selectedTrips.splice(scotlandIndex, 1);
                                    updateMapMarker('scotland');
                                }
                            }
                        } else if (val === 'ireland' || val === 'scotland') {
                            const irelandScotlandOption = document.querySelector('.dropdown-option[data-value="ireland-scotland"]');
                            if (irelandScotlandOption && irelandScotlandOption.classList.contains('selected')) {
                                irelandScotlandOption.classList.remove('selected');
                                const irelandScotlandIndex = selectedTrips.indexOf('ireland-scotland');
                                if (irelandScotlandIndex > -1) {
                                    selectedTrips.splice(irelandScotlandIndex, 1);
                                    updateMapMarker('ireland-scotland');
                                }
                            }
                        }
                        
                        // Add to selectedTrips
                        if (selectedTrips.indexOf(val) === -1) {
                            selectedTrips.push(val);
                        }
                        
                        // Update dropdown display and state
                        updateDropdownDisplay();
                        const customDropdown = document.getElementById('customDropdown');
                        const dropdownWrapper = customDropdown ? customDropdown.closest('.custom-dropdown-wrapper') : null;
                        if (dropdownWrapper) {
                            customDropdown.classList.add('has-value');
                            dropdownWrapper.classList.add('has-value');
                        }
                        
                        // Save trip type
                        const selectedOptions = document.querySelectorAll('.dropdown-option.selected');
                        const selectedTripValues = Array.from(selectedOptions).map(opt => opt.getAttribute('data-value'));
                        saveField('tripType', JSON.stringify(selectedTripValues));
                        
                        console.log('Dropdown option selected successfully:', val);
                    } else if (option && option.classList.contains('selected')) {
                        console.log('Option already selected:', val);
                    } else {
                        console.warn('Dropdown option not found for value:', val);
                    }
                });
            } else {
                console.log('=== NON-PREDEFINED COUNTRY PATH ===');
                console.log('Country is NOT predefined trip, adding to Other textarea');
                console.log('Country ID:', countryId, 'Country Name:', countryName);
                
                // If country is NOT in predefined trips, add it to "Other" textarea
                // Remove from selectedCountries to avoid duplicate display (it will show from textarea)
                const countryIndex = selectedCountries.findIndex(c => c.code === countryId);
                if (countryIndex > -1) {
                    selectedCountries.splice(countryIndex, 1);
                    console.warn('Removed from selectedCountries array');
                }
                const customCountriesField = document.getElementById('customCountries');
                const otherOption = document.querySelector('.dropdown-option[data-value="other"]');
                
                console.log('customCountriesField found:', !!customCountriesField);
                console.log('otherOption found:', !!otherOption);
                
                if (!customCountriesField) {
                    console.error('ERROR: customCountriesField is NULL!');
                    return;
                }
                if (!otherOption) {
                    console.error('ERROR: otherOption is NULL!');
                    return;
                }
                
                if (customCountriesField) {
                    // Get current countries from textarea
                    let currentCountries = [];
                    if (customCountriesField.value.trim()) {
                        currentCountries = customCountriesField.value.split(',').map(c => c.trim()).filter(c => c);
                    }
                    
                    // Check if country name is already in the list (case-insensitive)
                    const countryNameLower = countryName.toLowerCase();
                    const isAlreadyAdded = currentCountries.some(c => c.toLowerCase() === countryNameLower);
                    
                    if (!isAlreadyAdded) {
                        console.log('Adding country to textarea:', countryName);
                        
                        // Select "Other" option in dropdown if not already selected
                        if (!otherOption.classList.contains('selected')) {
                            console.log('Selecting Other option');
                            
                            // Manually perform all the dropdown selection logic
                            otherOption.classList.add('selected');
                            
                            // Add to selectedTrips
                            if (selectedTrips.indexOf('other') === -1) {
                                selectedTrips.push('other');
                            }
                            
                            // Show custom countries input
                            const customCountriesInput = document.getElementById('customCountriesInput');
                            if (customCountriesInput) {
                                customCountriesInput.style.display = 'block';
                            }
                            
                            // Update dropdown display and state
                            updateDropdownDisplay();
                            
                            const customDropdown = document.getElementById('customDropdown');
                            const dropdownWrapper = customDropdown ? customDropdown.closest('.custom-dropdown-wrapper') : null;
                            if (dropdownWrapper) {
                                customDropdown.classList.add('has-value');
                                dropdownWrapper.classList.add('has-value');
                            }
                            
                            // Save trip type
                            const selectedOptions = document.querySelectorAll('.dropdown-option.selected');
                            const selectedTripValues = Array.from(selectedOptions).map(opt => opt.getAttribute('data-value'));
                            saveField('tripType', JSON.stringify(selectedTripValues));
                        }
                        
                        // Add the country name to the textarea
                        const currentValue = customCountriesField.value.trim();
                        const updatedCountries = currentValue ? currentValue.split(',').map(c => c.trim()).filter(c => c) : [];
                        const countryNameLower = countryName.toLowerCase();
                        const stillExists = updatedCountries.some(c => c.toLowerCase() === countryNameLower);
                        
                        if (!stillExists) {
                            updatedCountries.push(countryName);
                            customCountriesField.value = updatedCountries.join(', ');
                            customCountriesField.classList.add('has-value');
                            console.log('Textarea value set to:', customCountriesField.value);
                            
                            // Save the field
                            saveField('customCountries', customCountriesField.value.trim());
                        }
                    }
                } else {
                    console.error('customCountriesField not found!');
                }
            }
        }
        
        console.log('Calling updateStep2SelectedCountries');
        // Update step 2 with selected countries (even if on step 1, so it's ready when user goes to step 2)
        updateStep2SelectedCountries();
        
        console.log('Calling updateDropdownDisplay');
        // Update dropdown display
        updateDropdownDisplay();
        
        // Debug logging
        console.log('Country selection updated. Total selected:', selectedCountries.length);
        console.log('Selected countries:', selectedCountries);
        
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
        } catch (error) {
            console.error('Error in toggleCountrySelection:', error);
            alert('Error selecting country: ' + error.message);
        }
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
        
        // Filter out "other" from the count - it should not be counted as a trip
        const validSelectedOptions = Array.from(selectedOptions).filter(option => {
            const value = option.getAttribute('data-value');
            return value && value.toLowerCase() !== 'other';
        });
        
        // Check if "Other" is selected
        const otherOption = document.querySelector('.dropdown-option[data-value="other"]');
        const isOtherSelected = otherOption && otherOption.classList.contains('selected');
        
        if (validSelectedOptions.length === 0 && !isOtherSelected) {
            dropdownPlaceholder.style.display = 'block';
        } else if (validSelectedOptions.length === 0 && isOtherSelected) {
            // Only "Other" is selected
            dropdownPlaceholder.style.display = 'none';
        } else if (validSelectedOptions.length === 1) {
            dropdownPlaceholder.style.display = 'none';
        } else {
            dropdownPlaceholder.style.display = 'none';
        }
    }

    // Function to select and zoom to a country
    function selectCountry(id) {
        var dataItem = polygonSeries.getDataItemById(id);
        var target = dataItem.get("mapPolygon");
        if (target) {
            var centroid = target.geoCentroid();
            if (centroid) {
                // Rotate to center the country
                chart.animate({ key: "rotationX", to: -centroid.longitude, duration: 1500, easing: am5.ease.inOut(am5.ease.cubic) });
                chart.animate({ key: "rotationY", to: -centroid.latitude, duration: 1500, easing: am5.ease.inOut(am5.ease.cubic) });
            }

            // Use very minimal zoom (0.05 = 5% zoom) or no zoom at all to keep half globe visible
            // Commented out zoom to just rotate without zooming
            // setTimeout(function () {
            //     polygonSeries.zoomToDataItem(dataItem, 0.05);
            // }, 1500);
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
    // Pre-select a trip when arriving from a destination page, e.g. /contact-us?trip=ireland
    function applyPreselectedTrip() {
        if (preselectApplied) return;
        preselectApplied = true;

        let requested = null;
        try {
            requested = new URLSearchParams(window.location.search).get('trip');
        } catch (e) {
            return;
        }
        // Slugs are lowercase/hyphen only; anything else is ignored rather than
        // interpolated into a selector.
        if (!requested || !/^[a-z-]+$/.test(requested)) return;

        const option = document.querySelector('.dropdown-option[data-value="' + requested + '"]');
        if (!option || option.classList.contains('selected')) return;

        // Reuse the normal click flow so the globe highlight, the chips and the
        // dropdown label all stay in sync with a manual selection.
        suppressFieldSave = true;
        try {
            option.click();
        } finally {
            suppressFieldSave = false;
        }
    }

    function updateMapMarker(tripValue) {
        // Get destination data
        const destination = destinations[tripValue];
        // Skip if destination doesn't exist, has invalid coordinates, or is "other"
        if (!destination || !chart || tripValue === 'other') return;
        // Skip if coordinates are (0, 0) or invalid
        if ((destination.lat === 0 && destination.lon === 0) || 
            destination.lat === null || 
            destination.lat === undefined || 
            destination.lon === null || 
            destination.lon === undefined) return;

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
        
        // Special handling for "ireland-scotland" - treat as single combined trip
        if (tripValue === 'ireland-scotland') {
            // For ireland-scotland, we need to handle both IE and GB countries
            // But only add them if the combined trip is selected
            const ieDataItem = polygonSeries.getDataItemById('IE');
            const gbDataItem = polygonSeries.getDataItemById('GB');
            
            if (isOptionSelected) {
                // Add both countries but mark them as part of combined trip
                if (ieDataItem) {
                    const iePolygon = ieDataItem.get("mapPolygon");
                    const ieName = ieDataItem.get("name") || 'Ireland';
                    if (!selectedCountries.some(c => c.code === 'IE')) {
                        selectedCountries.push({ code: 'IE', name: ieName, isCombined: true });
                        selectedCountryPolygons['IE'] = iePolygon;
                        iePolygon.set("fill", am5.color("#FFB366"));
                        iePolygon.set("fillOpacity", 0.9);
                        iePolygon.set("strokeWidth", 2.5);
                    }
                }
                if (gbDataItem) {
                    const gbPolygon = gbDataItem.get("mapPolygon");
                    const gbName = gbDataItem.get("name") || 'Scotland';
                    if (!selectedCountries.some(c => c.code === 'GB')) {
                        selectedCountries.push({ code: 'GB', name: gbName, isCombined: true });
                        selectedCountryPolygons['GB'] = gbPolygon;
                        gbPolygon.set("fill", am5.color("#FFB366"));
                        gbPolygon.set("fillOpacity", 0.9);
                        gbPolygon.set("strokeWidth", 2.5);
                    }
                }
            } else {
                // Remove both countries only if no other trip uses them
                const hasIrelandTrip = selectedTrips.some(trip => {
                    const tripDest = destinations[trip];
                    return tripDest && tripDest.countryCode === 'IE' && trip !== 'ireland-scotland';
                });
                const hasScotlandTrip = selectedTrips.some(trip => {
                    const tripDest = destinations[trip];
                    return tripDest && tripDest.countryCode === 'GB' && trip !== 'ireland-scotland';
                });
                
                if (!hasIrelandTrip && ieDataItem) {
                    const ieIndex = selectedCountries.findIndex(c => c.code === 'IE');
                    if (ieIndex > -1) {
                        selectedCountries.splice(ieIndex, 1);
                        delete selectedCountryPolygons['IE'];
                        const iePolygon = ieDataItem.get("mapPolygon");
                        if (predefinedTrips.includes('IE')) {
                            iePolygon.set("fill", am5.color("#2C4B3B"));
                            // iePolygon.set("fillOpacity", 0.6);
                        } else {
                            iePolygon.set("fill", am5.color("#50595f")); // Grey for land
                            iePolygon.set("fillOpacity", 1);
                        }
                        iePolygon.set("strokeWidth", 1);
                    }
                }
                
                if (!hasScotlandTrip && gbDataItem) {
                    const gbIndex = selectedCountries.findIndex(c => c.code === 'GB');
                    if (gbIndex > -1) {
                        selectedCountries.splice(gbIndex, 1);
                        delete selectedCountryPolygons['GB'];
                        const gbPolygon = gbDataItem.get("mapPolygon");
                        if (predefinedTrips.includes('GB')) {
                            gbPolygon.set("fill", am5.color("#2C4B3B"));
                        } else {
                            gbPolygon.set("fill", am5.color("#50595f")); // Grey for land
                            gbPolygon.set("fillOpacity", 1);
                        }
                        gbPolygon.set("strokeWidth", 1);
                    }
                }
            }
        } else {
            // Regular trip handling (non-combined trips)
            var dataItem = polygonSeries.getDataItemById(destination.countryCode);
            if (dataItem) {
                var polygon = dataItem.get("mapPolygon");
                // Use the country name from the dataItem if available, otherwise use destination name
                var countryName = dataItem.get("name") || destination.name;
                
                // Check if country is already selected on globe
                var isCountrySelected = selectedCountries.some(c => c.code === destination.countryCode);
                
                // Check if any trip with this country code is selected (excluding ireland-scotland for IE/GB)
                const hasAnyTripSelected = selectedTrips.some(trip => {
                    // Skip ireland-scotland when checking for individual country trips
                    if (trip === 'ireland-scotland') return false;
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
        
        // Update display after changes
        updateStep2SelectedCountries();
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
        
        // Count trips from dropdown (excluding "other")
        // Filter out "other" explicitly - it should not count as a trip
        // Also filter out any null/undefined/empty values
        const validTrips = selectedTrips.filter(trip => {
            if (!trip || typeof trip !== 'string') return false;
            const trimmedTrip = trip.trim().toLowerCase();
            // Explicitly exclude "other" - it should never count as a trip
            if (trimmedTrip === 'other') return false;
            return trimmedTrip !== '';
        });
        const tripCount = validTrips.length;
        
        // Debug: Log to ensure "other" is not counted
        if (selectedTrips.includes('other')) {
            console.log('"other" is in selectedTrips but will not be counted. Valid trips count:', tripCount);
        }
        
        // Count custom countries from textarea (comma-separated)
        // Each comma-separated country counts as 1 country
        const customCount = customCountries.length;
        
        // Total count = trips + custom countries (excluding "other")
        const totalCount = tripCount + customCount;
        
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
        // Count: trips from dropdown + custom countries from textarea
        let countText = '';
        if (tripCount > 0 && customCount > 0) {
            // Both trips and custom countries
            countText = `Total: ${totalCount} selected (${tripCount} ${tripCount === 1 ? 'trip' : 'trips'} + ${customCount} ${customCount === 1 ? 'country' : 'countries'})`;
        } else if (tripCount > 0) {
            // Only trips
            countText = `Total: ${tripCount} ${tripCount === 1 ? 'trip' : 'trips'} selected`;
        } else if (customCount > 0) {
            // Only custom countries
            countText = `Total: ${customCount} ${customCount === 1 ? 'country' : 'countries'} selected`;
        }
        
        let html = `<div class="selected-countries-header"><p class="countries-count">${countText}</p></div>`;
        html += '<div class="selected-countries-list">';
        
        // Display trips from dropdown (not individual countries)
        // This ensures "ireland-scotland" shows as 1 trip, not 2 separate countries
        // Use the same mapping as in generateTripLinks function
        const tripDisplayNames = {
            'poland': 'Poland',
            'ireland': 'Ireland',
            'norway': 'Norway',
            'oman': 'Oman',
            'scotland': 'Scotland',
            'srilanka': 'Sri Lanka',
            'uae-oman': 'UAE & Oman',
            'ireland-scotland': 'Ireland & Scotland',
            'russia-artic': 'Russia Arctic',
            'russia-luxe': 'Russia Luxe',
            'mongolia': 'Mongolia',
            'tibet': 'Tibet',
            'iceland': 'Iceland'
        };
        
        // Display selected trips (excluding "other")
        // Ensure no duplicates - use Set to track displayed trips
        const displayedTrips = new Set();
        selectedTrips.filter(trip => trip !== 'other').forEach(tripValue => {
            // Skip if already displayed (shouldn't happen, but safety check)
            if (displayedTrips.has(tripValue)) return;
            displayedTrips.add(tripValue);
            
            const tripName = tripDisplayNames[tripValue] || tripValue;
            html += `
                <div class="selected-country-item" data-trip="${tripValue}">
                    <span class="country-name">${tripName}</span>
                    <button type="button" class="remove-trip" data-trip="${tripValue}" aria-label="Remove ${tripName}">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            `;
        });
        
        // Display countries selected directly from globe (not from dropdown trips)
        // Only show countries that are not part of any selected trip
        selectedCountries.forEach((country, index) => {
            // Check if this country is part of any selected trip
            const isPartOfTrip = selectedTrips.some(trip => {
                const tripDest = destinations[trip];
                return tripDest && tripDest.countryCode === country.code;
            });
            
            // Only display if it's not part of a trip (i.e., selected directly from globe)
            if (!isPartOfTrip) {
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
            }
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
        
        // Add event listeners for remove buttons (trips from dropdown)
        selectedCountriesContainer.querySelectorAll('.remove-trip').forEach(btn => {
            btn.addEventListener('click', function() {
                const tripValue = this.getAttribute('data-trip');
                // Find the dropdown option and unselect it
                const option = document.querySelector(`.dropdown-option[data-value="${tripValue}"]`);
                if (option) {
                    option.classList.remove('selected');
                    // Trigger the update map marker to handle deselection
                    updateMapMarker(tripValue);
                    // Update dropdown display
                    updateDropdownDisplay();
                }
            });
        });
        
        // Add event listeners for remove buttons (globe-selected countries, not part of trips)
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
                // Ensure display is updated when showing step 2
                updateStep2SelectedCountries();
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
            
        // Handle mutual exclusivity for Ireland/Scotland/Ireland & Scotland
        // These three options should be mutually exclusive
        if (isNowSelected) {
            if (value === 'ireland-scotland') {
                // If selecting "ireland-scotland", deselect "ireland" and "scotland"
                const irelandOption = document.querySelector('.dropdown-option[data-value="ireland"]');
                const scotlandOption = document.querySelector('.dropdown-option[data-value="scotland"]');
                if (irelandOption && irelandOption.classList.contains('selected')) {
                    irelandOption.classList.remove('selected');
                    const irelandIndex = selectedTrips.indexOf('ireland');
                    if (irelandIndex > -1) {
                        selectedTrips.splice(irelandIndex, 1);
                        updateMapMarker('ireland');
                    }
                }
                if (scotlandOption && scotlandOption.classList.contains('selected')) {
                    scotlandOption.classList.remove('selected');
                    const scotlandIndex = selectedTrips.indexOf('scotland');
                    if (scotlandIndex > -1) {
                        selectedTrips.splice(scotlandIndex, 1);
                        updateMapMarker('scotland');
                    }
                }
            } else if (value === 'ireland' || value === 'scotland') {
                // If selecting "ireland" or "scotland", deselect "ireland-scotland"
                const irelandScotlandOption = document.querySelector('.dropdown-option[data-value="ireland-scotland"]');
                if (irelandScotlandOption && irelandScotlandOption.classList.contains('selected')) {
                    irelandScotlandOption.classList.remove('selected');
                    const irelandScotlandIndex = selectedTrips.indexOf('ireland-scotland');
                    if (irelandScotlandIndex > -1) {
                        selectedTrips.splice(irelandScotlandIndex, 1);
                        updateMapMarker('ireland-scotland');
                    }
                }
            }
        }
        
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
    const inputs = enquiryForm.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], textarea, #customCountries');
    
    // Handle month/year selects separately
    const monthYearSelects = enquiryForm.querySelectorAll('#travelMonth, #travelYear');
    
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
                
                // Clean phone number for storage (remove formatting, but keep country code)
                if (fieldName === 'phone') {
                    const phoneCountryCodeSelect = document.getElementById('phoneCountryCode');
                    const phoneCountryCode = phoneCountryCodeSelect ? phoneCountryCodeSelect.value : '+91';
                    const phoneNumber = fieldValue.replace(/\D/g, '');
                    fieldValue = phoneCountryCode + phoneNumber;
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
    const phoneCountryCode = document.getElementById('phoneCountryCode');
    const phoneInputGroup = phoneInput ? phoneInput.closest('.phone-input-group') : null;

    // Subscriber-number length range per country dial code.
    // Anything not listed falls back to ITU E.164: total ≤ 15 digits including the dial code.
    const PHONE_LENGTH_BY_CODE = {
        '+1':   { min: 10, max: 10 },  // USA/Canada
        '+7':   { min: 10, max: 10 },  // Russia/Kazakhstan
        '+20':  { min: 10, max: 10 },  // Egypt
        '+27':  { min: 9,  max: 9  },  // South Africa
        '+30':  { min: 10, max: 10 },  // Greece
        '+31':  { min: 9,  max: 9  },  // Netherlands
        '+32':  { min: 8,  max: 9  },  // Belgium
        '+33':  { min: 9,  max: 9  },  // France
        '+34':  { min: 9,  max: 9  },  // Spain
        '+39':  { min: 9,  max: 11 },  // Italy
        '+40':  { min: 9,  max: 9  },  // Romania
        '+41':  { min: 9,  max: 9  },  // Switzerland
        '+43':  { min: 10, max: 13 },  // Austria
        '+44':  { min: 10, max: 10 },  // UK
        '+45':  { min: 8,  max: 8  },  // Denmark
        '+46':  { min: 7,  max: 9  },  // Sweden
        '+47':  { min: 8,  max: 8  },  // Norway
        '+48':  { min: 9,  max: 9  },  // Poland
        '+49':  { min: 10, max: 12 },  // Germany
        '+52':  { min: 10, max: 10 },  // Mexico
        '+55':  { min: 10, max: 11 },  // Brazil
        '+60':  { min: 9,  max: 10 },  // Malaysia
        '+61':  { min: 9,  max: 9  },  // Australia
        '+62':  { min: 9,  max: 12 },  // Indonesia
        '+63':  { min: 10, max: 10 },  // Philippines
        '+64':  { min: 8,  max: 10 },  // New Zealand
        '+65':  { min: 8,  max: 8  },  // Singapore
        '+66':  { min: 9,  max: 9  },  // Thailand
        '+81':  { min: 10, max: 10 },  // Japan
        '+82':  { min: 9,  max: 10 },  // South Korea
        '+84':  { min: 9,  max: 10 },  // Vietnam
        '+86':  { min: 11, max: 11 },  // China
        '+90':  { min: 10, max: 10 },  // Turkey
        '+91':  { min: 10, max: 10 },  // India
        '+92':  { min: 10, max: 10 },  // Pakistan
        '+94':  { min: 9,  max: 9  },  // Sri Lanka
        '+95':  { min: 8,  max: 10 },  // Myanmar
        '+212': { min: 9,  max: 9  },  // Morocco
        '+351': { min: 9,  max: 9  },  // Portugal
        '+353': { min: 9,  max: 9  },  // Ireland
        '+358': { min: 9,  max: 10 },  // Finland
        '+852': { min: 8,  max: 8  },  // Hong Kong
        '+853': { min: 8,  max: 8  },  // Macau
        '+880': { min: 10, max: 10 },  // Bangladesh
        '+886': { min: 9,  max: 9  },  // Taiwan
        '+966': { min: 9,  max: 9  },  // Saudi Arabia
        '+971': { min: 9,  max: 9  },  // UAE
        '+977': { min: 10, max: 10 }   // Nepal
    };

    function getPhoneLengthRange() {
        const code = phoneCountryCode ? phoneCountryCode.value : '+91';
        if (PHONE_LENGTH_BY_CODE[code]) return PHONE_LENGTH_BY_CODE[code];
        // E.164 fallback: total digits (incl. country code) max 15, min 4 subscriber digits
        const codeDigits = code.replace(/\D/g, '').length;
        return { min: 4, max: Math.max(4, 15 - codeDigits) };
    }

    function formatPhoneDisplay(digits, range) {
        if (!digits.length) return '';
        // Single-dash split keeps it readable across variable lengths
        if (digits.length <= 5) return digits;
        const splitAt = range.max <= 8 ? 4 : 5;
        return `${digits.slice(0, splitAt)}-${digits.slice(splitAt)}`;
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            const range = getPhoneLengthRange();
            let digits = e.target.value.replace(/\D/g, '');
            if (digits.length > range.max) {
                digits = digits.slice(0, range.max);
            }
            const formatted = formatPhoneDisplay(digits, range);
            e.target.value = formatted;

            // Update has-value class
            if (formatted.length > 0 && phoneInputGroup) {
                phoneInputGroup.classList.add('has-value');
            } else if (phoneInputGroup) {
                phoneInputGroup.classList.remove('has-value');
            }
        });
        
        // Handle focus/blur for label styling
        phoneInput.addEventListener('focus', function() {
            if (phoneInputGroup) {
                phoneInputGroup.classList.add('focused');
            }
        });
        
        phoneInput.addEventListener('blur', function() {
            if (phoneInputGroup) {
                phoneInputGroup.classList.remove('focused');
            }
        });
    }
    
    if (phoneCountryCode) {
        phoneCountryCode.addEventListener('change', function() {
            // Re-truncate/reformat existing input against the newly selected country's range
            if (phoneInput && phoneInput.value.trim()) {
                const range = getPhoneLengthRange();
                let digits = phoneInput.value.replace(/\D/g, '');
                if (digits.length > range.max) digits = digits.slice(0, range.max);
                phoneInput.value = formatPhoneDisplay(digits, range);
                if (phoneInputGroup) phoneInputGroup.classList.add('has-value');
            }
        });
        
        phoneCountryCode.addEventListener('focus', function() {
            if (phoneInputGroup) {
                phoneInputGroup.classList.add('focused');
            }
        });
        
        phoneCountryCode.addEventListener('blur', function() {
            if (phoneInputGroup) {
                phoneInputGroup.classList.remove('focused');
            }
        });
    }

    // Searchable country-code picker — overlays the native <select> while keeping its value
    // authoritative, so existing reads of phoneCountryCode.value and the change listener above
    // continue to work unchanged.
    (function initCountryCodePicker() {
        const select = document.getElementById('phoneCountryCode');
        if (!select || !select.parentElement) return;

        const wrapper = select.parentElement; // .phone-input-wrapper

        // Parse "+91 (India)" → { code: "+91", name: "India" }; dedupe by value.
        const seen = new Set();
        const countries = [];
        Array.from(select.options).forEach(opt => {
            if (seen.has(opt.value)) return;
            seen.add(opt.value);
            const m = opt.textContent.match(/^\s*(\+\d+)\s*\(([^)]+)\)/);
            countries.push({
                value: opt.value,
                code: m ? m[1] : opt.value,
                name: m ? m[2].trim() : opt.textContent.trim()
            });
        });

        const picker = document.createElement('div');
        picker.className = 'country-code-picker';
        picker.innerHTML = `
            <button type="button" class="country-code-trigger" aria-haspopup="listbox" aria-expanded="false">
                <span class="trigger-code"></span>
                <svg class="trigger-caret" viewBox="0 0 12 12" width="10" height="10" aria-hidden="true">
                    <path fill="currentColor" d="M6 9L1 4h10z"/>
                </svg>
            </button>
            <div class="country-code-panel" role="listbox">
                <input type="text" class="country-code-search" placeholder="Search country or code…" aria-label="Search countries" autocomplete="off" />
                <div class="country-code-list"></div>
                <p class="country-code-empty" hidden>No matches</p>
            </div>
        `;
        wrapper.insertBefore(picker, select);
        select.classList.add('is-enhanced');
        select.tabIndex = -1;

        const trigger = picker.querySelector('.country-code-trigger');
        const triggerCode = picker.querySelector('.trigger-code');
        const panel = picker.querySelector('.country-code-panel');
        const search = picker.querySelector('.country-code-search');
        const list = picker.querySelector('.country-code-list');
        const empty = picker.querySelector('.country-code-empty');

        const rows = countries.map(country => {
            const el = document.createElement('div');
            el.className = 'country-code-option';
            el.setAttribute('role', 'option');
            el.dataset.value = country.value;
            el.innerHTML = `<span class="opt-name"></span><span class="opt-code"></span>`;
            el.querySelector('.opt-name').textContent = country.name;
            el.querySelector('.opt-code').textContent = country.code;
            list.appendChild(el);
            return { el, country };
        });

        let activeIndex = -1;
        let visibleRows = rows.slice();

        function syncTrigger() {
            const current = countries.find(c => c.value === select.value) || countries[0];
            triggerCode.textContent = current ? current.code : '';
            rows.forEach(r => r.el.classList.toggle('is-selected', r.country.value === select.value));
        }

        function openPanel() {
            picker.classList.add('is-open');
            trigger.setAttribute('aria-expanded', 'true');
            search.value = '';
            applyFilter('');
            // Land highlight on the currently selected option for fast keyboard nav
            const selectedIdx = visibleRows.findIndex(r => r.country.value === select.value);
            setActive(selectedIdx >= 0 ? selectedIdx : 0);
            // Defer focus to next frame so the panel is visible
            requestAnimationFrame(() => search.focus());
        }

        function closePanel() {
            picker.classList.remove('is-open');
            trigger.setAttribute('aria-expanded', 'false');
            setActive(-1);
        }

        function setActive(idx) {
            if (activeIndex >= 0 && visibleRows[activeIndex]) {
                visibleRows[activeIndex].el.classList.remove('is-active');
            }
            activeIndex = idx;
            if (idx >= 0 && visibleRows[idx]) {
                const el = visibleRows[idx].el;
                el.classList.add('is-active');
                // Keep the active item visible inside the scroll container
                const top = el.offsetTop;
                const bottom = top + el.offsetHeight;
                if (top < list.scrollTop) list.scrollTop = top;
                else if (bottom > list.scrollTop + list.clientHeight) list.scrollTop = bottom - list.clientHeight;
            }
        }

        function applyFilter(qRaw) {
            const q = qRaw.trim().toLowerCase();
            const qDigits = q.replace(/\D/g, '');
            visibleRows = [];
            rows.forEach(r => {
                const nameMatch = r.country.name.toLowerCase().includes(q);
                const codeMatch = qDigits && r.country.code.replace('+', '').includes(qDigits);
                const show = !q || nameMatch || codeMatch;
                r.el.hidden = !show;
                r.el.classList.remove('is-active');
                if (show) visibleRows.push(r);
            });
            empty.hidden = visibleRows.length > 0;
            activeIndex = -1;
        }

        function chooseRow(row) {
            if (!row) return;
            select.value = row.country.value;
            select.dispatchEvent(new Event('change', { bubbles: true }));
            syncTrigger();
            closePanel();
            trigger.focus();
        }

        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            picker.classList.contains('is-open') ? closePanel() : openPanel();
        });

        trigger.addEventListener('focus', function() {
            if (phoneInputGroup) phoneInputGroup.classList.add('focused');
        });

        trigger.addEventListener('blur', function() {
            if (phoneInputGroup) phoneInputGroup.classList.remove('focused');
        });

        search.addEventListener('input', function() {
            applyFilter(this.value);
            if (visibleRows.length) setActive(0);
        });

        search.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (visibleRows.length) setActive((activeIndex + 1) % visibleRows.length);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (visibleRows.length) setActive((activeIndex - 1 + visibleRows.length) % visibleRows.length);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                chooseRow(visibleRows[activeIndex] || visibleRows[0]);
            } else if (e.key === 'Escape') {
                e.preventDefault();
                closePanel();
                trigger.focus();
            }
        });

        list.addEventListener('click', function(e) {
            const optEl = e.target.closest('.country-code-option');
            if (!optEl) return;
            const row = rows.find(r => r.el === optEl);
            chooseRow(row);
        });

        list.addEventListener('mousemove', function(e) {
            const optEl = e.target.closest('.country-code-option');
            if (!optEl) return;
            const idx = visibleRows.findIndex(r => r.el === optEl);
            if (idx !== -1 && idx !== activeIndex) setActive(idx);
        });

        document.addEventListener('click', function(e) {
            if (!picker.contains(e.target) && picker.classList.contains('is-open')) {
                closePanel();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && picker.classList.contains('is-open')) {
                closePanel();
                trigger.focus();
            }
        });

        // Keep trigger in sync if anything else changes the select programmatically
        select.addEventListener('change', syncTrigger);

        syncTrigger();
    })();

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
        
        // Validate that at least one country is selected (from globe, dropdown, or custom countries)
        const customCountriesField = document.getElementById('customCountries');
        const customCountries = customCountriesField ? customCountriesField.value.trim() : '';
        const hasCustomCountries = customCountries.length > 0;
        const hasGlobeCountries = selectedCountries.length > 0;
        const selectedDropdownOptions = document.querySelectorAll('.dropdown-option.selected');
        const selectedDropdownValues = Array.from(selectedDropdownOptions).map(opt => opt.getAttribute('data-value'));
        const hasOtherSelected = selectedDropdownValues.includes('other');
        const hasNonOtherDropdownSelection = selectedDropdownValues.some(val => val !== 'other');
        
        // Debug logging for validation
        console.log('Form validation - Globe countries:', hasGlobeCountries, 'Count:', selectedCountries.length);
        console.log('Form validation - Dropdown selection (non-other):', hasNonOtherDropdownSelection);
        console.log('Form validation - Other selected with custom:', hasOtherSelected && hasCustomCountries);
        console.log('Form validation - Selected countries array:', selectedCountries);
        
        // Valid if: globe countries selected, OR non-other dropdown selection, OR (other selected with custom countries)
        const hasValidSelection = hasGlobeCountries || hasNonOtherDropdownSelection || (hasOtherSelected && hasCustomCountries);
        
        if (!hasValidSelection) {
            isValid = false;
            alert('Please select at least one country from the globe or dropdown, or enter custom countries if "Other" is selected.');
        } else {
            console.log('Form validation - Selection is valid!');
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
        
        // Check month/year picker (use hidden input)
        const travelMonthYearInput = document.getElementById('travelMonthYear');
        const monthYearPicker = document.querySelector('.month-year-picker');
        if (travelMonthYearInput && travelMonthYearInput.hasAttribute('required') && !travelMonthYearInput.value) {
            isValid = false;
            if (monthYearPicker) {
                monthYearPicker.classList.add('error');
                setTimeout(() => {
                    monthYearPicker.classList.remove('error');
                }, 1000);
            }
        } else if (monthYearPicker) {
            monthYearPicker.classList.remove('error');
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

        // Capture selected dropdown trips BEFORE resetting form (reuse variables from validation)
        const selectedTripValues = Array.from(selectedDropdownOptions).map(opt => opt.getAttribute('data-value'));
        
        // Prepare form data for submission (reuse variables from validation)
        
        // Get all selected countries (from globe + custom) for submission
        // Include countries selected from globe (not just dropdown)
        const selectedCountriesInput = document.getElementById('selectedCountries');
        let allSelectedCountries = [];
        
        // First, ensure selectedCountries array has all globe-selected countries
        // This includes countries clicked directly on the globe
        const globeSelectedCountries = selectedCountries.map(c => ({ 
            code: c.code, 
            name: c.name 
        }));
        
        if (selectedCountriesInput && selectedCountriesInput.value) {
            try {
                const parsedCountries = JSON.parse(selectedCountriesInput.value);
                // Merge globe-selected countries with any from hidden input
                // Use a Map to avoid duplicates based on code
                const countryMap = new Map();
                
                // Add globe-selected countries first
                globeSelectedCountries.forEach(c => {
                    countryMap.set(c.code, c);
                });
                
                // Add countries from hidden input (may include custom countries)
                parsedCountries.forEach(c => {
                    if (!countryMap.has(c.code)) {
                        countryMap.set(c.code, c);
                    }
                });
                
                allSelectedCountries = Array.from(countryMap.values());
            } catch (e) {
                // Fallback: use selectedCountries array if parsing fails
                allSelectedCountries = globeSelectedCountries;
            }
        } else {
            // Fallback: use selectedCountries array directly (globe selections)
            allSelectedCountries = globeSelectedCountries;
        }
        
        // Log for debugging
        console.log('Form submission - Globe selected countries:', selectedCountries);
        console.log('Form submission - All selected countries:', allSelectedCountries);
        
        // Get phone number with country code
        const phoneInput = document.getElementById('phone');
        const phoneCountryCodeSelect = document.getElementById('phoneCountryCode');
        const phoneCountryCode = phoneCountryCodeSelect ? phoneCountryCodeSelect.value : '+91';
        const phoneNumber = phoneInput ? phoneInput.value.replace(/\D/g, '') : '';
        const fullPhoneNumber = phoneCountryCode + phoneNumber;
        
        const formData = {
            firstName: document.getElementById('firstName').value,
            email: document.getElementById('email').value,
            phone: fullPhoneNumber, // Phone number with country code
            tripType: JSON.stringify(selectedTripValues),
            selectedCountries: JSON.stringify(allSelectedCountries),
            customCountries: customCountries,
            numberOfPeople: parseInt(document.getElementById('numberOfPeople').value) || null,
            travelMonth: document.getElementById('travelMonthYear') ? document.getElementById('travelMonthYear').value : '',
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
            'ireland-scotland': 'Ireland & Scotland',
            'russia-artic': 'Russia Arctic',
            'russia-luxe': 'Russia Luxe',
            'mongolia': 'Mongolia',
            'tibet': 'Tibet',
            'iceland': 'Iceland'
        };
        
        // Function to generate gallery URL for a trip
        function getTripGalleryUrl(tripValue) {
            // Use urlPath function if available (from contact_us.php), otherwise construct manually
            if (typeof window.urlPath === 'function') {
                return window.urlPath('galleries/' + tripValue);
            } else {
                // Fallback: construct URL manually
                const base = window.BASE_PATH || '';
                return (base ? base + '/' : '/') + 'galleries/' + tripValue;
            }
        }
        
        // Generate trip links HTML
        function generateTripLinks(selectedTrips) {
            // Filter out "other" from the trip links - don't show "Other" in thank you message
            const filteredTrips = selectedTrips.filter(tripValue => tripValue !== 'other');
            
            if (filteredTrips.length === 0) {
                return '';
            }
            
            const links = filteredTrips.map(tripValue => {
                const displayName = tripDisplayNames[tripValue] || tripValue;
                const galleryUrl = getTripGalleryUrl(tripValue);
                return `<a href="${galleryUrl}" class="trip-link">Visit ${displayName} Memories</a>`;
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
            
            // Display trip links if any dropdown trips were selected (excluding "other")
            const tripLinksContainer = document.getElementById('tripLinksContainer');
            const tripLinksList = document.getElementById('tripLinksList');
            
            // Filter out "other" from selectedTripValues before generating links
            const filteredTripValues = selectedTripValues.filter(tripValue => tripValue !== 'other');
            
            if (filteredTripValues.length > 0 && tripLinksContainer && tripLinksList) {
                const linksHtml = generateTripLinks(filteredTripValues);
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
            const travelMonthSelect = document.getElementById('travelMonth');
            const travelYearSelect = document.getElementById('travelYear');
            const travelMonthYearInput = document.getElementById('travelMonthYear');
            if (numberOfPeopleInput) numberOfPeopleInput.value = '';
            if (travelMonthSelect) travelMonthSelect.value = '';
            if (travelYearSelect) travelYearSelect.value = '';
            if (travelMonthYearInput) {
                travelMonthYearInput.value = '';
                travelMonthYearInput.classList.remove('has-value');
            }
            const monthYearPicker = document.querySelector('.month-year-picker');
            if (monthYearPicker) {
                monthYearPicker.classList.remove('has-value');
            }
            
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
                            polygon.set("fill", am5.color("#2C4B3B"));
                            polygon.set("strokeWidth", 1.5);
                        } else {
                            // Reset to default
                            polygon.set("fill", am5.color("#50595f")); // Grey for land
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
    
    // Apply ?trip= from a destination page's "Book your trip" button. Waits for the
    // globe's polygons so the country highlight lands too, then gives up and selects
    // in the dropdown anyway if the map never loads.
    (function waitForMapThenPreselect(attempts) {
        if (preselectApplied) return;
        let ready = false;
        try {
            ready = !!(polygonSeries && polygonSeries.getDataItemById && polygonSeries.getDataItemById('IE'));
        } catch (e) {
            ready = false;
        }
        if (ready || attempts <= 0) {
            applyPreselectedTrip();
            return;
        }
        setTimeout(function() { waitForMapThenPreselect(attempts - 1); }, 200);
    })(25);

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
