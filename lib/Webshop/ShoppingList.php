<?php


namespace Webshop;

use DateTime;

SessionContext::create();

class ShoppingList extends Entity
{
    private $userId;
    private $caption;
    private $dueDateTime;
    private $closed;
    private $entrepreneurUserId;
    private $pricePaid;

    public function __construct(
        int $id,
        int $userId,
        string $caption,
        $dueDateTime,
        bool $closed,
        ?int $entrepreneurUserId,
        $pricePaid
    ) {
        parent::__construct($id);
        $this->userId = $userId;
        $this->caption = $caption;
        $this->dueDateTime = $dueDateTime;
        $this->closed = $closed;
        $this->entrepreneurUserId = $entrepreneurUserId;
        $this->pricePaid = $pricePaid;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCaption(): string
    {
        return $this->caption;
    }

    public function getDueDateTime(): string
    {
        return $this->dueDateTime;
    }
    
    public function getClosed(): bool
    {
        return $this->closed;
    }

    public function getEntrepreneurUserId(): ?int
    {
        return $this->entrepreneurUserId;
    }

    public function getPricePaid()
    {
        return $this->pricePaid;
    }
}
