<?php

class PageController extends MainController
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
        $variables = [];
        $this->template->view('page/admin/view/page-list', $variables);
    }
}