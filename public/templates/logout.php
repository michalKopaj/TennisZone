<?php
require_once  __DIR__ . '/../../autoload/php';

use App\Core\Auth;
use App\Core\Redirect;
?>
<?php

if(session_status() ===  PHP_SESSION_NONE){
    session_start();
}
require_once __DIR__ . '/../../app/core/Auth.php';
require_once __DIR__ . '/../../app/core/Redirect.php';

$auth = new Auth();
$auth->logout();

$redirect = new Redirect('home.php');
$redirect->redirect();
