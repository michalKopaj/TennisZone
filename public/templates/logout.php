<?php
session_start();
require '../../app/models/User.php';
require '../../app/core/Redirect.php';

$user = new User();
$user->logout();

$redirect = new Redirect('home.php');
$redirect->redirect();
