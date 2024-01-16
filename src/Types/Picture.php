<?php

namespace Krylach\YMLParser\Types;

use Krylach\YMLParser\Type;

class Picture extends Type
{
    protected string $url;

    public function __construct(&$picture)
    {
        $this->url = $picture;
    }
}
