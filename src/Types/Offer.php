<?php

namespace Krylach\YMLParser\Types;

use Illuminate\Support\Collection;
use Krylach\YMLParser\Interfaces\OfferInterface;
use Krylach\YMLParser\OfferType;

class Offer extends OfferType implements OfferInterface
{
    const PARAMETER_NODE_NAME   = 'param';
    const PICTURES_NODE_NAME    = 'picture';
    const DESCRIPTION_NODE_NAME = 'description';
 
    protected array $attributes;
    protected Collection $pictures;
    protected Collection $parameters;
    
    /**
     * Method __construct
     *
     * @param \SimpleXMLElement $offer [explicite description]
     *
     * @return void
     */
    public function __construct(\SimpleXMLElement &$offer)
    {
        $this->parameters = new Collection;
        $this->pictures   = new Collection;

        $this->formationNodeAttributes($offer->attributes());
        $this->formationOfferAttributes($offer->children());
        $this->formationPictures($offer);
    }

    private function formationNodeAttributes(\SimpleXMLElement $attributes)
    {
        foreach ($attributes as $key => $attribute) {
            $this->attributes[$key] = (string)$attribute;
            
        }
    }
    
    /**
     * Method formationChildAttributes
     *
     * @param \SimpleXMLElement $childNodes [explicite description]
     * 
     * @var \SimpleXMLElement $node
     * 
     * @return void
     */
    private function formationOfferAttributes(\SimpleXMLElement $childrenNodes)
    {
        foreach ($childrenNodes as $key => $node) {
            if ($node->getName() == self::PICTURES_NODE_NAME) {
                continue;
            }

            if ($node->getName() == self::PARAMETER_NODE_NAME) {
                $this->formationParameter($node);

                continue;
            }

            $this->attributes[$node->getName()] = 
                is_array($node) ?
                    $this->formationChildAttributes($node) : 
                    $this->stringify($node);
        }
    }
    
    /**
     * Method formationParameter
     *
     * @param \SimpleXMLElement $node [explicite description]
     *
     * @return void
     */
    private function formationParameter(\SimpleXMLElement &$node)
    {
        $this->parameters->push(new Parameter((string)$node->attributes(), (string)$node));
    }
    
    /**
     * Method formationPictures
     *
     * @param \SimpleXMLElement $offer [explicite description]
     *
     * @return void
     */
    private function formationPictures(\SimpleXMLElement &$offer)
    {
        $node = $offer->children();

        if (!isset($node->{self::PICTURES_NODE_NAME})) {
            return;
        }

        foreach ($node->{self::PICTURES_NODE_NAME} as $picture) {
            $this->pictures->push(new Picture($picture));
        } 
    }
    
    /**
     * Method stringify
     *
     * @param $node $node [explicite description]
     *
     * @return string
     */
    private function stringify($node)
    {
        return str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', (string)$node);
    }
}
