<?php

class MainController
{
    public function runAction($actionName): void
    {
        $actionName .= 'Action';
        if (method_exists($this, $actionName)) {
            $this->$actionName();
        } else {
            include 'view/status-pages/404.html';
        }
    }
}