<?php

require 'src/MainController.php';

$section = $_GET['section'] ?? $_POST['section'] ?? 'home';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';

if ($section == 'about-us') {
    include 'controller/AboutUsController.php';
    $aboutUsController = new AboutUsController();
    $aboutUsController->runAction($action);
} else if ($section == 'contact-us') {
    include 'controller/ContactController.php';
    $contactController = new ContactController();
    $contactController->runAction($action);
} else {
    include 'controller/homePage.php';
}
