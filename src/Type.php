<?php

namespace Krylach\YMLParser;

class Type
{
    public function __call($name, $arguments)
    {
        $name = ucwords(str_replace(['get', '_'], '', $name));
        $name = strtolower($name[0]) . mb_substr($name, 1, strlen($name));

        if (isset($this->$name)) {
            return $this->$name;
        }

        return null;
    }
}
