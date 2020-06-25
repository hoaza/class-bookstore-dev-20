<?php

namespace Data;

use Webshop\Article;
use Webshop\User;
use Webshop\ShoppingList;


class DataManager implements IDataManager
{

    private static $__connection;

    private static function getConnection()
    {

        if (!isset(self::$__connection)) {

            $type = 'mysql';
            $host = 'localhost';
            $name = 'fh_2020_scm4_s1810307014';
            $user = 'root';
            $pass = '';

            self::$__connection = new \PDO($type . ':host=' . $host . ';dbname=' . $name . ';charset=utf8', $user, $pass);
        }
        return self::$__connection;
    }

    public static function exposeConnection()
    {
        return self::getConnection();
    }


    private static function query($connection, $query, $parameters = [])
    {
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        try {
            $statement = $connection->prepare($query);
            $i = 1;
            foreach ($parameters as $param) {
                if (is_int($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_INT);
                }
                if (is_string($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_STR);
                }
                if (is_bool($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_BOOL);
                }

                $i++;
            }
            $statement->execute();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
        return $statement;
    }


    private static function fetchObject($cursor)
    {
        return $cursor->fetch(\PDO::FETCH_OBJ);
    }

    private static function close($cursor)
    {
        $cursor->closeCursor();
    }

    private static function closeConnection()
    {
        self::$__connection = null;
    }

    private static function lastInsertId($connection)
    {
        return $connection->lastInsertId();
    }

    /**
     * get the books per 
     *
     * @param integer $catgoryId numeric id of the 
     * @return array of Book-items
     */
    public static function getArticlesByShoppingListId(int $shoppingListId): array
    {
        $articles = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, shoppingListId, caption, quantity, maxPrice, done  
            FROM article
            WHERE 1 = 1 
                AND active = 1
                AND shoppingListId = ?;
        ", [$shoppingListId]);

        while ($article = self::fetchObject($res)) {
            $articles[] = new Article($article->id, $article->shoppingListId, $article->caption, $article->quantity, $article->maxPrice, $article->done);
        }
        self::close($res);
        self::closeConnection();
        return $articles;
    }


    /**
     * get the books per 
     *

     * @return array of Book-items
     */
    public static function getShoppingListById(int $shoppinglistId)
    {
        $shoppintLists = null;
        $con = self::getConnection();
        $res = self::query(
            $con,
            "
            SELECT id, userId, caption, dueDateTime, closed, entrepreneurUserId, pricePaid  
            FROM shoppinglist 
            WHERE 1 = 1
                AND id = ?;",
            [$shoppinglistId]
        );

        while ($shoppintList = self::fetchObject($res)) {
            $shoppintLists = new ShoppingList(
                $shoppintList->id,
                $shoppintList->userId,
                $shoppintList->caption,
                $shoppintList->dueDateTime,
                $shoppintList->closed,
                $shoppintList->entrepreneurUserId,
                $shoppintList->pricePaid
            );
        }
        self::close($res);
        self::closeConnection();
        return $shoppintLists;
    }



    /**
     * get the books per 
     *
     * @param integer $ numeric id of the 
     * @return array of Book-items
     */
    public static function getUnlinkedShoppingListsByState(bool $closed): array
    {
        $shoppintLists = [];
        $con = self::getConnection();
        $res = self::query(
            $con,
            "
            SELECT id, userId, caption, dueDateTime, closed, entrepreneurUserId, pricePaid  
            FROM shoppinglist 
            WHERE 1 = 1
                AND active = 1
                AND entrepreneurUserId is NULL
                AND closed = ?;",
            [$closed]
        );

        while ($shoppintList = self::fetchObject($res)) {
            $shoppintLists[] = new ShoppingList(
                $shoppintList->id,
                $shoppintList->userId,
                $shoppintList->caption,
                $shoppintList->dueDateTime,
                $shoppintList->closed,
                $shoppintList->entrepreneurUserId,
                $shoppintList->pricePaid
            );
        }
        self::close($res);
        self::closeConnection();
        return $shoppintLists;
    }

    /**
     * get the books per 
     *
     * @param integer  numeric id of the
     * @return array of Book-items
     */
    public static function getShoppingListsByStateAndEntrepreneurId(bool $closed, int $entrepreneurUserId): array
    {
        $shoppintLists = [];
        $con = self::getConnection();
        $res = self::query(
            $con,
            "
            SELECT id, userId, caption, dueDateTime, closed, entrepreneurUserId, pricePaid  
            FROM shoppinglist 
            WHERE 1 = 1
                AND active = 1
                AND closed = ?
                AND entrepreneurUserId = ?;",
            [$closed, $entrepreneurUserId]
        );

        while ($shoppintList = self::fetchObject($res)) {
            $shoppintLists[] = new ShoppingList(
                $shoppintList->id,
                $shoppintList->userId,
                $shoppintList->caption,
                $shoppintList->dueDateTime,
                $shoppintList->closed,
                $shoppintList->entrepreneurUserId,
                $shoppintList->pricePaid
            );
        }
        self::close($res);
        self::closeConnection();
        return $shoppintLists;
    }

    /**
     * get the books per
     *
     * @param integer  numeric id of the
     * @return array of Book-items
     */
    public static function getUnlinkedShoppingListsByUserId(int $userId): array
    {
        $shoppintLists = [];
        $con = self::getConnection();
        $res = self::query(
            $con,
            "
            SELECT id, userId, caption, dueDateTime, closed, entrepreneurUserId, pricePaid  
            FROM shoppinglist 
            WHERE 1 = 1
                AND active = 1
                AND entrepreneurUserId is NULL
                AND userId = ?;",
            [$userId]
        );

        while ($shoppintList = self::fetchObject($res)) {
            $shoppintLists[] = new ShoppingList(
                $shoppintList->id,
                $shoppintList->userId,
                $shoppintList->caption,
                $shoppintList->dueDateTime,
                $shoppintList->closed,
                $shoppintList->entrepreneurUserId,
                $shoppintList->pricePaid
            );
        }
        self::close($res);
        self::closeConnection();
        return $shoppintLists;
    }


    /**
     * get the books per 
     *
     * @param integer  numeric id of the 
     * @return array of Book-items
     */
    public static function getLinkedShoppingListsByStateAndUserId(bool $closed, int $userId): array
    {
        $shoppintLists = [];
        $con = self::getConnection();
        $res = self::query(
            $con,
            "
            SELECT id, userId, caption, dueDateTime, closed, entrepreneurUserId, pricePaid  
            FROM shoppinglist 
            WHERE 1 = 1
                AND active = 1
                AND entrepreneurUserId is NOT NULL
                AND closed = ?
                AND userId = ?;",
            [$closed, $userId]
        );

        while ($shoppintList = self::fetchObject($res)) {
            $shoppintLists[] = new ShoppingList(
                $shoppintList->id,
                $shoppintList->userId,
                $shoppintList->caption,
                $shoppintList->dueDateTime,
                $shoppintList->closed,
                $shoppintList->entrepreneurUserId,
                $shoppintList->pricePaid
            );
        }
        self::close($res);
        self::closeConnection();
        return $shoppintLists;
    }


    public static function removeArticle(int $articleId)
    {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query($con, "
                UPDATE article 
                SET active = 0
                WHERE id = ?
            ", [$articleId]);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
        }
        self::closeConnection();
    }

    public static function invertArticleDoneStatus(int $articleId)
    {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query($con, "
                UPDATE article 
                SET done = NOT done
                WHERE id = ?
            ", [$articleId]);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
        }
        self::closeConnection();
    }


    public static function removeShoppingList(int $shoppingList)
    {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query($con, "
                UPDATE shoppinglist 
                SET active = 0
                WHERE id = ?
            ", [$shoppingList]);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
        }
        self::closeConnection();
    }

    public static function takeOverShoppingList(int $shoppingList, int $entrepreneurUserId)
    {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query($con, "
                UPDATE shoppinglist 
                SET entrepreneurUserId = ?
                WHERE id = ?
            ", [$entrepreneurUserId, $shoppingList]);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
        }
        self::closeConnection();
    }

    public static function closeShoppingList(int $shoppingList, $maxPrice)
    {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query($con, "
                UPDATE shoppinglist 
                SET closed = 1,
                    pricePaid = ?
                WHERE id = ?
            ", [$maxPrice, $shoppingList]);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
        }
        self::closeConnection();
    }

    /**
     * get the User item by id
     *
     * @param integer $userId uid of that user
     * @return User | null
     */
    public static function getUserById(int $userId)
    { // no return type, cos "null" is not a valid User
        $user = null;
        $con = self::getConnection();
        $res = self::query($con, " 
            SELECT id, userName, passwordHash, type 
            FROM user
            WHERE id = ?;
        ", [$userId]);
        if ($u = self::fetchObject($res)) {
            $user = new User($u->id, $u->userName, $u->passwordHash, $u->type);
        }
        self::close($res);
        self::closeConnection($con);
        return $user;
    }

    /**
     * get the User item by name
     *
     * note: show for case sensitive and insensitive options
     *
     * @param string $userName name of that user - must be exact match
     * @return User | null
     */
    public static function getUserByUserName(string $userName)
    {
        $user = null;
        $con = self::getConnection();
        $res = self::query($con, " 
            SELECT id, userName, passwordHash, type 
            FROM user
            WHERE userName = ?;
        ", [$userName]);
        if ($u = self::fetchObject($res)) {
            // $type = UserType::NEEDSHELP;


            // if ($u->type == "NEEDSHELP" ? UserType::NEEDSHELP : UserType::ENTREPRENEUR){
            //     $type = UserType::NEEDSHELP;
            // }
            // else if ($u->type == "ENTREPRENEUR"){
            //     $type = UserType::ENTREPRENEUR;
            // }
            // else{
            //     // throw new Exception("UserType " + $u->type + " doesnt exists in Code");
            // }

            $user = new User($u->id, $u->userName, $u->passwordHash, $u->type);
        }
        self::close($res);
        self::closeConnection($con);
        return $user;
    }

    /**
     * place to order with the shopping cart items
     *
     * note: nothing to do here without the database
     * random order id can be used to demonstrate that POST is only executed once
     *
     * @param integer $userId id of the ordering user
     * @param array $bookIds integers of book ids
     * @param string $nameOnCard cc name
     * @param string $cardNumber cc number
     * @return integer
     */
    public static function createShoppingList(
        int $userId,
        string $caption,
        $dueDateTime
    ): ?int {
        $con = self::getConnection();
        $con->beginTransaction();

        try {

            self::query($con, "
                INSERT INTO shoppinglist ( 
                    userId, 
                    caption, 
                    dueDateTime
                ) VALUES (
                    ?, ?, ?
                );
            ", [$userId, $caption, $dueDateTime]);

            $shoppingListId = self::lastInsertId($con);
            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
            $shoppingListId = null;
        }

        self::closeConnection();

        return $shoppingListId;
    }

    public static function createArticle(
        int $shoppingListId,
        string $caption,
        int $quantity,
        $maxPrice
    ): ?int {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query($con, "
                INSERT INTO article ( 
                    shoppingListId,
                    caption, 
                    quantity,
                    maxPrice
                ) VALUES (
                    ?, ?, ?, ?
                );
            ", [$shoppingListId, $caption, $quantity, $maxPrice]);

            $articleId = self::lastInsertId($con);
            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
            $articleId = null;
        }

        self::closeConnection();

        return $articleId;
    }


    public static function logAction(
        string $action,
        string $ipAddress,
        $userName
    ) {
        $con = self::getConnection();
        $con->beginTransaction();

        try {
            self::query($con, "
                INSERT INTO log ( 
                    action,
                    ipAddress, 
                    userName
                ) VALUES (
                    ?, ?, ?
                );
            ", [$action, $ipAddress, $userName]);

            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
        }

        self::closeConnection();
    }
}
