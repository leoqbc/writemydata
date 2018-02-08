<?php
namespace WriteMyData\Interfaces\Read;

use WriteMyData\Interfaces\Command;

interface Raw
{
    public function readCommand(Command $cmd);
}