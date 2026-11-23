<?php

return [
    'name' => env('SHOP_NAME', 'MonoFlorist'),
    'tagline' => 'Handmade artificial flower bouquets that last. Pre-order on WhatsApp.',
    'tagline_builder' => 'Build your own artificial flower bouquet, stem by stem. Made to order.',

    // false = showcase only: every Pre-Order button opens WhatsApp directly.
    // true  = full bouquet builder (pick stems, wrapping, date, total, then send to WhatsApp).
    // To switch back to the builder: set BUILDER_ENABLED=true in .env, then run `php artisan config:clear`.
    'builder_enabled' => env('BUILDER_ENABLED', false),

    // First message when someone taps a Pre-Order button in showcase mode.
    'whatsapp_greeting' => 'Hi, I would like to pre-order a bouquet.',

    // Pre-order orders are sent here with the bouquet summary as the message.
    // WhatsApp link (number with country code, no + or spaces): https://wa.me/62812xxxxxxx
    // 085759640508 in international format (leading 0 becomes country code 62).
    'preorder_url' => env('PREORDER_URL', 'https://wa.me/6285759640508'),

    // Logo file inside /public.
    'logo' => 'images/logo.jpg',

    // Flowers customers can add to their bouquet. Price is per stem (rupiah).
    // note: short detail line. available: false shows "Sold out".
    // image: file inside public/images/flowers (optional). Without it a color placeholder shows.
    'flowers' => [
        ['name' => 'Rose',           'price' => 15000, 'color' => '#f1d3d9', 'image' => null, 'available' => true, 'note' => 'Classic and timeless. Lifelike petals.'],
        ['name' => 'Lily',           'price' => 20000, 'color' => '#f7e6d8', 'image' => null, 'available' => true, 'note' => 'Elegant and graceful. Never wilts.'],
        ['name' => 'Tulip',          'price' => 18000, 'color' => '#f5c9d0', 'image' => null, 'available' => true, 'note' => 'Spring favorite, all year round.'],
        ['name' => 'Sunflower',      'price' => 17000, 'color' => '#f3e0a0', 'image' => null, 'available' => true, 'note' => 'Bold and bright. Keeps its color.'],
        ['name' => 'Peony',          'price' => 30000, 'color' => '#f2bfcf', 'image' => null, 'available' => false, 'note' => 'Out of stock. Restocking soon.'],
        ['name' => 'Lavender',       'price' => 12000, 'color' => '#d9cdee', 'image' => null, 'available' => true, 'note' => 'Soft purple tones. No watering needed.'],
        ['name' => 'Daisy',          'price' => 8000,  'color' => '#eef1e4', 'image' => null, 'available' => true, 'note' => 'Light and playful.'],
        ['name' => 'Carnation',      'price' => 10000, 'color' => '#f5d2b8', 'image' => null, 'available' => true, 'note' => 'Full, ruffled petals. Lasts for years.'],
        ['name' => 'Baby\'s Breath', 'price' => 6000,  'color' => '#e4ebe0', 'image' => null, 'available' => true, 'note' => 'Delicate filler for any bouquet.'],
        ['name' => 'Eucalyptus',     'price' => 7000,  'color' => '#cfe0d2', 'image' => null, 'available' => true, 'note' => 'Soft greenery that never dries out.'],
    ],

    // Wrapping choices (one is picked per bouquet).
    'wrappings' => [
        ['name' => 'Kraft paper',  'price' => 10000],
        ['name' => 'Cream tissue', 'price' => 15000],
        ['name' => 'Luxe ribbon',  'price' => 25000],
    ],

    // A bouquet needs at least this many stems before it can be sent.
    'min_stems' => 5,
    'max_stems' => 60,
    // Size label shown in the summary: from this many stems up.
    'sizes' => [
        ['from' => 0,  'name' => 'Petite'],
        ['from' => 10, 'name' => 'Medium'],
        ['from' => 20, 'name' => 'Grand'],
    ],

    // Ready-made starting points. mix = flower name => stems. Visitors can edit after picking one.
    // c1/c2/c3 = bloom colors and leaf = foliage color for the carousel illustration.
    'starters' => [
        ['name' => 'Ivory Morning',  'desc' => 'Soft whites with gentle greenery.',     'c1' => '#F4F1E6', 'c2' => '#E8E4D2', 'c3' => '#C9C7A8', 'leaf' => '#5E7F5A', 'mix' => ['Lily' => 3, 'Daisy' => 4, 'Baby\'s Breath' => 3, 'Eucalyptus' => 2]],
        ['name' => 'Blush Letter',   'desc' => 'Roses, tulips and a touch of green.',  'c1' => '#F2C9C4', 'c2' => '#E8A6A0', 'c3' => '#F7E3DA', 'leaf' => '#56785A', 'mix' => ['Rose' => 8, 'Tulip' => 2, 'Baby\'s Breath' => 3, 'Eucalyptus' => 2]],
        ['name' => 'Marigold Hour',  'desc' => 'Sunflowers and warm carnations.',      'c1' => '#F0B04A', 'c2' => '#E58A3A', 'c3' => '#F6D58A', 'leaf' => '#4F7350', 'mix' => ['Sunflower' => 5, 'Carnation' => 3, 'Daisy' => 4, 'Eucalyptus' => 2]],
        ['name' => 'Lilac Field',    'desc' => 'Lavender, tulips and soft filler.',    'c1' => '#C7B3E0', 'c2' => '#A68CCB', 'c3' => '#EDE3F6', 'leaf' => '#5B7A62', 'mix' => ['Lavender' => 6, 'Tulip' => 4, 'Baby\'s Breath' => 3]],
        ['name' => 'Wild Meadow',    'desc' => 'Daisies and carnations, loosely tied.', 'c1' => '#F4EEDC', 'c2' => '#E9A26B', 'c3' => '#B7A3D6', 'leaf' => '#6A8A55', 'mix' => ['Daisy' => 6, 'Carnation' => 3, 'Lavender' => 3, 'Eucalyptus' => 2]],
        ['name' => 'Evergreen Calm', 'desc' => 'Lilies and greenery, calm and timeless.', 'c1' => '#EEF0E6', 'c2' => '#BFD3B8', 'c3' => '#DCE6D2', 'leaf' => '#3F6A4E', 'mix' => ['Lily' => 4, 'Eucalyptus' => 5, 'Baby\'s Breath' => 3]],
    ],

    // Occasion tiles: pick one and the builder opens with that starter (index into 'starters').
    // icon = inner SVG markup (24x24, stroke).
    'occasions' => [
        ['name' => 'Birthday',     'desc' => 'Bright, generous bunches, ready to brighten any table.', 'starter' => 2, 'icon' => '<rect x="4" y="11" width="16" height="9" rx="1.5"/><path d="M4 15h16M12 11V7M12 7c-1.5-1-1.5-3 0-4 1.5 1 1.5 3 0 4z"/>'],
        ['name' => 'Anniversary',  'desc' => 'Roses and garden-style blooms, wrapped with a handwritten card.',        'starter' => 1, 'icon' => '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>'],
        ['name' => 'Sympathy',     'desc' => 'Soft whites and greens, a keepsake that stays with them.',             'starter' => 5, 'icon' => '<path d="M12 21V11M12 11c-3 0-5-2-5-5 3 0 5 2 5 5zM12 11c3 0 5-2 5-5-3 0-5 2-5 5zM12 15c-2.5 0-4-1.5-4-3.5"/>'],
        ['name' => 'Just because', 'desc' => 'A studio favorite, made to be kept for years.',            'starter' => 4, 'icon' => '<circle cx="12" cy="9" r="3"/><path d="M12 6V3M12 15v6M9 9H6M18 9h-3M9.9 6.9 8 5M14.1 6.9 16 5"/>'],
    ],

    // Story strip
    'story_title' => 'Flowers that stay beautiful, arranged by hand.',
    'story_text' => 'Every bouquet is made to order, stem by stem. Pre-order ahead and we arrange yours in time for your day. No wilting, no watering, just flowers that last.',

    // Footer social links (leave null to hide)
    'instagram_url' => 'https://www.instagram.com/monoflorist.id',
    'facebook_url' => null,

    // Practical info strip.
    'info' => [
        ['title' => 'Lead time',  'text' => 'Please order at least 2 days ahead.'],
        ['title' => 'Pickup',     'text' => 'Collect from our studio. Details shared on WhatsApp.'],
        ['title' => 'Delivery',   'text' => 'Local delivery available. Fee confirmed on WhatsApp.'],
        ['title' => 'Hours',      'text' => 'Mon–Sat, 09:00–18:00.'],
    ],

    'faq' => [
        ['q' => 'Can I swap a flower if it is unavailable?', 'a' => 'Yes. We will message you before substituting and suggest a similar stem.'],
        ['q' => 'How do I pay?', 'a' => 'After you send your pre-order we confirm the details on WhatsApp and share payment instructions.'],
        ['q' => 'Can I change or cancel my order?', 'a' => 'Changes are free up to 48 hours before your date. Please message us as early as you can.'],
        ['q' => 'How long will the bouquet last?', 'a' => 'Our flowers are artificial, so they do not wilt and need no water. Keep them out of direct sun and dust them gently to keep the colors bright.'],
        ['q' => 'Can you add a card message?', 'a' => 'Yes. Write it in the notes field and we will include a handwritten card.'],
    ],

    'instagram' => '@monoflorist.id',
    'phone' => '0857-5964-0508',

    'testimonials' => [
        // 'name' is the quote's author.
        ['name' => 'Ralph Waldo Emerson', 'quote' => 'The earth laughs in flowers.'],
        ['name' => 'Claude Monet',        'quote' => 'I must have flowers, always, and always.'],
        ['name' => 'Lady Bird Johnson',   'quote' => 'Where flowers bloom, so does hope.'],
    ],
];
