<?php
$dayofweek = date('w', strtotime($date));
$result    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date)));
?>