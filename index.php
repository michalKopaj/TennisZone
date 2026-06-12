<?php
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
header('Location: ' . $base . '/public/templates/home.php');
exit;