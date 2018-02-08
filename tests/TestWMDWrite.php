<?php

use WriteMyData\Mysql\Write;
use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table;

class TestWMDWrite extends \PHPUnit\Framework\TestCase
{
    public $table;

    public function setUp()
    {
        $this->mysqlAdapter = new MysqlAdapter([
            'host' => 'localhost',
            'name' => 'test',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8'
        ]);

        $this->table = new Table('tb_test', [], $this->mysqlAdapter);
        
        if (false === $this->table->exists()) {
            $this->table->create();
        }
    }

    public function testTableTestExists()
    {
        $this->assertTrue($this->table->exists());
    }

    public function testCreateObjectWrite()
    {
        $write = new Write($this->mysqlAdapter);

        $this->assertInstanceOf(Write::class, $write);
    }

    public function testWriteCreateTable()
    {
        $write = new Write($this->mysqlAdapter);

        $write->setCollection('test');
        
        $write->mount([
            'name' => 'Leonardo Tumadjian',
            'cel' => '5555-5555',
            'address' => '330th Eleven street'
        ]);

        $write->persists();

        $this->assertTrue($write->getCollection()->exists());
        $this->assertCount(4, $write->getCollection()->getColumns());
    }

    public function testWriteUpdateTable()
    {
        $write = new Write($this->mysqlAdapter);

        $write->setCollection('test');
        
        $write->mount([
            'name' => 'Leonardo Tumadjian',
            'cel' => '5555-5555',
            'address' => '330th Eleven street',
            'email' => 'email@mail.com'
        ]);

        $write->persists();
        
        $this->assertCount(5, $write->getCollection()->getColumns());
        $write->getCollection()->drop();
    }

    public function testWriteTableWithDate()
    {
        $write = new Write($this->mysqlAdapter);

        $write->setCollection('test2');
        
        $write->mount([
            'name' => 'Leonardo Tumadjian',
            'cel' => '5555-5555',
            'address' => '330th Eleven street',
            'email' => 'email@mail.com',
            'createdAt:datetime' => date('Y-m-d H:i:s')
        ]);

        $write->persists();
        
        $this->assertCount(6, $write->getCollection()->getColumns());
        $write->getCollection()->drop();
    }

    public function tearDown()
    {
        $this->table->drop();

        $this->assertFalse($this->table->exists());
    }

    public static function tearDownAfterClass()
    {
        
    }
}