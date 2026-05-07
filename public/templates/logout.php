<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(session_status() ===  PHP_SESSION_NONE){
    session_start();
}
require_once __DIR__ . '/../../app/core/Auth.php';
require_once __DIR__ . '/../../app/core/Redirect.php';

$auth = new Auth();
$auth->logout();

$redirect = new Redirect('home.php');
$redirect->redirect();
