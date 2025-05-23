<?php

declare(strict_types=1);

namespace App\Acme\Tests\Unit\Entities;

use App\Acme\Entities\BasketItem;
use App\Acme\Entities\Product;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class BasketItemTest extends TestCase
{
    #[Test]
    public function it_should_Create_an_instance_of_basket_item_when_quantity_is_valid(): void
    {
        $basketItem = new BasketItem(new Product('A', '1', 1), 1);


        self::assertInstanceOf(BasketItem::class, $basketItem);
        self::assertEquals(1, $basketItem->getQuantity());
    }

    #[Test]
    public function it_should_throw_an_exception_when_quantity_is_negative(): void
    {
        self::expectException(InvalidArgumentException::class);

        new BasketItem(new Product('A', '1', 1), -1);
    }

    #[Test]
    public function it_should_increment_by_one_when_quantity_is_not_provided(): void
    {
        $basketItem = new BasketItem(new Product('A', '1', 1), 1);

        $basketItem->incrementQuantity();

        self::assertEquals(2, $basketItem->getQuantity());
    }

    #[Test]
    public function it_should_increment_quantity_by_given(): void
    {
        $basketItem = new BasketItem(new Product('A', '1', 1), 1);

        $basketItem->incrementQuantity(3);

        self::assertEquals(4, $basketItem->getQuantity());
    }

    #[Test]
    public function it_should_throw_an_exception_when_quantity_is_invalid(): void
    {
        $basketItem = new BasketItem(new Product('A', '1', 1), 1);

        self::expectException(InvalidArgumentException::class);

        $basketItem->incrementQuantity(-1);
    }
}
