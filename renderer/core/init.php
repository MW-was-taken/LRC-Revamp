<?php
 
try {
    $db = new PDO('mysql:host=' . config('DB_HOST') . ';dbname=' . config('DB_NAME'), config('DB_USER'), config('DB_PASS'));
} catch (Exception $e) {
    exit('invalid db credentials');
}

$seriousKey = request_param('seriousKey');
$type       = request_param('type');
$id         = request_param('id');

if (!$seriousKey)
    exit('provide a seriousKey');
else if ($seriousKey != config('SERIOUS_KEY'))
    exit('invalid seriousKey');
else if (!$type)
    exit('provide a type');
else if (!in_array($type, config('ALLOWED_TYPES')))
    exit('invalid type');
else if (!$id)
    exit('provide an id');
