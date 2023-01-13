<?php

class DashboardController extends MainController
{
    public function runBeforeAction()
    {
        if ($_SESSION['is_admin'] ?? false == true) {
            return true;
        }

        $action = $_GET['action'] ?? $_POST['action'] ?? 'default';

        if ($action != 'login') {
            header('Location: /darwin-cms/public/admin/index.php?module=dashboard&action=login');
        } else {
            return true;
        }
    }

    public function defaultAction(): void
    {
        echo "Welcome to the administration";
    }

    public function loginAction()
    {
        if ($_POST['postAction'] ?? 0 == 1) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $auth = new Auth();
            $validator = new PasswordValidator($password);
            if (!$validator->checkMinCharacters()) {
                echo 'Password must be at least 6 characters. <br>';
            } else if (!$validator->checkMaxCharacters()) {
                echo 'Password must be a maximum of 20 characters. <br>';
            } else if (!$validator->checkSpecialCharacters()) {
                echo 'Password must be at least 1 special character. <br>';
            } else {
                if ($auth->checkLogin($username, $password)) {
                    // all is good
                    $_SESSION['is_admin'] = 1;
                    header('Location: /darwin-cms/public/admin/');
                }
            }

            var_dump('bad login');
        }
        include VIEW_PATH . 'admin/login.html';
    }
}