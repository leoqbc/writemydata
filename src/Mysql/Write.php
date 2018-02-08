<?php namespace WriteMyData\Mysql;

use WriteMyData\Interfaces\Write\Persistence;
use Phinx\Db\Table;

class Write implements Persistence
{
    protected $adapter;
    protected $collection;
    protected $writeStatus;

    const NEW_WRITE = true;
    const OLD_WRITE = true;

    public function __construct($adapter)
    { 
        $this->adapter = $adapter;
    }

    public function getCollection()
    {
        return $this->collection;
    }

    public function setCollection(string $collection)
    { 
        $this->collection = new Table($collection, [], $this->adapter);
    }

    public function mount($registry) : bool
    {
        $this->mountCollection($registry);
        $clean_registry = $this->clearRegistry($registry);
        $this->getCollection()->setData([$clean_registry]);
        return true;
    }

    protected function clearRegistry($registry)
    {
        $fields = array_keys($registry);
        array_walk($fields, function (&$value) {
            $value = explode(':', $value)[0];
        });
        return array_combine($fields, $registry);
    }

    public function persists() : bool
    { 
        $this->getCollection()->saveData();
        return true;
    }

    public function mountCollection($registry) : bool
    {
        if (false === $this->getCollection()->exists()) {
            $this->createCollection($registry);
            return true;
        }
        $this->updateCollection($registry);
        return true;
    }

    public function updateCollection($registry)
    {
        $columns = array_keys($this->clearRegistry($registry));

        $diff = array_diff($columns, $this->getFields());

        if (empty($diff)) {
            return false;
        }

        foreach ($diff as $column) {
            $column_type = $this->returnColumn($column, $registry[$column]);
            $this->getCollection()->addColumn($column_type[0], $column_type[1]);
        }
        $this->getCollection()->update();
    }

    public function createCollection($registry)
    {
        $columns = array_keys($registry);

        foreach ($columns as $column) {
            $column_type = $this->returnColumn($column, $registry[$column]);
            $this->getCollection()->addColumn($column_type[0], $column_type[1]);
        }
        $this->getCollection()->create();
    }

    public function getFields()
    {
        $columns = $this->getCollection()->getColumns();
        $fields = [];
        foreach ($columns as $column) {
            $fields[] = $column->getName();
        }
        return $fields;
    }

    public function returnColumn($column, $value)
    {
        $definedType = explode(':', $column);
        if (count($definedType) == 2) {
            return [$definedType[0], $definedType[1]];
        }
        return [$definedType[0], gettype($value)];
    }
}
