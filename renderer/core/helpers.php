<?php
 
// I know this is dumb... but I simply do not care
function config($var1, $var2 = null, $var3 = null, $var4 = null)
{
    $config = require __DIR__ . '/config.php';

    if ($var4)
        return $config[$var1][$var2][$var3][$var4] ?? null;
    else if ($var3)
        return $config[$var1][$var2][$var3] ?? null;
    else if ($var2)
        return $config[$var1][$var2] ?? null;

    return $config[$var1] ?? null;
}

function request_param($param)
{
    return $_GET[$param] ?? null;
}

function include_class($filename)
{
    // Why? To make the code look cleaner than it actually is, of course.
    require __DIR__ . "/../classes/{$filename}.php";
}

function generate_filename()
{
    $length = 50;
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($chars, ceil($length / strlen($chars)) )), 1, $length);
}

function delete_thumbnail($filename)
{
    $dir = config('DIRECTORIES', 'THUMBNAILS');
    $file = "{$dir}/{$filename}.png";

    if (!is_dir($file) && file_exists($file))
        unlink($file);
}

function delete_upload($filename)
{
    $dir = config('DIRECTORIES', 'UPLOADS');
    $file = "{$dir}/{$filename}.png";

    if (!is_dir($file) && file_exists($file))
        unlink($file);
}

function obj_exists($filename)
{
    $dir = config('DIRECTORIES', 'UPLOADS');
    $filename = "{$dir}/{$filename}.obj";

    return !is_dir($filename) && file_exists($filename);
}

function texture_exists($filename)
{
    $dir = config('DIRECTORIES', 'UPLOADS');
    $filename = "{$dir}/{$filename}.png";

    return !is_dir($filename) && file_exists($filename);
}

function color_array($head, $torso = null, $leftArm = null, $rightArm = null, $leftLeg = null, $rightLeg = null)
{
    if ($head == 'item_body_color')
        $head = config('ITEM_BODY_COLOR');

    if (!$torso) {
        $torso = $head;
        $leftArm = $head;
        $rightArm = $head;
        $leftLeg = $head;
        $rightLeg = $head;
    }

    return [
        'Head'      => $head,
        'Torso'     => $torso,
        'LeftArm'   => $leftArm,
        'LeftHand'  => $leftArm,
        'RightArm'  => $rightArm,
        'RightHand' => $rightArm,
        'LeftLeg'   => $leftLeg,
        'RightLeg'  => $rightLeg
    ];
}

function preview_base64($type)
{
    $directory = config('DIRECTORIES', 'THUMBNAILS');

    return base64_encode(file_get_contents("{$directory}/preview_{$type}.png"));
}
