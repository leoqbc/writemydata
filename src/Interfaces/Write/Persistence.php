<?php
namespace WriteMyData\Interfaces\Write;

interface Persistence
{
    public function setCollection(string $collection);
    public function mount($registry) : bool;
    public function persists() : bool;
}