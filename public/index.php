<?php

session_start();

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);

include '../vendor/autoload.php';
require_once ROOT_PATH . 'src/MainController.php';
require_once ROOT_PATH . 'src/Template.php';

$section = $_GET['section'] ?? $_POST['section'] ?? 'home';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';

if ($section == 'about-us') {
    include ROOT_PATH . 'controller/AboutUsController.php';
    $aboutUsController = new AboutUsController();
    $aboutUsController->runAction($action);
} else if ($section == 'contact-us') {
    include ROOT_PATH . 'controller/ContactController.php';
    $contactController = new ContactController();
    $contactController->runAction($action);
} else {
    include ROOT_PATH . 'controller/HomePageController.php';
    $homePageController = new HomePageController();
    $homePageController->runAction($action);
}
