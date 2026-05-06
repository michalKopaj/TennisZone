<?php
session_start();
require '../../app/core/Auth.php';
require '../../app/core/Redirect.php';

$auth = new Auth();
$user->logout();

$redirect = new Redirect('home.php');
$redirect->redirect();
