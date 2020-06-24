<?php

namespace Webshop;

class Article extends Entity
{
    private $shoppingListId;
    private $caption;
    private $quantity;
    private $maxPrice;
    private $done;

    public function __construct(
        int $id,
        int $shoppingListId,
        string $caption,
        int $quantity,
        float $maxPrice,
        bool $done
    ) {
        parent::__construct($id);
        $this->shoppingListId = $shoppingListId;
        $this->caption = $caption;
        $this->quantity = $quantity;
        $this->maxPrice = $maxPrice;
        $this->done = $done;
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

    public function getDone(): bool
    {
        return $this->done;
    }
}
