<?php

namespace Krylach\YMLParser\Types;

use Krylach\YMLParser\Type;

class Category extends Type
{
    protected $id;
    protected $parentId;
    protected $name;
 
    public function __construct(\SimpleXMLElement &$xmlItem)
    {
        $this->id = intval($xmlItem['id']);
        $this->parentId = intval($xmlItem['parentId']) > 0 ? intval($xmlItem['parentId']) : null;
        $this->name = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', strval($xmlItem));
    }
}
