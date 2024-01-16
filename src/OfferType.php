<?php

namespace Krylach\YMLParser;

use Krylach\YMLParser\Interfaces\OfferTypeInterface;

class OfferType implements OfferTypeInterface
{
    protected array $attributes;

    public function __call($name, $arguments)
    {
        $name = ucwords(str_replace(['get', '_'], '', $name));
        $name = strtolower($name[0]) . mb_substr($name, 1, strlen($name));
        
        if (isset($this->attributes[$name])) {
            return $this->attributes[$name];
        } elseif (isset($this->$name)) {
            return $this->$name;
        }

        return null;
    }
}
