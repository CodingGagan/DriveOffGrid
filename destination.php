<?php
require_once __DIR__ . '/includes/config.php';
// Get destination from URL - check custom URL first, then query parameter
$request_uri = $_SERVER['REQUEST_URI'];
$request_uri = $BASE_PATH !== '' ? str_replace($BASE_PATH . '/', '', $request_uri) : ltrim($request_uri, '/');
$request_uri = trim($request_uri, '/');
$request_uri = explode('?', $request_uri)[0]; // Remove query string
$request_uri = explode('#', $request_uri)[0]; // Remove hash

// Map custom URLs to destination keys
$url_to_destination = [
    'poland' => 'poland',
    'ireland' => 'ireland',
    'norway' => 'norway',
    'oman' => 'oman',
    'scotland' => 'scotland',
    'srilanka' => 'srilanka',
    'uae-oman' => 'uae_and_oman',
    'ireland-scotland' => 'ireland_scotland',
    'mongolia' => 'mongolia',
    'tibet' => 'tibet',
    'iceland' => 'iceland',
    'russia/artic' => 'russia_artic',
    'russia/arctic' => 'russia_artic', // Alternative spelling
    'russia/luxe' => 'russia_luxe_corridor',
    'russia/luxury' => 'russia_luxe_corridor', // Alternative spelling
];

