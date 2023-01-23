<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

require_once 'src/Entity.php';
require_once 'modules/page/model/Page.php';

class FakeStmt {
    function execute() {}
    function fetchAll() {
        return [
            ["id" => 1, "title" => "Fake title", "content" => "Fake content"]
        ];
    }
    function fetch() {
        return ["id" => 1, "title" => "Fake title", "content" => "Fake content"];
    }
}

class FakeDatabaseConnection {
    function prepare() {
        return new FakeStmt();
    }
}

final class ActiveRecordTest extends TestCase
{
    public function testFindAll(): void
    {
        $dbc = new FakeDatabaseConnection();
        $page = new Page($dbc);
        $result = $page->findAll();

        $this->assertEquals(1, count($result));
    }

    public function testFindBy(): void
    {
        $dbc = new FakeDatabaseConnection();
        $page = new Page($dbc);
        $page->findBy('id', 1);

        $this->assertEquals(1, $page->id);
    }
}