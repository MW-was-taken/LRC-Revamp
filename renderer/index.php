<?php
 
require __DIR__ . '/core/helpers.php';
require __DIR__ . '/core/init.php';
require __DIR__ . '/classes/Database.php';
require __DIR__ . '/classes/Blender.php';

// Set global variables
$id = request_param('id');
$type = request_param('type');
$previewType = $id;
$filename = generate_filename();

// Handle the request
require __DIR__ . "/methods/{$type}.php";
