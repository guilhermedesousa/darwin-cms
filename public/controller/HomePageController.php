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

        $variables['title'] = 'Home page Title';
        $variables['content'] = 'Welcome to our homepage';

        $template = new Template('default');
        $template->view('static-page', $variables);
    }
}