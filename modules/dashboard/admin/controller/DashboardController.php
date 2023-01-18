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
                ->addRule(new ValidateMinimum(3))
                ->addRule(new ValidateEmail())
                ->validate($username)) {
                $_SESSION['validationRules']['error'] = $validation->getAllErrorMessages();
            } elseif (!$validation
                ->cleanRules()
                ->addRule(new ValidateMinimum(3))
                ->addRule(new ValidateMaximum(20))
                ->addRule(new ValidateNoEmptySpaces())
                ->addRule(new ValidateSpecialCharacter())
                ->validate($password)) {
                $_SESSION['validationRules']['error'] = $validation->getAllErrorMessages();
            }

            if (($_SESSION['validationRules']['error'] ?? '') == '') {
                $auth = new Auth();
                if ($auth->checkLogin($username, $password)) {
                    // all is good
                    $_SESSION['is_admin'] = 1;
                    header('Location: /darwin-cms/public/admin/');
                    exit();
                }

                $_SESSION['validationRules']['error'] = ["Username or password is incorrect"];
            }
        }

        include VIEW_PATH . 'admin/login.html';
        unset($_SESSION['validationRules']['error']);
    }
}