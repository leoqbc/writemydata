<?php
namespace WriteMyData\Interfaces;

interface Command
{
    public function create($command);
    public function getParsedCommand();
}