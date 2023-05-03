<?php
 
include_class('User');

$user = new User($id, $db, $filename);
$user->render();
$user->updateThumbnail();
