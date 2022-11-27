<?php

class HomePageController extends MainController
{
    function defaultAction(): void
    {
        // fetch the SEO
        // get the page data
        // $title
        // $content
        // $variable1

        $dbh = DatabaseConnection::getInstance();
        $dbc = $dbh->getConnection();

        $pageObj = new Page($dbc);
        $pageObj->findById(1);
        $variables['pageObj'] = $pageObj;

        $template = new Template('default');
        $template->view('static-page', $variables);
    }
}