<?php

class ContactController extends MainController
{
    public function defaultAction(): void
    {
        include 'view/contact-us.html';
    }

    public function submitContactFormAction(): void
    {
        // validate
        // store data
        // send email

        include 'view/contact-us-thank-you.html';
    }
}