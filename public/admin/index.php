<?php

session_start();

define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);
define('VIEW_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR);
define('MODULE_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR);
define('ENCRYPTION_SALT', '43h25oi34lkfnmsdoi89f');

include '../../vendor/autoload.php';
require_once ROOT_PATH . 'src/MainController.php';
require_once ROOT_PATH . 'src/Template.php';
require_once ROOT_PATH . 'src/DatabaseConnection.php';
require_once ROOT_PATH . 'src/Entity.php';
require_once ROOT_PATH . 'src/Router.php';
require_once ROOT_PATH . 'src/Auth.php';
require_once ROOT_PATH . 'src/PasswordValidator.php';
require_once ROOT_PATH . 'src/PasswordRules.php';
require_once MODULE_PATH . 'page/model/Page.php';
require_once MODULE_PATH . 'user/model/User.php';

// Bootstrap
/* Connect to a MySQL database using driver invocation */
DatabaseConnection::connect('localhost', 'darwin_cms', 'root', '');

// if / else logic
$module = $_GET['module'] ?? $_POST['module'] ?? 'dashboard';
$action = $_GET['action'] ?? $_POST['action'] ?? 'default';

if ($module=='dashboard') {
    include MODULE_PATH . 'dashboard/admin/controller/DashboardController.php';

    $dashboardController = new DashboardController();
    $dashboardController->runAction($action);
}