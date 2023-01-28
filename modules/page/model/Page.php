<?php

namespace modules\page\model;

use src\Entity;

class Page extends Entity
{
    public function __construct($dbc)
    {
        parent::__construct($dbc, 'pages');
    }

    protected function initFields()
    {
        $this->fields = [
            'title',
            'content'
        ];
    }
}