<?php

namespace modules\page\admin\controller;

use src\MainController;
use modules\page\model\Page;

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

        $pageHandler = new Page($this->dbc);
        $pages = $pageHandler->findAll();
        $variables['pages'] = $pages;
        $this->template->view('page/admin/view/page-list', $variables);
    }

    public function editPageAction()
    {
        $pageId = $_GET['id'];
        $variables = [];

        $page = new Page($this->dbc);
        $page->findBy('id', $pageId);

        if($_POST['action'] ?? false) {
            $page->setValues($_POST);
            $page->save();

            $this->log->warning("Admin has changed the page id: $pageId");
        }

        $variables['page'] = $page;
        $this->template->view('page/admin/view/page-edit', $variables);
    }

    public function insertPageAction()
    {
        if ($_POST['action'] ?? false) {
            $page = new Page($this->dbc);
            $page->setValues($_POST);
            $page->insert();

            $this->log->warning("Admin has created a new page");
        }

        $variables = [];
        $this->template->view('page/admin/view/page-insert', $variables);
    }

    public function deletePageAction()
    {
        $pageId = $_GET['id'];
        $page = new Page($this->dbc);
        $page->findBy('id', $pageId);

        $page->delete();
        $this->log->warning("Admin has deleted the page id: $pageId");

        $pages = $page->findAll();
        $variables['pages'] = $pages;
        $this->template->view('page/admin/view/page-list', $variables);
    }
}