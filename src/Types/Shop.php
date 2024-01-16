<?php

namespace Krylach\YMLParser\Types;

use Krylach\YMLParser\Type;

class Shop extends Type
{
    protected $name;
    protected $company;
    protected $url;
    protected $phone;

    public function __construct(\SimpleXMLElement &$shop)
    {
        $this->name = strval($shop->name ?? null);
        $this->company = strval($shop->company ?? null);
        $this->url = strval($shop->url ?? null);
        $this->phone = strval($shop->phone ?? null);
    }
}
