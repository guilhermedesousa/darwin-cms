<?php

namespace modules\contact\controller;

use src\{MainController, DatabaseConnection};
use modules\page\model\Page;

class ContactController extends MainController
{
    public function runBeforeAction(): bool
    {
        if ($_SESSION['has_submitted_the_form'] ?? 0 == 1) {
            $dbh = DatabaseConnection::getInstance();
            $dbc = $dbh->getConnection();

            $pageObj = new Page($dbc);
            $pageObj->findById(3);
            $variables['pageObj'] = $pageObj;

            $this->template->view('page/view/static-page', $variables);

            return false;
        }
        return true;
    }

    public function defaultAction(): void
    {
        $dbh = DatabaseConnection::getInstance();
        $dbc = $dbh->getConnection();

        $pageObj = new Page($dbc);
        $pageObj->findBy('id',$this->entityId);
        $variables['pageObj'] = $pageObj;

        $this->template->view('contact/view/contact-us', $variables);
    }

    public function submitContactFormAction(): void
    {
        // validate
        // store data
        // send email

        $_SESSION['has_submitted_the_form'] = 1;

        $dbh = DatabaseConnection::getInstance();
        $dbc = $dbh->getConnection();

        $pageObj = new Page($dbc);
        $pageObj->findById(4);
        $variables['pageObj'] = $pageObj;

        $this->template->view('page/view/static-page', $variables);
    }
}