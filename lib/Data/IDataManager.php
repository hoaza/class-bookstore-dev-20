<?php

namespace Data;

use DateTime;

interface IDataManager
{
    public static function getCategories(): array;
    public static function getArticlesByCategory(int $categoryId): array;
    public static function getArticlesByShoppingListId(int $shoppingListId): array;
    public static function getShoppingListsBy(int $userId = null, bool $closed = null, int $entrepreneurUserId = null): array;

    public static function getUserById(int $userId);
    public static function getUserByUserName(string $userName);
    public static function createShoppingList(int $userId, string $caption, DateTime $dueDateTime, bool $closed, int $entrepreneurUserId, float $pricePaid): int;
}
