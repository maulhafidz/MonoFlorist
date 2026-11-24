<?php

return [
    'name' => env('SHOP_NAME', 'MonoFlorist'),
    'tagline' => 'Handmade pipe cleaner flower bouquets that never wilt. Pre-order on WhatsApp.',
    'tagline_builder' => 'Build your own handmade pipe cleaner bouquet, stem by stem. Made to order.',

    // false = showcase only: every Pre-Order button opens WhatsApp directly.
    // true  = full bouquet builder (pick stems, wrapping, date, total, then send to WhatsApp).
    // To switch back to the builder: set BUILDER_ENABLED=true in .env, then run `php artisan config:clear`.
    'builder_enabled' => env('BUILDER_ENABLED', false),

    // First message when someone taps a Pre-Order button in showcase mode.
    // Template message, fill in after the colons. Used by every WhatsApp button except carousel cards.
    'whatsapp_greeting' => "Hi MonoFlorist, I would like to pre-order a bouquet.\n\nBouquet / flowers:\nQuantity:\nPickup date:\nNotes:",

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
        // Price per stem, in rupiah.
        ['name' => 'Sky Lily',       'price' => 10000, 'color' => '#cfe6f2', 'image' => 'sky-lily.jpg',       'available' => true, 'note' => 'Sky-blue petals with soft white edges. Without leaves.'],
        ['name' => 'Daisy',          'price' => 5000, 'color' => '#e9e8e4', 'image' => 'daisy.jpg',          'available' => true, 'note' => 'White petals, sunny yellow center, with leaves.'],
        ['name' => 'Blush Petunia',  'price' => 10000, 'color' => '#f5dfe0', 'image' => 'blush-petunia.jpg',  'available' => true, 'note' => 'Ruffled pink petals with a white fringe.'],
        ['name' => 'Blush Lily',     'price' => 12000, 'color' => '#f3dcdc', 'image' => 'blush-lily.jpg',     'available' => true, 'note' => 'Soft pink lily with a golden center.'],
        ['name' => 'Sunshine Lily',  'price' => 10000, 'color' => '#f2d34a', 'image' => 'sunshine-lily.jpg',  'available' => true, 'note' => 'Bright yellow petals that curl at the tips. Without leaves.'],
        ['name' => 'Bluebell',       'price' => 8000, 'color' => '#dfe3e6', 'image' => 'bluebell.jpg',       'available' => true, 'note' => 'A curved green stem with little blue bells.'],
        ['name' => 'Violet Lily',    'price' => 12000, 'color' => '#d9d0ea', 'image' => 'violet-lily.jpg',    'available' => true, 'note' => 'Lavender-purple petals with green leaves.'],
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

    // Finished bouquets shown first in the carousel (photo file inside public/images/bouquets).
    // price: set a number (rupiah) to show "STARTING AT Rp ...", or leave null to hide the price.
    'bouquets' => [
        ['name' => 'Roselle Pipe Bouquet', 'desc' => 'Pink blossoms in clear wrap with a satin ribbon.',                   'image' => 'pink-ribbon.jpg',      'price' => null],
        ['name' => 'Lily and Lilac Bouquet', 'desc' => 'Pink and magenta lilies in a soft ivory wrap.',                      'image' => 'lily-posy.jpg',        'price' => null],
        ['name' => 'Ethereal Butterfly Bouquet', 'desc' => 'Blue, pink and purple lilies with white roses and a gold butterfly.', 'image' => 'butterfly-garden.jpg', 'price' => null],
    ],

    // Ready-made starting points. mix = flower name => stems. Visitors can edit after picking one.
    // c1/c2/c3 = bloom colors and leaf = foliage color for the carousel illustration.
    'starters' => [
        ['name' => 'Ivory Morning',  'desc' => 'White daisies with soft blue and pink lilies.', 'c1' => '#F4F1E6', 'c2' => '#E8E4D2', 'c3' => '#C9C7A8', 'leaf' => '#5E7F5A', 'mix' => ['Daisy' => 6, 'Sky Lily' => 2, 'Blush Lily' => 2]],
        ['name' => 'Blush Letter',   'desc' => 'Pink lilies and petunias with white daisies.',  'c1' => '#F2C9C4', 'c2' => '#E8A6A0', 'c3' => '#F7E3DA', 'leaf' => '#56785A', 'mix' => ['Blush Lily' => 4, 'Blush Petunia' => 4, 'Daisy' => 2]],
        ['name' => 'Marigold Hour',  'desc' => 'Sunny yellow lilies with daisies and bluebells.', 'c1' => '#F0B04A', 'c2' => '#E58A3A', 'c3' => '#F6D58A', 'leaf' => '#4F7350', 'mix' => ['Sunshine Lily' => 5, 'Daisy' => 4, 'Bluebell' => 2]],
        ['name' => 'Lilac Field',    'desc' => 'Violet lilies, bluebells and a few daisies.',   'c1' => '#C7B3E0', 'c2' => '#A68CCB', 'c3' => '#EDE3F6', 'leaf' => '#5B7A62', 'mix' => ['Violet Lily' => 5, 'Bluebell' => 3, 'Daisy' => 2]],
        ['name' => 'Wild Meadow',    'desc' => 'A little of everything, loosely tied.',         'c1' => '#F4EEDC', 'c2' => '#E9A26B', 'c3' => '#B7A3D6', 'leaf' => '#6A8A55', 'mix' => ['Daisy' => 4, 'Sunshine Lily' => 2, 'Violet Lily' => 2, 'Blush Petunia' => 2]],
        ['name' => 'Sky Garden',     'desc' => 'Cool blues with white daisies.',                'c1' => '#CFE6F2', 'c2' => '#9CC9E4', 'c3' => '#EAF4FA', 'leaf' => '#3F6A4E', 'mix' => ['Sky Lily' => 4, 'Bluebell' => 4, 'Daisy' => 3]],
    ],

    // Occasion tiles: pick one and the builder opens with that starter (index into 'starters').
    // icon = inner SVG markup (24x24, stroke).
    'occasions' => [
        ['name' => 'Birthday',     'desc' => 'Bright, generous bunches, ready to brighten any table.', 'starter' => 2, 'icon' => '<rect x="4" y="11" width="16" height="9" rx="1.5"/><path d="M4 15h16M12 11V7M12 7c-1.5-1-1.5-3 0-4 1.5 1 1.5 3 0 4z"/>'],
        ['name' => 'Anniversary',  'desc' => 'Roses and garden-style blooms, wrapped with a handwritten card.',        'starter' => 1, 'icon' => '<path d="M12 20s-7-4.4-7-10a4 4 0 0 1 7-2.6A4 4 0 0 1 19 10c0 5.6-7 10-7 10z"/>'],
        ['name' => 'Sympathy',     'desc' => 'Soft whites and greens, a keepsake that stays with them.',             'starter' => 0, 'icon' => '<path d="M12 21V11M12 11c-3 0-5-2-5-5 3 0 5 2 5 5zM12 11c3 0 5-2 5-5-3 0-5 2-5 5zM12 15c-2.5 0-4-1.5-4-3.5"/>'],
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
        ['title' => 'Find us',    'text' => 'Visit our booth at Binus University. Pickup details shared on WhatsApp.'],
        ['title' => 'Delivery',   'text' => 'Local delivery available. Fee confirmed on WhatsApp.'],
    ],

    'faq' => [
        ['q' => 'Can I swap a flower if it is unavailable?', 'a' => 'Yes. We will message you before substituting and suggest a similar stem.'],
        ['q' => 'How do I pay?', 'a' => 'After you send your pre-order we confirm the details on WhatsApp and share payment instructions.'],
        ['q' => 'Can I change or cancel my order?', 'a' => 'Changes are free up to 48 hours before your date. Please message us as early as you can.'],
        ['q' => 'How long will the bouquet last?', 'a' => 'Our flowers are artificial, so they do not wilt and need no water. Keep them out of direct sun and dust them gently to keep the colors bright.'],
        ['q' => 'Can you add a card message?', 'a' => 'Yes. Write your message in the WhatsApp chat when you pre-order and we will include it on a handwritten card.'],
    ],

    // Where customers can find you (shown in the footer). Add the campus or booth number here.
    'location' => 'Binus University',
    'instagram' => '@monoflorist.id',
    'phone' => '0857-5964-0508',

    'testimonials' => [
        // 'name' is the quote's author.
        ['name' => 'Ralph Waldo Emerson', 'quote' => 'The earth laughs in flowers.'],
        ['name' => 'Claude Monet',        'quote' => 'I must have flowers, always, and always.'],
        ['name' => 'Lady Bird Johnson',   'quote' => 'Where flowers bloom, so does hope.'],
    ],
];
