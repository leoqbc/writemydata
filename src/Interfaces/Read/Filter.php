<?php
namespace WriteMyData\Interfaces\Read;

interface Filter
{
    public function getAll();
    public function getId($id);
    public function getField(string $fields);
}