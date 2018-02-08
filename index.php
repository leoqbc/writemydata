<?php

require __DIR__ . '/vendor/autoload.php';

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Db\Table;

$mysqlAdapter = new MysqlAdapter([
    'host' => 'localhost',
    'name' => 'sat',
    'user' => 'root',
    'pass' => '',
    'port' => '3306',
    'charset' => 'utf8'
]);

$table = new Phinx\Db\Table('vendas', [], $mysqlAdapter);

$table->addColumn('teste', 'string')->update();