<?php

namespace Data;

use DateTime;

interface IDataManager
{
    public static function getArticlesByShoppingListId(int $shoppingListId): array;
    public static function getUnlinkedShoppingListsByState(bool $closed): array;
    public static function getShoppingListsByStateAndEntrepreneurId(bool $closed, int $entrepreneurId): array;
    public static function getUnlinkedShoppingListsByUserId(int $userId): array;
    public static function getLinkedShoppingListsByStateAndUserId(bool $closed, int $userId): array;

    public static function getShoppingListById(int $shoppinglistId);

    public static function getUserById(int $userId);
    public static function getUserByUserName(string $userName);
    public static function createShoppingList(int $userId, string $caption, string $dueDateTime): ?int;
    public static function logAction(string $action,string $ipAddress,$userName);
}