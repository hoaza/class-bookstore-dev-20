<?php

namespace Webshop;

class Article extends Entity
{
    private $categoryId;
    private $shoppingListId;
    private $caption;
    private $quantity;
    private $maxPrice;

    public function __construct(
        int $id,
        int $categoryId,
        int $shoppingListId,
        string $caption,
        int $quantity,
        float $maxPrice
    ) {
        parent::__construct($id);
        $this->categoryId = $categoryId;
        $this->shoppingListId = $shoppingListId;
        $this->caption = $caption;
        $this->quantity = $quantity;
        $this->maxPrice = $maxPrice;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
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
