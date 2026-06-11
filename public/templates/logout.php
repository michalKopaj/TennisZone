<?php
require_once  __DIR__ . '/../../autoload/php';

use App\Core\Auth;
use App\Core\Redirect;
?>
<?php

if(session_status() ===  PHP_SESSION_NONE){
    session_start();
}


$auth = new Auth();
$auth->logout();

$redirect = new Redirect('home.php');
$redirect->redirect();
