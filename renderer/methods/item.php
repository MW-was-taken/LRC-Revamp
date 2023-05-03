<?php
 
include_class('Item');

$item = new Item($id, $db, $filename);
$item->render();
$item->updateThumbnail();
