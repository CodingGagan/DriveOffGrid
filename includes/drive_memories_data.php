<?php
/**
 * Shared data for Drive Ideas and Memories gallery pages.
 * Sourced from home content; kept in sync manually if home data changes.
 */
$drive_ideas = [
    'ireland' => [
        'name' => 'IRELAND',
        'theme' => 'Wild Atlantic',
        'hero_image' => 'assets/images/homepage/ireland_drive_idea_hp.png',
        'url' => 'ireland',
        'content' => 'Where wind, water, and ancient cliffs shape the spirit - a soulful drive along Ireland\'s untamed edge.'
    ],
    'norway' => [
        'name' => 'Norway',
        'theme' => 'Fjord & Flame',
        'hero_image' => 'assets/images/homepage/norway_drive_ideas_hp.png',
        'url' => 'norway',
        'content' => 'Where icy fjords meet the fire of the midnight sun - a drive through nature\'s most dramatic contrasts.'
    ],
    'poland' => [
        'name' => 'POLAND',
        'theme' => 'ECHOES OF TIME',
        'hero_image' => 'assets/images/homepage/poland_drive_ideas_hp.png',
        'url' => 'poland',
        'content' => 'A journey through living history, where cobbled streets, forgotten stories, and modern soul meet on the open road.'
    ],
    'scotland' => [
        'name' => 'Scotland',
        'theme' => 'Loch & Glen',
        'hero_image' => 'assets/images/homepage/scotland_drive_idea_hp.png',
        'url' => 'scotland',
        'content' => 'Misty lochs, rugged glens, and roads that whisper legends - a drive into Scotland\'s mysterious heart.'
    ],
    'uae_and_oman' => [
        'name' => 'UAE OMAN',
        'theme' => 'Jebel Wadi',
        'hero_image' => 'assets/images/homepage/uae_oman_drive_idea_hp.png',
        'url' => 'uae-oman',
        'content' => 'From towering peaks to endless desert wadis - a journey carved through landscapes older than time itself.'
    ],
    'srilanka' => [
        'name' => 'Sri Lanka',
        'theme' => 'Serendipity',
        'hero_image' => 'assets/images/homepage/srilanka_drive_idea_hp.png',
        'url' => 'srilanka',
        'content' => 'An island of unexpected wonders, lush mountains, coastal calm, and roads that reveal magic at every turn.'
    ],
    'oman' => [
        'name' => 'OMAN',
        'theme' => 'Golden Mirage',
        'hero_image' => 'assets/images/homepage/oman_drive_ideas_hp.png',
        'background_image' => 'assets/images/homepage/srilanka_memories_hp.png',
        'url' => 'oman',
        'content' => 'Golden dunes, hidden wadis, and timeless silence - a desert drive that feels both surreal and sacred.'
    ],
    'russia_artic' => [
        'name' => 'Russia',
        'theme' => 'Arctic Affair',
        'hero_image' => 'assets/images/homepage/russia_artic_drive_idea_hp.jpg',
        'background_image' => 'assets/images/homepage/russia_Artic_memories_hp.png',
        'url' => 'russia-artic',
        'content' => 'Chasing frozen horizons and northern lights - an affair with the Arctic you\'ll never forget.'
    ],
    'russia_luxe_corridor' => [
        'name' => 'Russia',
        'theme' => 'Luxe Corridor',
        'hero_image' => 'assets/images/homepage/russia_luxe_drive_idea_hp.png',
        'background_image' => 'assets/images/homepage/russia_memories_hp.png',
        'url' => 'russia-luxe',
        'content' => 'A regal passage through Russia\'s cultural crown, elegance, history, and grandeur woven into every mile.',
    ],
    'mongolia' => [
        'name' => 'MONGOLIA',
        'theme' => 'Steppe & Sky',
        'hero_image' => 'assets/images/locations/mongolia/homepage/mongolia.png',
        'url' => 'mongolia',
        'content' => 'Ancient capitals, endless steppes, golden dunes, and nomadic soul - a timeless road trip through the wild heart of Mongolia.'
    ],
    'tibet' => [
        'name' => 'TIBET',
        'theme' => 'Where Earth Meets the Sky',
        'hero_image' => 'assets/images/locations/tibet/homepage/tibet.png',
        'url' => 'tibet',
        'content' => 'Towering Himalayan peaks, sacred monasteries, and roads to Everest Base Camp - where earth meets the sky.'
    ],
    'iceland' => [
        'name' => 'ICELAND',
        'theme' => 'Arctic Odyssey',
        'hero_image' => 'assets/images/locations/iceland/homepage/iceland.png',
        'url' => 'iceland',
        'content' => 'Where fire meets ice, and every road leads to wonder - glaciers, volcanoes, and waterfalls on one epic loop.'
    ]
];
uasort($drive_ideas, fn($a, $b) => strcasecmp($a['name'], $b['name']));

$memories = [
    ['name' => 'Russia', 'img_url' => 'assets/images/homepage/russia_Artic_memories_hp.png', 'url' => 'russia-artic/memories'],
    ['name' => 'Russia', 'img_url' => 'assets/images/homepage/russia_memories_hp.png', 'url' => 'russia-luxe/memories'],
    ['name' => 'Srilanka', 'img_url' => 'assets/images/homepage/srilanka_memories_hp.png', 'url' => 'srilanka/memories'],
    ['name' => 'Scotland', 'img_url' => 'assets/images/homepage/scotland_memories_hp.png', 'url' => 'scotland/memories'],
    ['name' => 'UAE & Oman', 'img_url' => 'assets/images/homepage/uae_oman_memories_hp.png', 'url' => 'uae-oman/memories'],
    ['name' => 'Oman', 'img_url' => 'assets/images/homepage/oman_memories_hp.png', 'url' => 'oman/memories'],
    ['name' => 'Ireland', 'img_url' => 'assets/images/homepage/ireland_memories_hp.png', 'url' => 'ireland/memories'],
    ['name' => 'Norway', 'img_url' => 'assets/images/homepage/norway__memories_hp.png', 'url' => 'norway/memories'],
    ['name' => 'Poland', 'img_url' => 'assets/images/homepage/poland_memories_hp.png', 'url' => 'poland/memories'],
    ['name' => 'Mongolia', 'img_url' => 'assets/images/locations/mongolia/homepage/mongolia.png', 'url' => 'mongolia/memories'],
    ['name' => 'Tibet', 'img_url' => 'assets/images/locations/tibet/homepage/tibet.png', 'url' => 'tibet/memories'],
    ['name' => 'Iceland', 'img_url' => 'assets/images/locations/iceland/homepage/iceland.png', 'url' => 'iceland/memories'],
];
uasort($memories, fn($a, $b) => strcasecmp($a['name'], $b['name']));
