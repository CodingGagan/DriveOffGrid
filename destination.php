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
        'hero_image' => 'assets/images/homepage/banner-image.png',
        'background_image' => '/assets/images/banner_location_page/ireland.png',
        'content' => [
            'Ireland’s Wild Atlantic edge is where land, sea, and soul collide. This drive takes you along windswept cliffs, emerald meadows, ancient stone walls, and coastal roads sculpted by centuries of storm and salt. Charming villages, lively pubs, and a spirit of storytelling bring warmth to the ruggedness. Ireland’s beauty is not loud — it’s lyrical. It’s in the mist that softens the morning, the waves that shape the coast, and the landscapes that feel alive with memory. The Wild Atlantic way is more than a route — it’s an emotion.'
        ],
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '9 days / 8 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '4 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,700 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => '4x4 SUV'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Mountain Drives, Coastal & Cliff Trails'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'INR TBD']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Dublin - Cobh',
                'drive_time' => '3.25 hours',
                'distance' => '286 kms',
                'image' => 'assets/images/locations/ireland/ireland-day-1.webp',
                'highlights' => 'Titanic Experience'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Cobh - Kilarney',
                'drive_time' => '3 hours',
                'distance' => '200 kms',
                'image' => 'assets/images/locations/ireland/ireland-day-2.webp',
                'highlights' => 'Healy Pass'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Kilarney - Ashford',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => 'assets/images/locations/ireland/ireland-day-3.webp',
                'highlights' => 'Cliffs of Moher'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Ashford - Ashford',
                'drive_time' => '2 hours',
                'distance' => '100 kms',
                'image' => 'assets/images/locations/ireland/ireland-day-4.webp',
                'highlights' => 'Sheep Farm'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Ashford - Lough Eske',
                'drive_time' => '4 hours',
                'distance' => '270 kms',
                'image' => 'assets/images/locations/ireland/ireland-day-5.webp',
                'highlights' => 'Downpatrick Head'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Lough Eske - Ballygally',
                'drive_time' => '5 hours',
                'distance' => '280 kms',
                'image' => 'assets/images/locations/ireland/ireland-day-6.webp',
                'highlights' => 'Malin Head, Giant\'s Causeway, Carrick Rope Bridge'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Ballygally - Dublin',
                'drive_time' => '4 hours',
                'distance' => '265.6 kms',
                'image' => 'assets/images/locations/ireland/ireland-day-7.webp',
                'highlights' => 'Castle Ward, Guinness Store House'
            ]
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ],
    'norway' => [
        'name' => 'Norway',
        'theme' => 'Fjord & Flame',
        'hero_image' => '/assets/images/banner_location_page/norway.png',
        'background_image' => 'assets/images/homepage/poland_memories_hp.png',
        'content' => [
            'Norway is a land sculpted by ice, fire, and time — a place where landscapes rise in dramatic silence and every bend in the road feels like a revelation. This expedition takes you through majestic fjords, snow-capped peaks, mirror-like lakes, and coastal stretches washed in the glow of the midnight sun. From the quiet charm of Nordic villages to the raw power of nature at its purest, Norway offers a drive that feels both grounding and otherworldly. It’s a journey of contrasts — cold blues and warm golds, towering cliffs and gentle valleys — a place where the road becomes a ribbon between earth and sky.'
        ],
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '9 days / 8 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '4 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,040 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => '4x4 SUV'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Mountain Passes, Fjord Roads, Coastal Highways, Alpine Valleys, Scenic Tunnels & Off-road Trails'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Curated Stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'INR TBD']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Arrive in Oslo',
                'drive_time' => '',
                'distance' => '',
                'highlights' => 'Local Oslo sightseeing'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Oslo - Solvornvegen',
                'drive_time' => '5.5 hours',
                'distance' => '325 kms',
                'image' => 'assets/images/locations/norway/norway-day-2.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Solvornvegen - Tessanden',
                'drive_time' => '',
                'distance' => '',
                'image' => 'assets/images/locations/norway/norway-day-3.webp',
                'highlights' => 'Via Sognefillet'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Tessanden - Molde',
                'drive_time' => '5.25 hours',
                'distance' => '300 kms',
                'image' => 'assets/images/locations/norway/norway-day-4.webp',
                'highlights' => 'Via Bud and Atlantic Highway'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Molde - Grotli',
                'drive_time' => '',
                'distance' => '',
                'image' => 'assets/images/locations/norway/norway-day-5.webp',
                'highlights' => 'Via Trollstigen and Dalsnibba'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Grotli - Skulestadmo',
                'drive_time' => '5.5 hours',
                'distance' => '335 kms',
                'image' => 'assets/images/locations/norway/norway-day-6.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Skulestadmo - Handanger',
                'drive_time' => '',
                'distance' => '',
                'image' => 'assets/images/locations/norway/norway-day-7.webp',
                'highlights' => 'Stay by the fjord and Kayak / Cruise'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Handanger - Bergen',
                'drive_time' => '1.5 hours',
                'distance' => '80 kms',
                'image' => 'assets/images/locations/norway/norway-day-8.webp',
                'highlights' => 'Explore Bergen'
            ]
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ],
    'poland' => [
        'name' => 'POLAND',
        'theme' => 'ECHOES OF TIME',
        'hero_image' => '/assets/images/banner_location_page/poland.png',
        'background_image' => 'assets/images/homepage/poland_memories_hp.png',
        'content' => [
            'A journey through Poland is a journey through layers of history, resilience, and quiet beauty. From the timeless cobblestones of Krakow to the haunting stillness of Auschwitz, from medieval castles to serene lakes and thriving modern cities, every mile reveals a <span class="highlight-text">country shaped by both tragedy and triumph</span>.',
            'This expedition takes you through landscapes where stories linger in the air baroque facades, forgotten villages, forest-lined roads, and vibrant cultural corners waiting to be rediscovered. It\'s a drive that <span class="highlight-text">connects the past and present</span>, inviting you to witness a nation that continues to rise, rebuild, and redefine itself.',
            '<span class="highlight-text">In Poland, every turn whispers an echo, and every echo becomes part of your own journey.</span>'
        ],
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '5 days / 4 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '4 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,190 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'SUV 4x4 (Automatic)'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Highways, historic towns, river routes, mountain roads, scenic countryside'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Premium & boutique stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'INR 3,50,000 upwards/person']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Warsaw - Warsaw',
                'drive_time' => '0',
                'distance' => '0',
                'highlights' => 'Warsaw Sight Seeing'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Warsaw - Oswiecim',
                'drive_time' => '4.5 hours',
                'distance' => '365 kms',
                'image' => 'assets/images/locations/poland/poland-day-2.webp',
                'highlights' => 'Arts Centre in Manufaktura, Lodz'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Oswiecim - Krakow',
                'drive_time' => '2 hours',
                'distance' => '80 kms',
                'image' => 'assets/images/locations/poland/poland-day-3.webp',
                'highlights' => 'Auschwitz Museum'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Krakow - Tatra Mountains',
                'drive_time' => '3.5 hours',
                'distance' => '185 kms',
                'image' => 'assets/images/locations/poland/poland-day-4.webp',
                'highlights' => 'Salt Mine Wieliczka'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Tatra Mountains - Szczawnica',
                'drive_time' => '3.25 hours',
                'distance' => '172 kms',
                'image' => 'assets/images/locations/poland/poland-day-5.webp',
                'highlights' => 'Dunajec River Gorge'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Szczawnica - Warsaw',
                'drive_time' => '4.75 hours',
                'distance' => '388 kms',
                'image' => 'assets/images/locations/poland/poland-day-6.webp',
                'highlights' => 'Majdanek State Museum'
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ],
    'scotland' => [
        'name' => 'Scotland',
        'theme' => 'Loch & Glen',
        'hero_image' => '/assets/images/banner_location_page/scotland.png',
        'background_image' => 'assets/images/homepage/poland_memories_hp.png',
        'content' => [
            'Scotland is a living tapestry of mist, myth, and majestic wilderness. On this expedition, winding single-track roads lead you through brooding glens, serene lochs, and windswept highlands that feel untouched by time. Castles stand like ancient sentinels, whisky distilleries warm the soul, and every village carries stories older than its stones. Dramatic skies, haunting beauty, and a raw, unfiltered sense of freedom define this drive. Scotland isn’t just scenery — it’s atmosphere, emotion, and the kind of stillness that stays with you long after the journey ends.'
        ],
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '8 days / 7 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '6 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,400 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'Land Rover Defender 110'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Mountain Drives, Coastal & Cliff Trails'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'INR TBD']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Edinburgh - Ballachulish',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => 'assets/images/locations/scotland/scotland-day-1.webp',
                'highlights' => 'Shaken not Stirred'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Ballachulish - Isle of Skye',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => 'assets/images/locations/scotland/scotland-day-2.webp',
                'highlights' => 'Witness the Magical Hogwartrs Express'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Isle of Skye - Inverness',
                'drive_time' => '3.5 hours',
                'distance' => '250 kms',
                'image' => 'assets/images/locations/scotland/scotland-day-3.webp',
                'highlights' => 'Marvels of Isle of Skye'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Inverness - Inverness',
                'drive_time' => '1 hours',
                'distance' => '50 kms',
                'image' => 'assets/images/locations/scotland/scotland-day-4.webp',
                'highlights' => 'Experience Loch Legends'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Inverness - Pitlochry',
                'drive_time' => '5 hours',
                'distance' => '300 kms',
                'image' => 'assets/images/locations/scotland/scotland-day-5.webp',
                'highlights' => 'Scotch Trail'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Inverness - Edinburgh',
                'drive_time' => '3.5 hours',
                'distance' => '225 kms',
                'image' => 'assets/images/locations/scotland/scotland-day-6.webp',
                'highlights' => 'Witness the legacy of Golf'
            ],

        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ],
    'uae_and_oman' => [
        'name' => 'UAE & Oman',
        'theme' => 'Jebel Wadi',
        'hero_image' => '/assets/images/banner_location_page/uae.png',
        'background_image' => 'assets/images/homepage/poland_memories_hp.png',
        'content' => [
            'Across the empty deserts and towering mountain ranges of the Arabian Peninsula lies a world of stark beauty and timeless stillness. This expedition takes you from futuristic skylines and pristine highways to rugged wadis, canyons, and dune-kissed horizons that feel endless. The silence of the desert, the drama of the rocky cliffs, the warmth of remote villages, and the majesty of desert nights under a billion stars create a journey that’s both humbling and exhilarating. In the UAE and Oman, nature is vast, culture is deep, and the road invites you to explore both.'
        ],
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '9 days / 8 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '8 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 2,000 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'Land Cruiser 4x4'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Mountain Drives, Coastal Roads, Desert Crossings, Off-road trails'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Car / Hotel / Food / Fuel / Airport Pickup / Support & Lead Car / Always accompanied by Co-Founders of DriveOffGrid'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'TBD']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Dubai - Al Aqah',
                'drive_time' => '3.75 hours',
                'distance' => '280 kms',
                'image' => 'assets/images/locations/uae/uae-day-1.webp',
                'highlights' => 'A gourmet above the clouds'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Al Aqah - Al Ain',
                'drive_time' => '3 hours',
                'distance' => '250 kms',
                'image' => 'assets/images/locations/uae/uae-day-2.webp',
                'highlights' => 'Beach Activities'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Al Ain - Muscat',
                'drive_time' => '5 hours',
                'distance' => '430 kms',
                'image' => 'assets/images/locations/uae/uae-day-3.webp',
                'highlights' => 'Cross-border drive'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Muscat - Muscat',
                'drive_time' => '1.5 hours',
                'distance' => '100 kms',
                'image' => 'assets/images/locations/uae/uae-day-4.webp',
                'highlights' => 'Local Sightseeing and Water Activities'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Muscat - Al Hamra',
                'drive_time' => '4.5 hours',
                'distance' => '240 kms',
                'image' => 'assets/images/locations/uae/uae-day-5.webp',
                'highlights' => 'Off-Roading'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Al Hamra - Jebel Akhdar',
                'drive_time' => '2 hours',
                'distance' => '115 kms',
                'image' => 'assets/images/locations/uae/uae-day-6.webp',
                'highlights' => 'Cultural Exploration'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Warsaw - Wahiba Sands',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => 'assets/images/locations/uae/uae-day-7.webp',
                'highlights' => 'Desert Drive'
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Wahiba Sands - Muscat',
                'drive_time' => '3.25 hours',
                'distance' => '275 kms',
                'image' => 'assets/images/locations/uae/uae-day-8.webp',
                'highlights' => 'Oasis Experience and onwards to the airport'
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ],
    'srilanka' => [
        'name' => 'Sri Lanka',
        'theme' => 'Serendipity',
        'hero_image' => '/assets/images/banner_location_page/srilanks.png',
        'background_image' => 'assets/images/homepage/scotland_memories_hp.png',
        'content' => [
            'Sri Lanka is an island where nature performs at every turn — from misty tea gardens and emerald highlands to golden beaches where the ocean comes alive. This expedition takes you through landscapes rich with culture and wildlife, offering rare encounters with majestic elephants in the wild and the thrill of watching blue whales rise from the depths of the Indian Ocean. Between ancient cities, rainforest trails, coastal drives, and warm island hospitality, every moment feels like a discovery. In Sri Lanka, magic isn’t hidden — it reveals itself gently, just when you least expect it.'
        ],
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '8 days / 7 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '6 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 800 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => '4x4 SUV / Luxury Sedan'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Coastal Roads, Open Jeep Safaris, Forest Trails, Scenic Highways'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'INR TBD']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Negombo - Mirassa',
                'drive_time' => '3 hours',
                'distance' => '190 kms',
                'image' => 'assets/images/locations/srilanka/srilanka-day-1.webp',
                'highlights' => 'Walk Through Heritage Sights'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Mirassa - Yala National Park',
                'drive_time' => '3 hours',
                'distance' => '150 kms',
                'image' => 'assets/images/locations/srilanka/srilanka-day-2.webp',
                'highlights' => 'Whale Watching Experience'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Yala National Park - Yala National Park',
                'drive_time' => '0 hours',
                'distance' => '0 kms',
                'image' => 'assets/images/locations/srilanka/srilanka-day-3.webp',
                'highlights' => 'Wild Life Open Jeep Safaris'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Yala National Park - Kadruketha',
                'drive_time' => '3.5 hours',
                'distance' => '155 kms',
                'image' => 'assets/images/locations/srilanka/srilanka-day-4.webp',
                'highlights' => 'Experience the rustic charm of Sri Lanka'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Kadruketha - Nuwara Eliya',
                'drive_time' => '3 hours',
                'distance' => '100 kms',
                'image' => 'assets/images/locations/srilanka/srilanka-day-5.webp',
                'highlights' => 'Visit the picturesque hill station of Little Engalnd'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Nuwara Eliya - Negombo',
                'drive_time' => '5.5 hours',
                'distance' => '190 kms',
                'image' => 'assets/images/locations/srilanka/srilanka-day-6.webp',
                'highlights' => 'Riverside Lunch'
            ],

        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ],
    'oman' => [
        'name' => 'OMAN',
        'theme' => 'Golden Mirage',
        'hero_image' => '/assets/images/banner_location_page/oman.png',
        'background_image' => 'assets/images/homepage/srilanka_memories_hp.png',
        'content' => [
            'Oman’s desert has a way of making time slow down. Endless golden dunes, hidden wadis, date-laden oases, and ancient caravan routes form the backdrop of this expedition. Here, the horizon is a soft, shifting line; the silence is almost sacred. It’s a land where tradition and tranquility blend effortlessly. Driving through Oman feels like stepping into a mirage — real, surreal, and deeply calming. It’s a journey into stillness, into heritage, and into golden landscapes that glow long after the sun has set.'
        ],
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '5 days / 4 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '4 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,000 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'Land Cruiser 4x4'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Mountain Drives, Coastal Roads, Desert Crossings, Off-road trails'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'INR TBD']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Muscat – Jebel Akhdar',
                'drive_time' => '2.5 hours',
                'distance' => '125 kms',
                'image' => 'assets/images/locations/oman/oman-day-1.webp',
                'highlights' => 'Boat Cruise'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Jebel Akhdar – Al Hamra',
                'drive_time' => '2.5 hours',
                'distance' => '125 kms',
                'image' => 'assets/images/locations/oman/oman-day-2.webp',
                'highlights' => 'Nizwa Souk, Cultural Village'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Al Hamra – Wahiba Sands',
                'drive_time' => '4.5 hours',
                'distance' => '300 kms',
                'image' => 'assets/images/locations/oman/oman-day-3.webp',
                'highlights' => 'Desert Driving'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Wahiba Sands – Muscat',
                'drive_time' => '4.5 hours',
                'distance' => '320 kms',
                'image' => 'assets/images/locations/oman/oman-day-4.webp',
                'highlights' => 'Hot Air Balloon, Oasis Experience'
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ],
    'russia_artic' => [
        'name' => 'Russia',
        'theme' => 'Arctic Affair',
        'hero_image' => '/assets/images/banner_location_page/russia arctic.png',
        'background_image' => 'assets/images/homepage/scotland_memories_hp.png',
        'content' => [
            'From imperial elegance to Arctic wonder, this expedition is a dance between culture and wilderness. Starting in the grandeur of St. Petersburg, the road takes you north through sleepy villages, frozen forests, and vast, untouched tundra. As the landscape shifts into a world of snow and silence, the Arctic reveals its own kind of romance — stark, mesmerizing, and mysterious. This is a journey of northern lights, icy expanses, and the thrill of reaching the edge of the world.'
        ],
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '10 days / 9 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '6 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 1,800 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'GWM Tank 500'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Snow and Forest Drives'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'INR TBD']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'Moscow - Lake Seligar',
                'drive_time' => '6 hours',
                'distance' => '385 kms',
                'image' => 'assets/images/locations/russia_artic/russia_artic-day-1.webp',
                'highlights' => 'Boat Cruise'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Lake Seligar - Veliky Novgorod',
                'drive_time' => '5 hours',
                'distance' => '320 kms',
                'image' => 'assets/images/locations/russia_artic/russia_artic-day-2.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Veliky Novgorod - Upper Mandrogi',
                'drive_time' => '6 hours',
                'distance' => '340 kms',
                'image' => 'assets/images/locations/russia_artic/russia_artic-day-3.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Upper Mandrogi - Petro Zavodsk',
                'drive_time' => '4 hours',
                'distance' => '250 kms',
                'image' => 'assets/images/locations/russia_artic/russia_artic-day-4.webp',
                'highlights' => 'Horse Sledding'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Petro Zavodsk - Petro Zavodsk',
                'drive_time' => '1.5 hours',
                'distance' => '70 kms',
                'image' => 'assets/images/locations/russia_artic/russia_artic-day-5.webp',
                'highlights' => 'Kizhi Island Adventures'
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Petro Zavodsk - Sortavala',
                'drive_time' => '3 hours',
                'distance' => '160 kms',
                'image' => 'assets/images/locations/russia_artic/russia_artic-day-6.webp',
                'highlights' => 'Dog Sled'
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Sortavala - St. Petersburg',
                'drive_time' => '5 hours',
                'distance' => '270 kms',
                'image' => 'assets/images/locations/russia_artic/russia_artic-day-7.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'St. Petersburg - St. Petersburg',
                'drive_time' => '',
                'distance' => '',
                'image' => 'assets/images/locations/russia_artic/russia_artic-day-8.webp',
                'highlights' => ''
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ],
    'russia_luxe_corridor' => [
        'name' => 'Russia',
        'theme' => 'Luxe Corridor',
        'hero_image' => '/assets/images/banner_location_page/russia luxe.png',
        'background_image' => 'assets/images/homepage/scotland_memories_hp.png',
        'content' => 'This expedition is a passage through Russia’s cultural crown — a road that links two legendary cities, each with its own identity and grandeur. From Moscow’s bold architecture and electric energy to St. Petersburg’s imperial charm and artistic soul, the journey flows through a corridor rich in history, opulence, and elegance. Palaces, museums, forests, and story-laden villages line your route, creating a drive that feels both regal and modern. The Luxe Corridor is where luxury meets legacy.',
        'trip_info' => [
            'duration' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'DURATION', 'description' => '11 days / 10 nights'],
            // 'days_on_road' => ['icon' => 'assets/images/icons/days_on_the_road.png', 'title' => 'DAYS ON THE ROAD', 'description' => '6 days'],
            'distance' => ['icon' => 'assets/images/icons/distance.png', 'title' => 'DISTANCE', 'description' => '~ 2,200 kms'],
            'vehicle' => ['icon' => 'assets/images/icons/vechicle.png', 'title' => 'VEHICLE', 'description' => 'GWM Tank 500'],
            'terrain' => ['icon' => 'assets/images/icons/terrain.png', 'title' => 'TERRAIN', 'description' => 'Urban Roads, Snow and Forest Drives'],
            'accommodation' => ['icon' => 'assets/images/icons/accomodation.png', 'title' => 'ACCOMMODATION', 'description' => 'Luxurious Stays'],
            // 'curate' => ['icon' => 'assets/images/icons/duration.png', 'title' => 'CURATE YOUR DRIVE', 'description' => 'Tailor the route, pace, stays, and experiences to match your travel style'],
            'price' => ['icon' => 'assets/images/icons/price.png', 'title' => 'PRICE', 'description' => 'INR TBD']
        ],
        'itinerary' => [
            [
                'day' => 'DAY 1',
                'destination' => 'St. Petersburg – Sortavala',
                'drive_time' => '6 hours',
                'distance' => '300 kms',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-1.webp',
                'highlights' => 'Ruskeala Mountain Park'
            ],
            [
                'day' => 'DAY 2',
                'destination' => 'Sortavala - Petro Zavodsk',
                'drive_time' => '3 hours',
                'distance' => '160 kms',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-2.webp',
                'highlights' => 'Dog Sled'
            ],
            [
                'day' => 'DAY 3',
                'destination' => 'Petro Zavodsk - Petro Zavodsk',
                'drive_time' => '6 hours',
                'distance' => '340 kms',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-3.webp',
                'highlights' => 'Kizhi Island Adventures'
            ],
            [
                'day' => 'DAY 4',
                'destination' => 'Petro Zavodsk - Segezha',
                'drive_time' => '6 hours',
                'distance' => '265 kms',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-4.webp',
                'highlights' => 'Volcano Crater'
            ],
            [
                'day' => 'DAY 5',
                'destination' => 'Segezha - Kirovsk',
                'drive_time' => '8 hours',
                'distance' => '570 kms',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-5.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 6',
                'destination' => 'Kirovsk - Kirovsk',
                'drive_time' => '0 hours',
                'distance' => '0 kms',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-6.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 7',
                'destination' => 'Kirovsk - Lapland Village',
                'drive_time' => '4 hours',
                'distance' => '230 kms',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-7.webp',
                'highlights' => ''
            ],
            [
                'day' => 'DAY 8',
                'destination' => 'Lapland Village - Lapland Village',
                'drive_time' => '5 hours',
                'distance' => '280 kms',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-8.webp',
                'highlights' => 'Vie Teriberka'
            ],
            [
                'day' => 'DAY 9',
                'destination' => 'Lapland Village - Lapland Village',
                'drive_time' => '',
                'distance' => '',
                'image' => 'assets/images/locations/russia_luxe_corridor/russia_luxe_corridor-day-9.webp',
                'highlights' => ''
            ],
        ],
        'inclusion' => ['Car', 'Hotel', 'Food', 'Fuel', 'Airport Pickup', 'Support & Lead Car', 'Always accompanied by Co-Founders of DriveOffGrid'],
        'additional_services' => 'Curated as per your requirements - the sky is the limit !'
    ]
];

