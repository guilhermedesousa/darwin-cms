<?php

class AboutUsController extends MainController
{
    public function defaultAction(): void
    {
        $variables['title'] = 'About us page';
        $variables['content'] = 'About us content of the page';

        $template = new Template('default');
        $template->view('static-page', $variables);
    }
}