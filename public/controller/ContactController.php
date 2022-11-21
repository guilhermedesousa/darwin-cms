<?php

class ContactController extends MainController
{
    public function runBeforeAction(): bool
    {
        if ($_SESSION['has_submitted_the_form'] ?? 0 == 1) {
            $variables['title'] = 'You have already submitted the form';
            $variables['content'] = 'Please be patient as we process your message.';

            $template = new Template('default');
            $template->view('static-page', $variables);

            return false;
        }
        return true;
    }

    public function defaultAction(): void
    {
        $variables['title'] = 'Contact us page';
        $variables['content'] = 'Please write us a message';

        $template = new Template('default');
        $template->view('contact/contact-us', $variables);
    }

    public function submitContactFormAction(): void
    {
        // validate
        // store data
        // send email

        $_SESSION['has_submitted_the_form'] = 1;

        $variables['title'] = 'Thank you for your message';
        $variables['content'] = 'We will get back to you.';

        $template = new Template('default');
        $template->view('static-page', $variables);
    }
}