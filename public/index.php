<?php

session_start();

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
define('MODULE_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR);

include '../vendor/autoload.php';
require_once ROOT_PATH . 'src/MainController.php';
require_once ROOT_PATH . 'src/Template.php';
require_once ROOT_PATH . 'src/DatabaseConnection.php';
require_once ROOT_PATH . 'src/Entity.php';
require_once ROOT_PATH . 'src/Router.php';
require_once MODULE_PATH . 'page/model/Page.php';

// Bootstrap
/* Connect to a MySQL database using driver invocation */
DatabaseConnection::connect('localhost', 'darwin_cms', 'root', '');

$action = $_GET['seo_name'] ?? 'home';

$dbh = DatabaseConnection::getInstance();
$dbc = $dbh->getConnection();

$router = new Router($dbc);
$router->findBy('pretty_url', $action);
$action = $router->action != '' ? $router->action : 'default';

$moduleName = ucfirst($router->module) . 'controller';
$controllerFile = MODULE_PATH . "$router->module/controller/$moduleName.php";

if (file_exists($controllerFile)) {
    include $controllerFile;
    $controller = new $moduleName();
    $controller->setEntityId($router->entity_id);
    $controller->runAction($action);
}