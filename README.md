## Installation

Use the package manager [composer](https://getcomposer.org/) to install foobar.

```bash
composer require krylach/ymlparser
```

## Usage

```php
use Krylach\YMLParser\YML;

$yml = new YML($path);
$yml = new YML("./ymldocument.xml");

$yml = $yml->parse();
```
### Shop
```php
$shop = $yml->getShop();

$shop->getName();
$shop->getUrl();
$shop->getPhone();
$shop->getCompany();
```

### Category
```php
$categories = $yml->getCategories();

foreach ($categories as $category) {
    $id = $category->getId();
    $parentId = $category->getParentId();
    $name = $category->getName();
}
```

### Offer
```php
$offers = $yml->getOffers();

foreach ($offers as $offer) {
   $pictures = $offer->getPictures();
   $parameters = $offer->getParameters();
}
```

#### Offer`s pictures
```php
foreach ($pictures as $picture) {
    $url = $picture->getUrl();
}
```

#### Offer`s parameters
```php
foreach ($parameters as $parameter) {
    $name = $parameter->getName(); 
    $value = $parameter->getValue();
}
```

#### Other attribute parameters
You can get any value specified in the offer of your YML document.
For example:

```php
foreach ($offers as $offer) {
    $name           = $offer->getName();
    $categoryId     = $offer->getCategoryId();
    $price          = $offer->getPrice();
    $vendorCode     = $offer->getVendorCode();
    $description    = $offer->getDescription();
    $available      = $offer->getAvailable();
    $currencyId     = $offer->getCurrencyId();
}
```

### Currency
```php
foreach ($currencies as $currency) {
    $id = $currency->getId();
    $rate = $currency->getRate();
}
```
