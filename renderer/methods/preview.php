<?php
 
include_class('Preview');

$preview = new Preview($previewType);
$data = $preview->render();

echo json_encode(['thumbnail' => $data]);