// Get destination data or default to Poland
$dest = isset($destinations[$destination]) ? $destinations[$destination] : $destinations['poland'];

$page_title = $dest['name'] . " - DriveOffGrid";
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
            <p class="destination-theme"><?php echo $dest['theme']; ?></p>
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
                <p>and that's not all ... Everything can be customized</p>
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
                                <div class="itinerary-detail">
                                    <span class="itinerary-label"><?php echo (isset($day['highlights']) && strpos($day['highlights'], 'Highlights of the day') !== false) ? 'HIGHLIGHTS OF THE DAY:' : 'HIGHLIGHTS:'; ?></span>
                                    <span class="itinerary-value"><?php echo $day['highlights']; ?></span>
                                </div>
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
                <p class="info-box-text">This is your journey — we make it extraordinary. From custom experiences to surprise detours, everything can be curated as per your personal travel style. With us, the sky truly is the limit.</p>
            </div>
        </div>

        <!-- Call-to-Action Buttons -->
        <div class="cta-buttons">
            <a href="<?php echo url_path('contact_us'); ?>" class="btn btn-book-trip">BOOK YOUR TRIP TO <?php echo $dest['name']; ?> NOW</a>
            <?php
            // Generate memories URL based on destination
            $memories_url = '';
            if ($destination == 'uae_and_oman') {
                $memories_url = 'uae-oman/memories';
            } elseif ($destination == 'russia_artic') {
                $memories_url = 'russia-artic/memories';
            } elseif ($destination == 'russia_luxe_corridor') {
                $memories_url = 'russia-luxe/memories';
            } else {
                $memories_url = strtolower($destination) . '/memories';
            }
            ?>
            <a href="<?php echo url_path($memories_url); ?>" class="btn btn-memories">TAKE ME TO THE MEMORIES OF <?php echo $dest['name']; ?></a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>