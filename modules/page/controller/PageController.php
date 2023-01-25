<?php

namespace modules\page\controller;

use src\{MainController, DatabaseConnection};
use modules\page\model\Page;

class PageController extends MainController
{
    public function defaultAction(): void
    {
        $dbh = DatabaseConnection::getInstance();
        $dbc = $dbh->getConnection();

        $pageObj = new Page($dbc);
        $pageObj->findBy('id', $this->entityId);
        $variables['pageObj'] = $pageObj;

        $this->template->view('page/view/static-page', $variables);
    }
}