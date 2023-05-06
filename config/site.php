<?php
 
return [
    'name' => env('APP_NAME', 'Laravel Roblox Clone'),
    'logo' => '/img/logo.png',
    'icon' => '/img/icon.png',

    'paypal_email' => 'email@gmail.com',
    'paypal_sandbox' => false,

    // README: From lines 12 to 25, if you do not change these accordingly, the website literally will not work.

    'route_domains' => [
        'admin_site' => 'http://panel.robloxclone.com',
        'main_site' => 'http://www.robloxclone.com',
        'storage_site' => 'http://cdn.robloxclone.com',
        'referral_site' => 'http://refer.robloxclone.com',
    ],

    'renderer' => [
        'url' => 'renderer.robloxclone.com',
        'key' => 'realrenderinghehehehe',
        'default_filename' => 'user', // Default thumbnail filename
        'previews_enabled' => false
    ],

    'official_thumbnail' => '/img/icon.png', // Headshot for the system account (ID 1)

    'updates_forum_topic_id' => 1,

    'username_change_price' => 250,
    'group_creation_price' => 50,

    'flood_time' => 15,

    'daily_currency' => 10,
    'daily_currency_membership' => 25,
    'group_limit' => 10,
    'group_limit_membership' => 25,

    'donator_item_id' => 0,
    'membership_item_id' => 0,
    'email_verification_item_id' => 0,
    'fake_admin_item_id' => 0, // Granted to those who visit "/admin", leave as 0 if none

    'membership_name' => 'Gold',
    'membership_color' => '#000',
    'membership_bg_color' => '#ffc113',

    'socials' => [
        'discord' => '',
        'twitter' => ''
    ],

    'admin_panel_code' => '', // A second layer of protection to the administration panel required to login, leave empty if you do not want one
    'maintenance_passwords' => [
        'key'
    ],

    'catalog_recent_item_types' => ['hat', 'face', 'gadget'],
    'catalog_item_types' => ['hat', 'face', 'gadget', 'shirt', 'pants'],
    'inventory_item_types' => ['hat', 'face', 'gadget', 'shirt', 'pants'],
    'character_editor_item_types' => ['hat', 'face', 'gadget', 'shirt', 'pants'],
    'item_thumbnails_with_padding' => ['hat', 'face', 'gadget', 'shirt', 'pants']
];
