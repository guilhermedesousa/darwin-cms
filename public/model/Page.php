<?php

class Page
{
    public int $id;
    public string $title;
    public string $content;
    private PDO $dbc;

    public function __construct($dbc)
    {
        $this->dbc = $dbc;
    }

    public function findById(int $id)
    {
        $sql = "SELECT * FROM pages WHERE id = :id";
        $stmt = $this->dbc->prepare($sql);
        $stmt->execute(['id' => $id]);
        $pageData = $stmt->fetch();

        $this->id = $pageData['id'];
        $this->title = $pageData['title'];
        $this->content = $pageData['content'];
    }
}