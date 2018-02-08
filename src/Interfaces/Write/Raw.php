<?php
namespace WriteMyData\Interfaces\Write;

use WriteMyData\Interfaces\Command;

interface Raw
{
    public function writeCommand(Command $cmd);
}