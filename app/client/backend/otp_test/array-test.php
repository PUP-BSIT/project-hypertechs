<?php
$json = '[{"name":"calib"}]';
$data = json_decode($json, true);
echo ($data[0])['name'];
?>
