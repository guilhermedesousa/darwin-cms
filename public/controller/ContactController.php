<?php

class ContactController extends MainController
{
    public function runBeforeAction(): bool
    {
        if ($_SESSION['has_submitted_the_form'] ?? 0 == 1) {
            include 'view/contact/contact-us-already-contacted.html';
            return false;
        }
        return true;
    }

    public function defaultAction(): void
    {
        include 'view/contact/contact-us.html';
    }

    public function submitContactFormAction(): void
    {
        // validate
        // store data
        // send email

        $_SESSION['has_submitted_the_form'] = 1;
        include 'view/contact/contact-us-thank-you.html';
    }
}