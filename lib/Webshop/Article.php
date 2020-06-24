<?php

namespace Webshop;

class Article extends Entity
{
    private $shoppingListId;
    private $caption;
    private $quantity;
    private $maxPrice;

    public function __construct(
        int $id,
        int $shoppingListId,
        string $caption,
        int $quantity,
        float $maxPrice
    ) {
        parent::__construct($id);
        $this->shoppingListId = $shoppingListId;
        $this->caption = $caption;
        $this->quantity = $quantity;
        $this->maxPrice = $maxPrice;
    }

    public function getShoppingListId(): int
    {
        return $this->shoppingListId;
    }

    public function getCaption(): string
    {
        return $this->caption;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getMaxPrice(): float
    {
        return $this->maxPrice;
    }
}
