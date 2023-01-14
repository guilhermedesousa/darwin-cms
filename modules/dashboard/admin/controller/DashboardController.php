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

    public function loginAction(): void
    {
        if ($_POST['postAction'] ?? 0 == 1) {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $validation = new Validation();

            if (!$validation
                ->addRule(new ValidateEmail())
                ->validate($username)) {
                $_SESSION['validationRules']['error'] = "Username is not a valid email";
            } else if (!$validation
                ->addRule(new ValidateMinimum(6))
                ->addRule(new ValidateMaximum(20))
                ->addRule(new ValidateSpecialCharacter())
                ->validate($password)) {
                $_SESSION['validationRules']['error'] = "Password must be between 6 and 20 characters and must contain one special character.";
            }

            if (($_SESSION['validationRules']['error'] ?? '') == '') {
                $auth = new Auth();
                if ($auth->checkLogin($username, $password)) {
                    // all is good
                    $_SESSION['is_admin'] = 1;
                    header('Location: /darwin-cms/public/admin/');
                    exit();
                }

                $_SESSION['validationRules']['error'] = "Username or password is incorrect";
            }
        }

        include VIEW_PATH . 'admin/login.html';
        unset($_SESSION['validationRules']['error']);
    }
}