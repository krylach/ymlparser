<?php

namespace Krylach\YMLParser;

use Illuminate\Support\Collection;
use Krylach\YMLParser\Exceptions\FileNotFoundException;
use Krylach\YMLParser\Types\Category;
use Krylach\YMLParser\Types\Currency;
use Krylach\YMLParser\Types\Offer;
use Krylach\YMLParser\Types\Shop;
/**
 * @method Shop getShop()
 * @method Collection getOffers()
 * @method Collection getCategories()
 * @method Collection getCurrencies()
 * @method Collection parse(bool $build)
 */
class YML
{
    private $path;
    private $source;
    private $xml;

    protected Shop $shop;
    protected Collection $categories;
    protected Collection $offers;
    protected Collection $currencies;

    public function __construct(string $path)
    {
        if (!$this->checkIssetSource($path)) {
            throw new FileNotFoundException("File for parsing not found.");
        }
    }

    public function __call($name, $arguments)
    {
        $parameter = mb_strtolower(str_replace('get', '', $name));

        if (isset($this->$parameter)) {
            return $this->$parameter;
        }
        
        if (method_exists($this, $name)) {
            return $this->$name();
        }
    }
    
    /**
     * Method getCurrencies
     *
     * @return Collection
     */
    private function getCurrencies(): Collection
    {
        $currencies = collect([]);
        if (isset($this->xml->shop->currencies->currency)) {
            foreach ($this->xml->shop->currencies->currency as $key => $currency) {
                $currencies->push(new Currency($currency));
            }
        }

        return $this->currencies = $currencies;
    }
    
    /**
     * Method getOffers
     *
     * @return Collection
     */
    private function getOffers(): Collection
    {
        $offers = collect([]);
        if (isset($this->xml->shop->offers->offer)) {
            foreach ($this->xml->shop->offers->offer as $key => $offer) {
                $offers->push(new Offer($offer));
            }
        }

        return $this->offers = $offers;
    }
    
    /**
     * Method getCategories
     *
     * @return Collection
     */
    private function getCategories(): Collection
    {
        $categories = collect([]);
        if (isset($this->xml->shop->categories->category)) {
            foreach ($this->xml->shop->categories->category as $category) {
                $categories->push(new Category($category));
            }
        }

        return $this->categories = $categories;
    }
    
    /**
     * Method getShop
     *
     * @return Shop
     */
    private function getShop(): Shop
    {
        return $this->shop = new Shop($this->xml->shop);
    }
    
    /**
     * Method parse
     *
     * @return void|YML
     */
    public function parse(bool $build = false)
    {
        if ($this->path) {
            $this->source = file_get_contents($this->path);

            if ($this->isXml($this->source)) {
                $this->xml    = simplexml_load_string($this->source);
            }
            
            return $this;
        }

        if ($build) {
            $this->shop = $this->getShop();
            $this->categories = $this->getCategories();
            $this->offers = $this->getOffers();
            $this->currencies = $this->getCurrencies();
        }

        throw new FileNotFoundException("File for parsing not found.");
    }

    
    /**
     * Method checkIssetSource
     *
     * @param string $path [explicite description]
     *
     * @return bool
     */
    private function checkIssetSource(string $path): bool
    {
        if (file_exists($path)) {
            $this->path = $path;

            return true;
        }

        if ($headers = get_headers($path)) {
            if (strpos($headers[0], '200') || strpos($headers[17], '200')) {
                $this->path = $path;
            }

            return true;
        }

        return false;
    }

    private function isXml(string &$source): bool
    {
        $prev = libxml_use_internal_errors(true);

        $doc = simplexml_load_string($source);
        $errors = libxml_get_errors();

        libxml_clear_errors();
        libxml_use_internal_errors($prev);

        return false !== $doc && empty($errors);
    }
}
