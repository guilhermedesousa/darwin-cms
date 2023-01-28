<?php declare(strict_types=1);

namespace tests;

use PHPUnit\Framework\TestCase;
use modules\page\model\Page;

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

    public function testSave(): void
    {
        $mockDatabase = $this->getMockBuilder(FakeDatabaseConnection::class)
            ->enableProxyingToOriginalMethods()
            ->getMock();

        $mockDatabase->expects($this->exactly(2))
            ->method('prepare')
            ->with(
                $this->logicalOr(
                    $this->equalTo('SELECT * FROM pages WHERE id = :value'),
                    $this->equalTo('UPDATE pages SET title = :title, content = :content WHERE id = :id')
                ));

        $page = new Page($mockDatabase);
        $page->findBy('id', 12);

        $page->title = "new title";
        $page->save();
        $this->assertEquals("new title", $page->title);
    }
}