// Get destination from custom URL or query parameter
if (isset($url_to_destination[$request_uri])) {
    $destination = $url_to_destination[$request_uri];
} else {
    $destination = isset($_GET['dest']) ? $_GET['dest'] : 'poland';
}
// Oman // UAE & Oman // Ireland // Scotland // Ireland & Scotland //   Sri Lanka
// Destination data array - can be moved to a separate file/database later
$destinations = [
    'ireland' => [
        'name' => 'IRELAND',
        'theme' => 'Wild Atlantic',
        'hero_image' => '../assets/images/banner_location_page/ireland.webp',
        'background_image' => '../assets/images/memories/ireland/beautiful-view-cliffs-moher-ireland-s-county-clare.webp',
        'content' => [
            'Ireland’s Wild Atlantic edge is where land, sea, and soul collide. This drive takes you along windswept cliffs, emerald meadows, ancient stone walls, and coastal roads sculpted by centuries of storm and salt. Charming villages, lively pubs, and a spirit of storytelling bring warmth to the ruggedness. Ireland’s beauty is not loud, it’s lyrical. It’s in the mist that softens the morning, the waves that shape the coast, and the landscapes that feel alive with memory.',
            '<span class="highlight-text">The Wild Atlantic way is more than a route - it’s an emotion.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '9 days / 8 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '4 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,700 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => '4x4 SUV'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Mountain Drives, Coastal & Cliff Trails'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'May, Jun & Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays']
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrival in Dublin',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/ireland/ireland-day-1.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Cobh',
                'drive_time' => '3.25 hours',
                'distance' => '286 kms',
                'image' => '../assets/images/locations/ireland/ireland-day-2.webp',
                'highlights' => 'Titanic Experience'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Kilarney',
                'drive_time' => '3 hours',
                'distance' => '200 kms',
                'image' => '../assets/images/locations/ireland/ireland-day-3.webp',
                'highlights' => 'Healy Pass'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Ashford',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => '../assets/images/locations/ireland/ireland-day-4.webp',
                'highlights' => 'Cliffs of Moher'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Ashford',
                'drive_time' => '2 hours',
                'distance' => '100 kms',
                'image' => '../assets/images/locations/ireland/ireland-day-5.webp',
                'highlights' => 'Sheep Farm'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Lough Eske',
                'drive_time' => '4 hours',
                'distance' => '270 kms',
                'image' => '../assets/images/locations/ireland/ireland-day-6.webp',
                'highlights' => 'Downpatrick Head'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Ballygally',
                'drive_time' => '5 hours',
                'distance' => '280 kms',
                'image' => '../assets/images/locations/ireland/ireland-day-7.webp',
                'highlights' => 'Malin Head, Giant\'s Causeway, Carrick Rope Bridge'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Dublin',
                'drive_time' => '4 hours',
                'distance' => '265.6 kms',
                'image' => '../assets/images/locations/ireland/ireland-day-8.webp',
                'highlights' => 'Castle Ward, Guinness Store House'
            ],
            [
                'day' => 'DAY 9',
                'destination' => 'Fly out',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/ireland/end ireland.jpg',
                'highlights' => ''
            ]
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'norway' => [
        'name' => 'Norway',
        'theme' => 'Fjord & Flame',
        'hero_image' => '../assets/images/banner_location_page/norway.webp',
        'background_image' => '../assets/images/memories/norway/beautiful-shot-football-pitch-norway.webp',
        'content' => [
            'Norway is a land sculpted by ice, fire, and time - a place where landscapes rise in dramatic silence and every bend in the road feels like a revelation. This expedition takes you through majestic fjords, snow-capped peaks, mirror-like lakes, and coastal stretches washed in the glow of the midnight sun. From the quiet charm of Nordic villages to the raw power of nature at its purest, Norway offers a drive that feels both grounding and otherworldly.',
            '<span class="highlight-text">It’s a journey of contrasts, cold blues and warm golds, towering cliffs and gentle valleys - a place where the road becomes a ribbon between earth and sky.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '11 days / 10 nights'],
            // 'days_on_road' => ['icon' => '../assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '4 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,040 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => '4x4 SUV'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Mountain Passes, Fjord Roads, Coastal Highways, Alpine Valleys, Scenic Tunnels & Off-road Trails'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'May to Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Curated Stays']
            // 'curate' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrive in Oslo',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/norway/Oslo.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Solvornvegen',
                'drive_time' => '5.5 hours',
                'distance' => '325 kms',
                'image' => '../assets/images/locations/norway/oslo 2.jpg',
                'highlights' => 'Via Sognefjellet'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Solvornvegen',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/norway/Solvornvegen.jpg',
                'highlights' => 'Mountain hike, Kayak tour'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Storfjord',
                'drive_time' => '5 hours',
                'distance' => '280 kms',
                'image' => '../assets/images/locations/norway/Storfjord.jpg',
                'highlights' => 'Scenic fjord drive experience'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Geiranger',
                'drive_time' => '5.5 hours',
                'distance' => '250 kms',
                'image' => '../assets/images/locations/norway/Geiranger.jpg',
                'highlights' => 'Bud, the Atlantic Highway'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Voss',
                'drive_time' => '6 hours',
                'distance' => '300 kms',
                'image' => '../assets/images/locations/norway/Voss.jpg',
                'highlights' => 'World’s longest road tunnel'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Voss',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/norway/voss (2).jpg',
                'highlights' => 'Scenic gondola ride, hike to a mountain cabin'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Hardanger',
                'drive_time' => '3 hours',
                'distance' => '150 kms',
                'image' => '../assets/images/locations/norway/Handanger.jpg',
                'highlights' => 'Stay by the fjord, Kayak experience'
            ],
            [
                'day' => 'DAY 9',
                'destination' => 'Hardanger',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/norway/Handanger 2.jpg',
                'highlights' => 'Waterfalls, glaciers, a private fjord cruise'
            ],
            [
                'day' => 'DAY 10',
                'destination' => 'Bergen',
                'drive_time' => '1.5 hours',
                'distance' => '100 kms',
                'image' => '../assets/images/locations/norway/Bergen.jpg',
                'highlights' => 'Explore Bergen, Guided city tour'
            ],
            [
                'day' => 'DAY 11',
                'destination' => 'Fly Out',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/norway/norway end.jpg',
                'highlights' => ''
            ]
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'poland' => [
        'name' => 'POLAND',
        'theme' => 'ECHOES OF TIME',
        'hero_image' => '../assets/images/banner_location_page/poland.webp',
        'background_image' => '../assets/images/memories/poland/IMG_4462(1).webp',
        'content' => [
            'A journey through Poland is a journey through layers of history, resilience, and quiet beauty. From the timeless cobblestones of Krakow to the haunting stillness of Auschwitz, from medieval castles to serene lakes and thriving modern cities, every mile reveals a <span class="highlight-text">country shaped by both tragedy and triumph</span>.',
            'This expedition takes you through landscapes where stories linger in the air - baroque facades, forgotten villages, forest-lined roads, and vibrant cultural corners waiting to be rediscovered. It\'s a drive that <span class="highlight-text">connects the past and present</span>, inviting you to witness a nation that continues to rise, rebuild, and redefine itself.',
            '<span class="highlight-text">In Poland, every turn whispers an echo, and every echo becomes part of your own journey.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '8 days / 7 nights'],
            // 'days_on_road' => ['icon' => '../assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '4 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,190 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'SUV 4x4 (Automatic)'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Highways, historic towns, river routes, mountain roads, scenic countryside'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'May, Jun & Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Premium & boutique stays']
            // 'curate' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrival at Warsaw',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/poland/warsaw day 1 poland.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Warsaw',
                'drive_time' => '0 hours',
                'distance' => '0 kms',
                'image' => '../assets/images/locations/poland/warsaw.jpg',
                'highlights' => 'Warsaw Sight Seeing'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Osweicim',
                'drive_time' => '4.5 hours',
                'distance' => '365 kms',
                'image' => '../assets/images/locations/poland/warsaw 2.jpg',
                'highlights' => 'Arts Centre in Manufaktura, Lodz'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Krakow',
                'drive_time' => '2 hours',
                'distance' => '80 kms',
                'image' => '../assets/images/locations/poland/Oświęcim.jpg',
                'highlights' => 'Auschwitz Museum'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Tatra Mountains',
                'drive_time' => '3.5 hours',
                'distance' => '185 kms',
                'image' => '../assets/images/locations/poland/Kraków.jpg',
                'highlights' => 'Salt Mine Wieliczka'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Szczawnica',
                'drive_time' => '3.25 hours',
                'distance' => '172 kms',
                'image' => '../assets/images/locations/poland/TATRA MOUNTAINS.jpg',
                'highlights' => 'Dunajec River Gorge'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Warsaw',
                'drive_time' => '4.75 hours',
                'distance' => '388 kms',
                'image' => '../assets/images/locations/poland/SZCZAWNICA.jpg',
                'highlights' => 'Majdanek State Museum'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Fly out',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/poland/Poland warsaw.jpg',
                'highlights' => ''
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'scotland' => [
        'name' => 'Scotland',
        'theme' => 'Loch & Glen',
        'hero_image' => '../assets/images/banner_location_page/scotland.webp',
        'background_image' => '../assets/images/memories/scotland/685.webp',
        'content' => [
            'Scotland is a living tapestry of mist, myth, and majestic wilderness. On this expedition, winding single-track roads lead you through brooding glens, serene lochs, and windswept highlands that feel untouched by time. Castles stand like ancient sentinels, whisky distilleries warm the soul, and every village carries stories older than its stones.',
            '<span class="highlight-text">Dramatic skies, haunting beauty, and a raw, unfiltered sense of freedom define this drive. Scotland isn’t just scenery, it’s atmosphere, emotion, and the kind of stillness that stays with you long after the journey ends.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '8 days / 7 nights'],
            // 'days_on_road' => ['icon' => '../assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '6 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,400 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'Land Rover Defender 110'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Mountain Drives, Coastal & Cliff Trails'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'May, Jun & Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays']
            // 'curate' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrival at Edinburgh',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/scotland/scotland-day-1.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Ballachulish',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => '../assets/images/locations/scotland/scotland-day-2.webp',
                'highlights' => 'Shaken not Stirred'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Isle of Skye',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => '../assets/images/locations/scotland/scotland-day-3.webp',
                'highlights' => 'Witness the Magical Hogwartrs Express'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Inverness',
                'drive_time' => '3.5 hours',
                'distance' => '250 kms',
                'image' => '../assets/images/locations/scotland/scotland-day-4.webp',
                'highlights' => 'Marvels of Isle of Skye'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Inverness',
                'drive_time' => '1 hour',
                'distance' => '50 kms',
                'image' => '../assets/images/locations/scotland/scotland-day-5.webp',
                'highlights' => 'Experience Loch Legends'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Pitlochry',
                'drive_time' => '5 hours',
                'distance' => '300 kms',
                'image' => '../assets/images/locations/scotland/scotland-day-6.webp',
                'highlights' => 'Scotch Trail'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Edinburgh',
                'drive_time' => '3.5 hours',
                'distance' => '225 kms',
                'image' => '../assets/images/locations/scotland/scotland-day-7.webp',
                'highlights' => 'Witness the legacy of Golf DAY 1'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Fly Out',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/scotland/scotland end.jpg',
                'highlights' => ''
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'uae_and_oman' => [
        'name' => 'UAE & Oman',
        'theme' => 'Jebel Wadi',
        'hero_image' => '../assets/images/banner_location_page/uae.webp',
        'background_image' => '../assets/images/memories/uae_oman/3.webp',
        'content' => [
            'Across the empty deserts and towering mountain ranges of the Arabian Peninsula lies a world of stark beauty and timeless stillness. This expedition takes you from futuristic skylines and pristine highways to rugged wadis, canyons, and dune-kissed horizons that feel endless. The silence of the desert, the drama of the rocky cliffs, the warmth of remote villages, and the majesty of desert nights under a billion stars create a journey that’s both humbling and exhilarating.',
            '<span class="highlight-text">In the UAE and Oman, nature is vast, culture is deep, and the road invites you to explore both.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '9 days / 8 nights'],
            // 'days_on_road' => ['icon' => '../assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '8 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 2,000 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'Land Cruiser 4x4'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Mountain Drives, Coastal Roads, Desert Crossings, Off-road trails'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'Nov to Feb'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays']
            // 'curate' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Car / Hotel / Food / Fuel / Airport Pickup / Support & Lead Car / Always accompanied by Co-Founders of DriveOffGrid'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrival at Dubai',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/uae/uae-day-1.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Al Aqah',
                'drive_time' => '3.75 hours',
                'distance' => '280 kms',
                'image' => '../assets/images/locations/uae/uae oman day 02.jpeg',
                'highlights' => 'A gourmet above the clouds'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Al Ain',
                'drive_time' => '3 hours',
                'distance' => '250 kms',
                'image' => '../assets/images/locations/uae/uae-day-2.webp',
                'highlights' => 'Beach Activities'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Muscat',
                'drive_time' => '5 hours',
                'distance' => '430 kms',
                'image' => '../assets/images/locations/uae/uae-day-3.webp',
                'highlights' => 'Cross-border drive'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Muscat',
                'drive_time' => '1.5 hours',
                'distance' => '100 kms',
                'image' => '../assets/images/locations/uae/uae-day-4.webp',
                'highlights' => 'Local Sightseeing and Water Activities'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Al Hamra',
                'drive_time' => '4.5 hours',
                'distance' => '240 kms',
                'image' => '../assets/images/locations/uae/uae-day-5.webp',
                'highlights' => 'Off-Roading'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Jebel Akhdar',
                'drive_time' => '2 hours',
                'distance' => '115 kms',
                'image' => '../assets/images/locations/uae/uae-day-6.webp',
                'highlights' => 'Cultural Exploration'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Wahiba Sands',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => '../assets/images/locations/uae/uae-day-7.webp',
                'highlights' => 'Desert Drive'
            ],
            [
                'day' => 'DAY 9',
                'destination' => 'Fly out',
                'drive_time' => '3.25 hours',
                'distance' => '275 kms',
                'image' => '../assets/images/locations/uae/uae oman end.jpg',
                'highlights' => ''
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'srilanka' => [
        'name' => 'Sri Lanka',
        'theme' => 'Serendipity',
        'hero_image' => '../assets/images/banner_location_page/srilanks.webp',
        'background_image' => '../assets/images/memories/srilanka/4972.webp',
        'content' => [
            'Sri Lanka is an island where nature performs at every turn - from misty tea gardens and emerald highlands to golden beaches where the ocean comes alive. This expedition takes you through landscapes rich with culture and wildlife, offering rare encounters with majestic elephants in the wild and the thrill of watching blue whales rise from the depths of the Indian Ocean. Between ancient cities, rainforest trails, coastal drives, and warm island hospitality, every moment feels like a discovery.',
            '<span class="highlight-text">In Sri Lanka, magic isn’t hidden - it reveals itself gently, just when you least expect it.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '8 days / 7 nights'],
            // 'days_on_road' => ['icon' => '../assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '6 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 800 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => '4x4 SUV / Luxury Sedan'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Coastal Roads, Open Jeep Safaris, Forest Trails, Scenic Highways'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'Jan to Mar, Jun & Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays']
            // 'curate' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrival at Negombo',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/srilanka/srilanka day 01.jpeg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Mirassa',
                'drive_time' => '3 hours',
                'distance' => '190 kms',
                'image' => '../assets/images/locations/srilanka/srilanka-day-2.webp',
                'highlights' => 'Walk Through Heritage Sights'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Yala National Park',
                'drive_time' => '3 hours',
                'distance' => '150 kms',
                'image' => '../assets/images/locations/srilanka/srilanka-day-3.webp',
                'highlights' => 'Whale Watching Experience'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Yala National Park',
                'drive_time' => '0 hours',
                'distance' => '0 kms',
                'image' => '../assets/images/locations/srilanka/srilanka-day-4.webp',
                'highlights' => 'Wild Life Open Jeep Safaris'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'KAdruketha',
                'drive_time' => '3.5 hours',
                'distance' => '155 kms',
                'image' => '../assets/images/locations/srilanka/srilanka-day-5.webp',
                'highlights' => 'Experience the rustic charm of Sri Lanka'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Nuwara Eliya',
                'drive_time' => '3 hours',
                'distance' => '100 kms',
                'image' => '../assets/images/locations/srilanka/srilanka-day-6.webp',
                'highlights' => 'Visit the picturesque hill station of Little Engalnd'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Negombo',
                'drive_time' => '5.5 hours',
                'distance' => '190 kms',
                'image' => '../assets/images/locations/srilanka/srilanka-day-7.webp',
                'highlights' => 'Riverside Lunch'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Fly out',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/srilanka/srilanka end.jpg',
                'highlights' => ''
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'oman' => [
        'name' => 'OMAN',
        'theme' => 'Golden Mirage',
        'hero_image' => '../assets/images/banner_location_page/oman.webp',
        'background_image' => '../assets/images/memories/oman/363.webp',
        'content' => [
            'Oman’s desert has a way of making time slow down. Endless golden dunes, hidden wadis, date-laden oases, and ancient caravan routes form the backdrop of this expedition. Here, the horizon is a soft, shifting line; the silence is almost sacred. It’s a land where tradition and tranquility blend effortlessly. Driving through Oman feels like stepping into a mirage - real, surreal, and deeply calming.',
            '<span class="highlight-text">It’s a journey into stillness, into heritage, and into golden landscapes that glow long after the sun has set.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '5 days / 4 nights'],
            // 'days_on_road' => ['icon' => '../assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '4 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,000 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'Land Cruiser 4x4'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Mountain Drives, Coastal Roads, Desert Crossings, Off-road trails'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'Nov to Feb'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays']
            // 'curate' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrival at Muscat',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/oman/oman day 01.jpeg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Jebel Akhdar',
                'drive_time' => '2.5 hours',
                'distance' => '125 kms',
                'image' => '../assets/images/locations/oman/oman-day-1.webp',
                'highlights' => 'Boat Cruise'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Al Hamra',
                'drive_time' => '2.5 hours',
                'distance' => '125 kms',
                'image' => '../assets/images/locations/oman/oman-day-2.webp',
                'highlights' => 'Nizwa Souk, Cultural Village'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Wahiba Sands',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => '../assets/images/locations/oman/oman-day-3.webp',
                'highlights' => 'Desert Driving'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Fly out',
                'drive_time' => '4.5 hours',
                'distance' => '320 kms',
                'image' => '../assets/images/locations/oman/oman end.jpg',
                'highlights' => ''
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'russia_artic' => [
        'name' => 'Russia',
        'theme' => 'Arctic Affair',
        'hero_image' => '../assets/images/banner_location_page/russia arctic.webp',
        'background_image' => '../assets/images/memories/russia_artic/194.webp',
        'content' => [
            'From imperial elegance to Arctic wonder, this expedition is a dance between culture and wilderness. Starting in the grandeur of St. Petersburg, the road takes you north through sleepy villages, frozen forests, and vast, untouched tundra. As the landscape shifts into a world of snow and silence, the Arctic reveals its own kind of romance - stark, mesmerizing, and mysterious.',
            '<span class="highlight-text">This is a journey of northern lights, icy expanses, and the thrill of reaching the edge of the world.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '10 days / 9 nights'],
            // 'days_on_road' => ['icon' => '../assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '6 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,800 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'GWM Tank 500'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Snow and Forest Drives'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'Jun to Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays']
            // 'curate' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrival at Moscow',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/russia-artic/moscow day 1 russia arctic.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Lake Seligar',
                'drive_time' => '6 hours',
                'distance' => '385 kms',
                'image' => '../assets/images/locations/russia-artic/Moscow.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Veliky Novgorod',
                'drive_time' => '5 hours',
                'distance' => '320 kms',
                'image' => '../assets/images/locations/russia-artic/Lake Seliger.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Upper Mandrogi',
                'drive_time' => '6 hours',
                'distance' => '340 kms',
                'image' => '../assets/images/locations/russia-artic/Veliky Novgorod.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Petro Zavodsk',
                'drive_time' => '4 hours',
                'distance' => '250 kms',
                'image' => '../assets/images/locations/russia-artic/Upper Mandrogi.jpg',
                'highlights' => 'Horse Sledding'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Petro Zavodsk',
                'drive_time' => '1.5 hours',
                'distance' => '70 kms',
                'image' => '../assets/images/locations/russia-artic/Petrozavodsk.jpg',
                'highlights' => 'Kizhi Island Adventures'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Sortavala',
                'drive_time' => '3 hours',
                'distance' => '160 kms',
                'image' => '../assets/images/locations/russia-artic/Sortavala 01.jpg',
                'highlights' => 'Dog Sled'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'St. Petersburg',
                'drive_time' => '5 hours',
                'distance' => '270 kms',
                'image' => '../assets/images/locations/russia-artic/st peterberg 2nd image.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 9',
                'destination' => 'St. Petersburg',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/russia-artic/st-petersburg-6902540_1920.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 10',
                'destination' => 'Fly out',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/russia-artic/russia arctic end.jpg',
                // 'highlights' => 'Flight back Home'
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'russia_luxe_corridor' => [
        'name' => 'Russia',
        'theme' => 'Luxe Corridor',
        'hero_image' => '../assets/images/banner_location_page/russia luxe.webp',
        'background_image' => '../assets/images/memories/russia_luxe/2814.webp',
        'content' => [
            'This expedition is a passage through Russia’s cultural crown - a road that links two legendary cities, each with its own identity and grandeur. From Moscow’s bold architecture and electric energy to St. Petersburg’s imperial charm and artistic soul, the journey flows through a corridor rich in history, opulence, and elegance. Palaces, museums, forests, and story-laden villages line your route, creating a drive that feels both regal and modern.',
        '<span class="highlight-text">The Luxe Corridor is where luxury meets legacy.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '11 days / 10 nights'],
            // 'days_on_road' => ['icon' => '../assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '6 days'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 2,200 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'GWM Tank 500'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Snow and Forest Drives'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'Jun to Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays']
            // 'curate' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrival at St. Petersburg',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/russia-artic/st-petersburg-6902540_1920.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Sortavala',
                'drive_time' => '6 hours',
                'distance' => '300 kms',
                'image' => '../assets/images/locations/russia_luxe/Sortavala.jpg',
                'highlights' => 'Ruskeala Mountain Park'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Petro Zavodsk',
                'drive_time' => '3 hours',
                'distance' => '160 kms',
                'image' => '../assets/images/locations/russia_luxe/Petrozavodsk images.jpg',
                'highlights' => 'Dog Sled'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Petro Zavodsk',
                'drive_time' => '6 hours',
                'distance' => '340 kms',
                'image' => '../assets/images/locations/russia_luxe/Petrozavodsk.jpg',
                'highlights' => 'Kizhi Island Adventures'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Segezha',
                'drive_time' => '6 hours',
                'distance' => '265 kms',
                'image' => '../assets/images/locations/russia_luxe/Segezha.png',
                'highlights' => 'Volcano Crater'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Kirovsk',
                'drive_time' => '8 hours',
                'distance' => '570 kms',
                'image' => '../assets/images/locations/russia_luxe/kirovsk 01.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Kirovsk',
                'drive_time' => '0 hours',
                'distance' => '0 kms',
                'image' => '../assets/images/locations/russia_luxe/Kirovsk.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Lapland Village',
                'drive_time' => '4 hours',
                'distance' => '230 kms',
                'image' => '../assets/images/locations/russia_luxe/Laphland village (2).jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 9',
                'destination' => 'Lapland Village',
                'drive_time' => '5 hours',
                'distance' => '280 kms',
                'image' => '../assets/images/locations/russia_luxe/Laphland village.jpg',
                'highlights' => 'Vie Teriberka'
            ],
            [
                'day' => 'DAY 10',
                'destination' => 'Lapland Village',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/russia_luxe/lapland village russia 3.jpg',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 11',
                'destination' => 'Fly out',
                'drive_time' => '',
                'distance' => '',
                'image' => '../assets/images/locations/russia_luxe/russia luxe end.jpg',
                // 'highlights' => 'Flight back Home'
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'mongolia' => [
        'name' => 'MONGOLIA',
        'theme' => 'Steppe & Sky',
        'hero_image' => '../assets/images/locations/mongolia/detail_home_page.png',
        'background_image' => '../assets/images/locations/mongolia/homepage/mongolia.png',
        'content' => [
            '<span class="highlight-text">Echoes of Time. Endless Steppes. One Incredible Journey.</span>',
            'Experience the untouched beauty of Mongolia on a 10-day expedition through ancient capitals, endless grasslands, golden sand dunes, crystal-clear lakes, Buddhist monasteries, and authentic nomadic culture. From the iconic Chinggis Khaan Statue to the UNESCO-listed Orkhon Valley, this journey blends history, adventure, and breathtaking landscapes into one unforgettable road trip.',
            '<span class="highlight-text">Immerse yourself in Mongolia’s timeless beauty—all while traveling in comfort with a thoughtfully curated itinerary.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '10 Days / 9 Nights'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,200 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'SUV or 4x4 Expedition Vehicle'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Steppes, Desert, Mountains, Lakes & City Roads'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'Jun to Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Hotels & Authentic Tourist Camps']
        ],
        'itinerary' => [
            ['day' => 'DAY 1', 'destination' => 'Ulaanbaatar', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/mongolia/itinery/1.png', 'highlights' => 'City Sightseeing & Museums'],
            ['day' => 'DAY 2', 'destination' => 'Elsen Tasarkhai', 'drive_time' => '4.5 hours', 'distance' => '260 kms', 'image' => '../assets/images/locations/mongolia/itinery/2.png', 'highlights' => 'Mini Gobi Desert, Camel Riding & Sand Dunes'],
            ['day' => 'DAY 3', 'destination' => 'Kharkhorum', 'drive_time' => '2 hours', 'distance' => '100 kms', 'image' => '../assets/images/locations/mongolia/itinery/3.png', 'highlights' => 'Ancient Capital & Kharkhorum Museum'],
            ['day' => 'DAY 4', 'destination' => 'Kharkhorum', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/mongolia/itinery/4.png', 'highlights' => 'Erdene Zuu Monastery & UNESCO Orkhon Valley'],
            ['day' => 'DAY 5', 'destination' => 'Lake Ugii', 'drive_time' => '2 hours', 'distance' => '100 kms', 'image' => '../assets/images/locations/mongolia/itinery/5.png', 'highlights' => 'Lake Ugii & Optional Boating Experience'],
            ['day' => 'DAY 6', 'destination' => 'Mongol Nomads', 'drive_time' => '5 hours', 'distance' => '260 kms', 'image' => '../assets/images/locations/mongolia/itinery/6.png', 'highlights' => 'Authentic Nomadic Lifestyle & Cultural Show'],
            ['day' => 'DAY 7', 'destination' => 'Terelj National Park', 'drive_time' => '4 hours', 'distance' => '180 kms', 'image' => '../assets/images/locations/mongolia/itinery/7.png', 'highlights' => 'Chinggis Khaan Statue & Turtle Rock'],
            ['day' => 'DAY 8', 'destination' => 'Ulaanbaatar', 'drive_time' => '1.5 hours', 'distance' => '60 kms', 'image' => '../assets/images/locations/mongolia/itinery/8.png', 'highlights' => 'City Tour, Museum & Folk Performance'],
            ['day' => 'DAY 9', 'destination' => 'Ulaanbaatar', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/mongolia/itinery/9.png', 'highlights' => 'Gandan Monastery & Shopping Experience'],
            ['day' => 'DAY 10', 'destination' => 'Fly Out', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/mongolia/itinery/10.png', 'highlights' => '']
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'tibet' => [
        'name' => 'TIBET',
        'theme' => 'Mystic Pass',
        'hero_image' => '../assets/images/locations/tibet/tibet_hero_image.png',
        'background_image' => '../assets/images/locations/tibet/homepage/tibet.png',
        'content' => [
            '<span class="highlight-text">Where Earth Meets the Sky</span>',
            'A journey through Tibet is a journey into one of the world’s most extraordinary landscapes, where towering Himalayan peaks, sacred monasteries, and centuries-old traditions come together in perfect harmony. From the grandeur of the Potala Palace in Lhasa to the breathtaking roads leading to Everest Base Camp, every mile offers a deeper connection to Tibet’s spiritual heritage and untouched natural beauty. Crossing high mountain passes, turquoise lakes, and peaceful valleys, this expedition reveals a land where prayer flags dance with the wind and every horizon inspires awe.',
            '<span class="highlight-text">In Tibet, every road leads closer to the soul of the Himalayas.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '10 Days / 9 Nights'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,460 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'SUV / 4x4 Expedition Vehicle'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'High Mountain Passes, Valleys, Lakes & Highways'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'April-May and Sep-Oct'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Premium & Boutique Stays']
        ],
        'itinerary' => [
            ['day' => 'DAY 1', 'destination' => 'Lhasa', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/tibet/itineray/1.png', 'highlights' => 'Warsaw City Sightseeing, Old Town | Royal Route | Museums'],
            ['day' => 'DAY 2', 'destination' => 'Lhasa', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/tibet/itineray/3.png', 'highlights' => 'Local Sightseeing, Driving Permit Formalities & Altitude Acclimatization'],
            ['day' => 'DAY 3', 'destination' => 'Lhasa', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/tibet/itineray/2.png', 'highlights' => 'Potala Palace, Jokhang Temple, Barkhor Street & Sera Monastery'],
            ['day' => 'DAY 4', 'destination' => 'Shannan', 'drive_time' => '2-3 hours', 'distance' => '100 kms', 'image' => '../assets/images/locations/tibet/itineray/4.png', 'highlights' => 'Yarlung Tsangpo Valley & Yumbulakang Palace'],
            ['day' => 'DAY 5', 'destination' => 'Shigatse', 'drive_time' => '6-7 hours', 'distance' => '320 kms', 'image' => '../assets/images/locations/tibet/itineray/5.png', 'highlights' => 'Yamdrok Lake, Karola Glacier & Tashilhunpo Monastery'],
            ['day' => 'DAY 6', 'destination' => 'Shigatse', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/tibet/itineray/6.png', 'highlights' => 'Explore Tibet’s Second-Largest City & Tashilhunpo Monastery'],
            ['day' => 'DAY 7', 'destination' => 'Everest Base Camp', 'drive_time' => '8-9 hours', 'distance' => '300 kms', 'image' => '../assets/images/locations/tibet/itineray/7.png', 'highlights' => 'Visit Everest Base Camp & Panoramic Himalayan Views'],
            ['day' => 'DAY 8', 'destination' => 'Shigatse (via Everest Base Camp)', 'drive_time' => '8-9 hours', 'distance' => '300 kms', 'image' => '../assets/images/locations/tibet/itineray/8.png', 'highlights' => 'Visit Everest Base Camp & Panoramic Himalayan Views'],
            ['day' => 'DAY 9', 'destination' => 'Lhasa', 'drive_time' => '6-7 hours', 'distance' => '360 kms', 'image' => '../assets/images/locations/tibet/itineray/9.png', 'highlights' => 'Return Journey via Yamdrok Lake'],
            ['day' => 'DAY 10', 'destination' => 'Fly Out', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/tibet/itineray/10.png', 'highlights' => '']
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ],
    'iceland' => [
        'name' => 'ICELAND',
        'theme' => 'Arctic Odyssey',
        'hero_image' => '../assets/images/locations/iceland/iceland_hero_image.webp',
        'background_image' => '../assets/images/locations/iceland/homepage/iceland.png',
        'content' => [
            '<span class="highlight-text">A journey through Iceland is a journey through raw landscapes, ancient forces, and quiet moments of extraordinary beauty.</span>',
            'This expedition takes you across Iceland\'s most dramatic landscapes, from the wild beauty of Borgarfjörður and Snæfellsnes to the legendary Golden Circle, remote Landmannalaugar, the southern coast, and the glacial wonders of Skaftafell and Jökulsárlón. Along the way, discover stories, traditions, and natural wonders shaped by fire and ice.',
            '<span class="highlight-text">In Iceland, every road leads to a landscape worth remembering.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '9 Days / 8 Nights'],
            'distance' => ['icon' => '../assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,900 kms'],
            'vehicle' => ['icon' => '../assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'SUV or 4x4 Expedition Vehicle'],
            'terrain' => ['icon' => '../assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Glaciers, Lava Fields, Waterfalls & Black-Sand Beaches'],
            'best_months' => ['icon' => '../assets/images/icons/duration.png', 'title' => 'BEST MONTHS TO TRAVEL', 'description' => 'May to Sep'],
            'accommodation' => ['icon' => '../assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Hotels']
        ],
        'itinerary' => [
            ['day' => 'DAY 1', 'destination' => 'Reykjavik', 'drive_time' => '', 'distance' => '', 'image' => '../assets/images/locations/iceland/itineray/1.png', 'highlights' => 'Arrival in Keflavík, transfer to Reykjavik, city exploration'],
            ['day' => 'DAY 2', 'destination' => 'Borgarfjordur', 'drive_time' => '2 hours', 'distance' => '120 kms', 'image' => '../assets/images/locations/iceland/itineray/2.png', 'highlights' => 'Borgarfjordur, Icelandic sagas, waterfalls, natural landscapes'],
            ['day' => 'DAY 3', 'destination' => 'Snaefellsnes Peninsula', 'drive_time' => '5 hours', 'distance' => '300 kms', 'image' => '../assets/images/locations/iceland/itineray/3.png', 'highlights' => 'Snaefellsnes Peninsula, Djupalonssandur, Arnarstapi, Hellnar and Vatnshellir Lava Cave.'],
            ['day' => 'DAY 4', 'destination' => 'Golden Circle', 'drive_time' => '5 hours', 'distance' => '300 kms', 'image' => '../assets/images/locations/iceland/itineray/4.png', 'highlights' => 'Thingvellir National Park, Geysir, Gullfoss and the spectacular Stokkur geyser.'],
            ['day' => 'DAY 5', 'destination' => 'Landmannalaugar', 'drive_time' => '4 hours', 'distance' => '200 kms', 'image' => '../assets/images/locations/iceland/itineray/5.png', 'highlights' => 'Fjosardalur Valley, Landmannalaugar, colourful mountains, geothermal landscapes'],
            ['day' => 'DAY 6', 'destination' => 'South Coast', 'drive_time' => '4 hours', 'distance' => '300 kms', 'image' => '../assets/images/locations/iceland/itineray/6.png', 'highlights' => 'Seljalandsfoss, Skogafoss, Myrdalur, Solheimasandur and dramatic coastal rock formations.'],
            ['day' => 'DAY 7', 'destination' => 'Skaftafell & Jokulsarlon', 'drive_time' => '2 hours', 'distance' => '100 kms', 'image' => '../assets/images/locations/iceland/itineray/7.png', 'highlights' => 'Skaftafell National Park, glacier landscapes, Jokulsarlon Iceberg Lagoon and Diamond Beach'],
            ['day' => 'DAY 8', 'destination' => 'Reykjanes & Blue Lagoon', 'drive_time' => '6 hours', 'distance' => '500 kms', 'image' => '../assets/images/locations/iceland/itineray/8.png', 'highlights' => 'Return towards Reykjanes, volcanic landscapes, lava fields'],
            ['day' => 'DAY 9', 'destination' => 'Fly Out', 'drive_time' => '1 hour', 'distance' => '50 kms', 'image' => '../assets/images/locations/iceland/itineray/9.png', 'highlights' => '']
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit!'
    ]
];

// Get destination data or default to Poland
$dest = isset($destinations[$destination]) ? $destinations[$destination] : $destinations['poland'];

// Add a modifier class for destinations where the theme text is visually longer
$destinationKey = $destination;
$themeClasses = 'destination-theme';
if (in_array($destinationKey, ['scotland', 'uae_and_oman'])) {
    $themeClasses .= ' destination-theme--compact';
}

$page_title = 'Luxury Self-Drive Destinations | Global Road Trip Journeys';
$meta_description = 'Explore luxury self-drive destinations across Oman, UAE, Ireland, Scotland and Sri Lanka. Discover curated road trips and seamless travel journeys.';
$meta_keywords = 'self drive destinations, luxury travel destinations, global road trip journeys, scenic driving routes, curated travel locations, adventure travel destinations, international road trip routes, bucket list journeys';
include 'includes/header.php';
?>

<!-- Destination Hero Section -->
<section class="destination-hero">
    <div class="destination-hero-background">
        <img src="<?php echo $dest['hero_image']; ?>" alt="<?php echo $dest['name']; ?>" class="destination-hero-image" loading="eager" fetchpriority="high">
    </div>
    <div class="destination-hero-overlay"></div>
    <div class="container">
        <div class="destination-hero-content">
            <p class="<?php echo $themeClasses; ?>"><?php echo $dest['theme']; ?></p>
            <h1 class="destination-name"><?php echo $dest['name']; ?></h1>
        </div>
    </div>
</section>

<!-- Destination Content Section -->
<section class="destination-content">
    <div class="container">
        <div class="destination-text-content">
            <?php 
            if (is_array($dest['content'])) {
                foreach ($dest['content'] as $paragraph): 
            ?>
                <p><?php echo $paragraph; ?></p>
            <?php 
                endforeach;
            } else {
                // Handle string content
            ?>
                <p><?php echo $dest['content']; ?></p>
            <?php 
            }
            ?>
        </div>
    </div>
</section>

<!-- Trip Information Cards Section -->
<?php if (isset($dest['trip_info'])): ?>
    <section class="trip-info-section">
        <div class="trip-info-background">
            <img src="<?php echo isset($dest['background_image']) ? $dest['background_image'] : 'assets/images/homepage/poland_memories_hp.png'; ?>" alt="Background" class="trip-info-bg-image" loading="lazy">
        </div>
        <div class="container">
            <div class="trip-info-customize">
                <p>Here is an idea of how it can work</p>
            </div>
            <div class="trip-info-grid">
                <?php foreach ($dest['trip_info'] as $info): ?>
                    <div class="trip-info-card">
                        <div class="trip-info-icon">
                            <img src="<?php echo $info['icon']; ?>" alt="<?php echo $info['title']; ?>" loading="lazy">
                        </div>
                        <h3 class="trip-info-title"><?php echo $info['title']; ?></h3>
                        <p class="trip-info-description"><?php echo $info['description']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="trip-info-customize">
                <p>and THAT'S NOT ALL...Everything can be customized</p>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Itinerary Section -->
<?php if (isset($dest['itinerary'])): ?>
    <section class="itinerary-section">
        <div class="container">
            <div class="itinerary-slider-wrapper">
                <div class="itinerary-slider">
                    <?php foreach ($dest['itinerary'] as $index => $day): ?>
                        <div class="itinerary-day-card <?php echo ($index == 0) ? 'active' : ''; ?>">
                            <div class="itinerary-day-header">
                                <h3><?php echo $day['day']; ?></h3>
                            </div>
                            <div class="itinerary-day-image">
                                <img src="<?= $day['image'] ?>" alt="<?php echo $day['destination']; ?>" loading="lazy">
                            </div>
                            <div class="itinerary-day-content">
                                <div class="itinerary-detail">
                                    <span class="itinerary-label">DESTINATION:</span>
                                    <span class="itinerary-value"><?php echo $day['destination']; ?></span>
                                </div>
                                <?php if (!empty($day['drive_time'])): ?>
                                    <div class="itinerary-detail">
                                        <span class="itinerary-label">DRIVE TIME:</span>
                                        <span class="itinerary-value"><?php echo $day['drive_time']; ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($day['distance'])): ?>
                                    <div class="itinerary-detail">
                                        <span class="itinerary-label">DISTANCE COVERED:</span>
                                        <span class="itinerary-value"><?php echo $day['distance']; ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($day['highlights'])): ?>
                                    <div class="itinerary-detail">
                                        <span class="itinerary-label"><?php echo (isset($day['highlights']) && strpos($day['highlights'], 'Highlights of the day') !== false) ? 'HIGHLIGHTS OF THE DAY:' : 'HIGHLIGHTS:'; ?></span>
                                        <span class="itinerary-value"><?php echo $day['highlights']; ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="itinerary-nav">
                    <button class="itinerary-nav-arrow itinerary-nav-arrow-left" aria-label="Previous day">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        :         <path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="itinerary-nav-arrow itinerary-nav-arrow-right" aria-label="Next day">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 18l6-6-6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<!-- Inclusions & Additional Services Section -->
<section class="inclusions-services-section">
    <div class="inclusions-services-background">
        <img src="<?php echo isset($dest['background_image']) ? $dest['background_image'] : 'assets/images/homepage/poland_memories_hp.png'; ?>" alt="Background" class="inclusions-services-bg-image" loading="lazy">
    </div>
    <div class="container">
        <div class="inclusions-services-grid">
            <!-- Inclusions Box -->
            <div class="info-box inclusions-box">
                <h2 class="info-box-title">What we always promise</h2>
                <p class="info-box-intro">Every detail is taken care of for a worry-free drive experience:</p>
                <ul class="info-box-list">
                    <li>Premium Car</li>
                    <li>Handpicked Hotels</li>
                    <li>All Meals</li>
                    <li>Fuel</li>
                    <li>Airport Pickup</li>
                    <li>Support & Lead Car</li>
                    <li>Always accompanied by the Co-Founders of DriveOffGrid</li>
                </ul>
            </div>

            <!-- Additional Services Box -->
            <div class="info-box services-box">
                <h2 class="info-box-title">Additional Services</h2>
                <p class="info-box-text">This is your journey, we make it extraordinary. From custom experiences to surprise detours, everything can be curated as per your personal travel style. With us, the sky truly is the limit.</p>
            </div>
        </div>

        <!-- Call-to-Action Buttons -->
        <?php
        // Enquiry-form dropdown values use hyphens; destination keys use underscores.
        $trip_slug_map = [
            'uae_and_oman'         => 'uae-oman',
            'ireland_scotland'     => 'ireland-scotland',
            'russia_artic'         => 'russia-artic',
            'russia_luxe_corridor' => 'russia-luxe',
        ];
        // Resolve against the known destination list so a bogus ?dest= can't reach the markup.
        $validDestination = isset($destinations[$destination]) ? $destination : 'poland';
        $trip_slug = isset($trip_slug_map[$validDestination]) ? $trip_slug_map[$validDestination] : $validDestination;
        // /galleries/<slug> resolves for every destination; "<slug>/memories" only has
        // rewrite rules for some, so Mongolia/Tibet/Iceland 404 on that form.
        $memories_url = 'galleries/' . $trip_slug;
        ?>
        <div class="cta-buttons" id="book-your-trip">
            <a href="<?php echo url_path('contact-us?trip=' . urlencode($trip_slug)); ?>" class="btn btn-book-trip">BOOK YOUR TRIP TO <?php echo $dest['name']; ?> NOW</a>
            <a href="<?php echo url_path($memories_url); ?>" class="btn btn-memories">TAKE ME TO THE MEMORIES OF <?php echo $dest['name']; ?></a>
        </div>
        <div class="destination-disclaimer">
            <h2 class="destination-disclaimer-title">Important Disclaimer</h2>

            <h3 class="destination-disclaimer-heading">Third-Party Activities &amp; Experiences</h3>
            <p>DriveOffGrid may offer or facilitate optional activities and experiences through independent third-party service providers. Participation in these activities is entirely optional and at the participant’s own discretion and risk. While DriveOffGrid may coordinate with and recommend trusted service providers, these activities are operated and managed independently by third parties. DriveOffGrid is not responsible or liable for any injury, loss, damage, delay, cancellation or other incident arising from participation in such activities, except to the extent such liability cannot be excluded under applicable law.</p>

            <h3 class="destination-disclaimer-heading">Self-Drive &amp; Driving Responsibility</h3>
            <p>DriveOffGrid journeys are self-drive experiences, and each participant is solely responsible for the safe and responsible operation of their vehicle throughout the journey. Any route guidance, safety instructions or advisories provided by the DriveOffGrid team or expedition leader are intended as guidance and do not transfer responsibility for driving to DriveOffGrid. Participants are responsible for exercising their own judgement, maintaining appropriate speed and control, and complying with all applicable traffic laws and safety requirements. DriveOffGrid shall not be responsible or liable for any accident, injury, loss, damage, traffic violation or other consequence arising from a participant’s operation of their vehicle, including failure to follow safety instructions or driving in an unsafe manner, except to the extent such liability cannot be excluded under applicable law.</p>
        </div>
    </div>
</section>

<script>
(function() {
    'use strict';
    
    // Function to equalize alignment by adjusting font sizes
    // Makes smaller text bigger and larger text smaller so they align
    function equalizeDestinationAlignment() {
        const themeElement = document.querySelector('.destination-theme');
        const nameElement = document.querySelector('.destination-name');
        
        if (!themeElement || !nameElement) return;
        
        // Reset font sizes to CSS defaults first
        themeElement.style.fontSize = '';
        nameElement.style.fontSize = '';
        
        // Force a reflow to get accurate measurements
        void themeElement.offsetWidth;
        void nameElement.offsetWidth;
        
        // Helper function to measure actual text width accurately
        function measureTextWidth(element) {
            const text = element.textContent.trim();
            if (!text) return 0;
            
            // Use Range API to measure the actual text node width
            const range = document.createRange();
            const textNode = element.firstChild;
            
            if (textNode && textNode.nodeType === Node.TEXT_NODE) {
                range.selectNodeContents(element);
                const rect = range.getBoundingClientRect();
                return rect.width;
            }
            
            // Fallback: use computed style approach
            const style = window.getComputedStyle(element);
            
            // Create a temporary span with exact same styling to measure text width
            const tempSpan = document.createElement('span');
            tempSpan.textContent = text;
            tempSpan.style.position = 'absolute';
            tempSpan.style.visibility = 'hidden';
            tempSpan.style.whiteSpace = 'nowrap';
            tempSpan.style.top = '-9999px';
            tempSpan.style.left = '-9999px';
            tempSpan.style.fontSize = style.fontSize;
            tempSpan.style.fontWeight = style.fontWeight;
            tempSpan.style.fontFamily = style.fontFamily;
            tempSpan.style.fontStyle = style.fontStyle;
            tempSpan.style.textTransform = style.textTransform;
            tempSpan.style.letterSpacing = style.letterSpacing;
            tempSpan.style.padding = '0';
            tempSpan.style.margin = '0';
            tempSpan.style.border = '0';
            tempSpan.style.lineHeight = style.lineHeight;
            
            document.body.appendChild(tempSpan);
            const width = tempSpan.getBoundingClientRect().width;
            document.body.removeChild(tempSpan);
            return width;
        }
        
        // Smallest the theme line may be scaled to before we stop honouring the
        // name's CSS size and simply fit the container instead.
        const MIN_THEME_FONT_PX = 24;

        // Width/font-size the element would have from CSS alone, ignoring any
        // inline size this script has already applied.
        function measureNaturalSize(element) {
            const inlineFontSize = element.style.fontSize;
            element.style.fontSize = '';
            void element.offsetWidth;
            const natural = {
                width: measureTextWidth(element),
                fontSize: parseFloat(window.getComputedStyle(element).fontSize)
            };
            element.style.fontSize = inlineFontSize;
            void element.offsetWidth;
            return natural;
        }

        function measureNaturalWidth(element) {
            return measureNaturalSize(element).width;
        }

        // Measure initial text widths
        let themeWidth = measureTextWidth(themeElement);
        let nameWidth = measureTextWidth(nameElement);
        
        // Get computed styles
        const themeStyle = window.getComputedStyle(themeElement);
        const nameStyle = window.getComputedStyle(nameElement);
        
        // Get current font sizes in pixels
        let themeFontSize = parseFloat(themeStyle.fontSize);
        let nameFontSize = parseFloat(nameStyle.fontSize);
        
        // Store original font sizes
        const originalThemeFontSize = themeFontSize;
        const originalNameFontSize = nameFontSize;
        
        // Calculate target width (use the wider one)
        const targetWidth = Math.max(themeWidth, nameWidth);
        
        // Binary search approach to find exact font sizes
        function adjustFontSizeToTarget(element, currentWidth, currentFontSize, targetWidth, maxIterations = 10) {
            let minFontSize = currentFontSize * 0.5; // Can shrink to 50%
            let maxFontSize = currentFontSize * 3.0;  // Can grow to 300%
            let bestFontSize = currentFontSize;
            let bestWidth = currentWidth;
            let bestDiff = Math.abs(currentWidth - targetWidth);
            
            for (let i = 0; i < maxIterations; i++) {
                const testFontSize = (minFontSize + maxFontSize) / 2;
                element.style.fontSize = testFontSize + 'px';
                void element.offsetWidth; // Force reflow
                
                const testWidth = measureTextWidth(element);
                const testDiff = Math.abs(testWidth - targetWidth);
                
                if (testDiff < bestDiff) {
                    bestDiff = testDiff;
                    bestFontSize = testFontSize;
                    bestWidth = testWidth;
                }
                
                if (testWidth < targetWidth) {
                    minFontSize = testFontSize;
                } else {
                    maxFontSize = testFontSize;
                }
                
                // If we're very close, break early
                if (testDiff < 0.5) {
                    break;
                }
            }
            
            element.style.fontSize = bestFontSize + 'px';
            void element.offsetWidth;
            return { fontSize: bestFontSize, width: bestWidth };
        }
        
        // Adjust both elements to match target width
        // If theme is smaller, make it bigger; if name is larger, make it smaller
        if (themeWidth < targetWidth && nameWidth >= targetWidth) {
            // Only theme needs to grow
            const result = adjustFontSizeToTarget(themeElement, themeWidth, themeFontSize, targetWidth);
            themeWidth = result.width;
        } else if (nameWidth > targetWidth && themeWidth <= targetWidth) {
            // Only name needs to shrink
            const result = adjustFontSizeToTarget(nameElement, nameWidth, nameFontSize, targetWidth);
            nameWidth = result.width;
        } else {
            // Both need adjustment - adjust both to meet in the middle
            const midTarget = (themeWidth + nameWidth) / 2;
            
            if (themeWidth < midTarget) {
                const result = adjustFontSizeToTarget(themeElement, themeWidth, themeFontSize, midTarget);
                themeWidth = result.width;
            }
            
            if (nameWidth > midTarget) {
                const result = adjustFontSizeToTarget(nameElement, nameWidth, nameFontSize, midTarget);
                nameWidth = result.width;
            }
        }
        
        // Final fine-tuning: ensure both are exactly the same width
        const finalTarget = Math.max(themeWidth, nameWidth);
        
        // Re-measure current widths
        themeWidth = measureTextWidth(themeElement);
        nameWidth = measureTextWidth(nameElement);
        themeFontSize = parseFloat(window.getComputedStyle(themeElement).fontSize);
        nameFontSize = parseFloat(window.getComputedStyle(nameElement).fontSize);
        
        if (Math.abs(themeWidth - finalTarget) > 0.5) {
            const result = adjustFontSizeToTarget(themeElement, themeWidth, themeFontSize, finalTarget, 8);
            themeWidth = result.width;
        }
        
        if (Math.abs(nameWidth - finalTarget) > 0.5) {
            const result = adjustFontSizeToTarget(nameElement, nameWidth, nameFontSize, finalTarget, 8);
            nameWidth = result.width;
        }

        // Keep the equalised block inside the hero container.
        //
        // .destination-hero is a flex container, so .container is a flex item
        // with the default min-width:auto and cannot shrink below its
        // min-content width. Both lines are white-space:nowrap, so their
        // min-content width IS the full text width - an oversized line stretches
        // .container to match it. Measuring .container (or its child) would
        // therefore just report the oversized width straight back and the guard
        // below would never fire. Derive the width .container is *meant* to have
        // from the hero section, which never grows, plus the container's own
        // max-width and horizontal padding.
        const heroContent = nameElement.parentElement;
        const containerEl = heroContent ? heroContent.parentElement : null;
        const heroSection = nameElement.closest('.destination-hero');
        let availableWidth = 0;

        if (containerEl && heroSection) {
            const containerStyle = window.getComputedStyle(containerEl);
            const paddingX = (parseFloat(containerStyle.paddingLeft) || 0) +
                             (parseFloat(containerStyle.paddingRight) || 0);
            const maxWidth = parseFloat(containerStyle.maxWidth);
            const outerWidth = Math.min(
                heroSection.clientWidth,
                isNaN(maxWidth) ? Infinity : maxWidth
            );
            availableWidth = Math.max(0, outerWidth - paddingX);
        }

        const widestWidth = Math.max(themeWidth, nameWidth);

        // A very long theme paired with a short name (e.g. Tibet) matches at a
        // width wider than the page. Only then do we intervene - every other
        // destination already settles well inside the container and is left
        // exactly as the equalising pass produced it.
        if (availableWidth > 0 && widestWidth > availableWidth) {
            // Prefer to land on the name's own CSS size rather than merely
            // fitting the container: matching a long theme would otherwise
            // inflate the name far beyond every other destination's hero and
            // run it off the bottom of the section. The theme shrinks instead.
            const naturalNameWidth = measureNaturalWidth(nameElement);
            const naturalTheme = measureNaturalSize(themeElement);

            // ...but keep the theme readable. If honouring the name's size
            // would push the theme under MIN_THEME_FONT_PX (which happens on
            // narrow screens, where the name's CSS size is small), fall back to
            // whatever the container allows.
            const minThemeWidth = naturalTheme.fontSize > 0
                ? naturalTheme.width * (MIN_THEME_FONT_PX / naturalTheme.fontSize)
                : 0;

            const targetWidth = Math.min(
                availableWidth,
                Math.max(naturalNameWidth, minThemeWidth)
            );

            const fitScale = targetWidth / widestWidth;
            themeElement.style.fontSize = (parseFloat(window.getComputedStyle(themeElement).fontSize) * fitScale) + 'px';
            nameElement.style.fontSize = (parseFloat(window.getComputedStyle(nameElement).fontSize) * fitScale) + 'px';
        }
    }
    
    // Run on page load
    function initAlignment() {
        // Wait for fonts and layout to be ready
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(function() {
                setTimeout(equalizeDestinationAlignment, 150);
            });
        } else {
            setTimeout(equalizeDestinationAlignment, 400);
        }
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAlignment);
        window.addEventListener('load', equalizeDestinationAlignment);
    } else {
        initAlignment();
        window.addEventListener('load', equalizeDestinationAlignment);
    }
    
    // Recalculate on window resize (with debounce)
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(equalizeDestinationAlignment, 300);
    });
})();
</script>

<?php include 'includes/footer.php'; ?>