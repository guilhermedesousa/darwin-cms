<?php

class MainController
{
    protected string $entityId;

    public function runAction($actionName): void
    {
        if (method_exists($this, 'runBeforeAction')) {
            $result = $this->runBeforeAction();
            if (!$result) {
                return;
            }
        }

        $actionName .= 'Action';
        if (method_exists($this, $actionName)) {
            $this->$actionName();
        } else {
            include 'view/status-pages/404.html';
        }
    }

    public function setEntityId(string $entityId): void
    {
        $this->entityId = $entityId;
    }
}