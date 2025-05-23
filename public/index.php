<?php

declare(strict_types=1);

use App\Acme\BasketService;
use App\Acme\Delivery\DeliveryCalculator;
use App\Acme\Delivery\DeliveryRule;
use App\Acme\Discount\DiscountCalculator;
use App\Acme\Discount\SecondHalfPriceDiscountRule;
use App\Acme\Entities\Product;
use App\Acme\ProductCatalog\ProductCatalog;

require __DIR__ . '/../vendor/autoload.php';

$products = [];

$products[] = new Product('Red Widget', 'R01', 32.95);
$products[] = new Product('Green Widget', 'G01', 24.95);
$products[] = new Product('Blue Widget', 'B01', 7.95);

$discountRules = [
    new SecondHalfPriceDiscountRule(['R01']),
];

$deliveryRules = [
    new DeliveryRule(50, 4.95),
    new DeliveryRule(90, 2.95),
    new DeliveryRule(90.01, 0),
];

$basketOne = new BasketService(
    new ProductCatalog($products),
    new DeliveryCalculator($deliveryRules),
    new DiscountCalculator($discountRules)
);

$basketOne->addItem('B01');
$basketOne->addItem('B01');
$basketOne->addItem('R01');
$basketOne->addItem('R01');
$basketOne->addItem('R01');

print_r("\n");
print_r($basketOne->calculateTotalCost());


$basketTwo = new BasketService(
    new ProductCatalog($products),
    new DeliveryCalculator($deliveryRules),
    new DiscountCalculator($discountRules)
);

$basketTwo->addItem('R01');
$basketTwo->addItem('G01');

print_r("\n");
print_r($basketTwo->calculateTotalCost());

$basketThree = new BasketService(
    new ProductCatalog($products),
    new DeliveryCalculator($deliveryRules),
    new DiscountCalculator($discountRules)
);

$basketThree->addItem('R01');
$basketThree->addItem('R01');

print_r("\n");
print_r($basketThree->calculateTotalCost());

$basketFour = new BasketService(
    new ProductCatalog($products),
    new DeliveryCalculator($deliveryRules),
    new DiscountCalculator($discountRules)
);

$basketFour->addItem('B01');
$basketFour->addItem('G01');

print_r("\n");
print_r($basketFour->calculateTotalCost());
print_r("\n");
