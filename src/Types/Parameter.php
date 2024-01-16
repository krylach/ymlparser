<?php

namespace Krylach\YMLParser\Types;
use Krylach\YMLParser\Type;

class Parameter extends Type
{
    protected $name;
    protected $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;        
    }
}
