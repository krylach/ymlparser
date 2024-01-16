<?php

namespace Krylach\YMLParser\Types;

use Krylach\YMLParser\Type;

class Currency extends Type
{
    protected string $id;
    protected float $rate;
    public function __construct(\SimpleXMLElement &$currency)
    {
        $this->id = strval($currency['id'] ?? null);
        $this->rate = doubleval($currency['rate'] ?? null);
    }    
}
