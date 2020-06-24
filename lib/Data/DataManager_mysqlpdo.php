<?php

namespace Data;

use DateTime;
use Webshop\Category;
use Webshop\Article;
use Webshop\User;
use Webshop\PagingResult;
use Webshop\ShoppingList;
use Webshop\UserType;

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
            // SELECT * FROM book WHERE id = ? AND price > ?
            /*
             * $parameters = [1, 12.00]
             *
             */
            $statement = $connection->prepare($query);
            $i = 1;
            foreach ($parameters as $param) {
                if (is_int($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_INT);
                }
                if (is_string($param)) {
                    $statement->bindValue($i, $param, \PDO::PARAM_STR);
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
     * get the categories
     *
     * note: global …; -> suboptimal
     *
     * @return array of Category-items
     */
    public static function getCategories(): array
    {
        $categories = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, name 
            FROM category;
        ");

        while ($cat = self::fetchObject($res)) {
            $categories[] = new Category($cat->id, $cat->name);
        }
        self::close($res);
        self::closeConnection();
        return $categories;
    }

    /**
     * get the books per category
     *
     * @param integer $categoryId numeric id of the category
     * @return array of Book-items
     */
    public static function getArticlesByCategory(int $categoryId): array
    {
        $articles = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, categoryId, shoppingListId, caption, quantity, maxPrice  
            FROM article 
            WHERE categoryId = ?;
        ", [$categoryId]);

        while ($article = self::fetchObject($res)) {
            $articles[] = new Article($article->id, $article->categoryId, $article->shoppingListId, $article->caption, $article->quantity, $article->maxPrice);
        }
        self::close($res);
        self::closeConnection();
        return $articles;
    }

    /**
     * get the books per category
     *
     * @param integer $categoryId numeric id of the category
     * @return array of Book-items
     */
    public static function getArticlesByShoppingListId(int $shoppingListId): array
    {
        $articles = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, categoryId, shoppingListId, caption, quantity, maxPrice  
            FROM article 
            WHERE shoppingListId = ?;
        ", [$shoppingListId]);

        while ($article = self::fetchObject($res)) {
            $articles[] = new Article($article->id, $article->categoryId, $article->shoppingListId, $article->caption, $article->quantity, $article->maxPrice);
        }
        self::close($res);
        self::closeConnection();
        return $articles;
    }



    /**
     * get the books per category
     *
     * @param integer $categoryId numeric id of the category
     * @return array of Book-items
     */
    public static function getShoppingListsBy(int $userId = null, bool $closed = null, int $entrepreneurUserId = null): array
    {
        $shoppintLists = [];
        $con = self::getConnection();
        $res = self::query($con, "
            SELECT id, caption, dueDateTime, closed, entrepreneurUserId, pricePaid  
            FROM shoppintlist 
            WHERE 1 = 1 "
            + ($userId == null ? "" : ("\AND userId = " + $userId)) +
            + ($closed == null ? "" : ("\AND closed = " + $closed)) +
                + ($entrepreneurUserId == null ? "" : ("\AND closed = " + $entrepreneurUserId)) +
                    ";
        ");

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
     * get the books per search term
     *
     * note: stripos() – returns index (also 0!) on success and -1 on error
     * 0 == false but 0 === true -> thus test for !== false
     *
     * "This function may return Boolean FALSE, but may also return a
     * non-Boolean value which evaluates to FALSE. Please read the section
     * on Booleans for more information. Use the === operator for testing
     * the return value of this function." -- http://php.net/manual/en/function.stripos.php
     *
     * @param string $term search term: book title string match
     * @return array of Book-items
     */
    // public static function getBooksForSearchCriteria(string $term): array
    // {
    //     $books = [];
    //     $con = self::getConnection();
    //     $res = self::query($con, "
    //       SELECT id, categoryId, title, author, price 
    //       FROM books 
    //       WHERE title LIKE ?;
    //       ", ["%" . $term . "%"]);
    //     while ($book = self::fetchObject($res)) {
    //         $books[] = new Book($book->id, $book->categoryId, $book->title, $book->author, $book->price);
    //     }
    //     self::close($res);
    //     self::closeConnection($con);
    //     return $books;

    // }

    /**
     * get the books per search term – paginated set only
     *
     * @param string $term  search term: book title string match
     * @param integer $offset  start at the nth item
     * @param integer $numPerPage  number of items per page
     * @return array of Book-items
     */
    // public static function getBooksForSearchCriteriaWithPaging($term, $offset, $numPerPage) {
    //     $con = self::getConnection();
    //     //query total count
    //     $res = self::query($con, "
    //       SELECT COUNT(*) AS cnt 
    //       FROM books 
    //       WHERE title LIKE ?;
    //   ", ["%" . $term . "%"]);
    //     $totalCount = self::fetchObject($res)->cnt;
    //     self::close($res);
    //     //query books to return
    //     $books = [];
    //     $res = self::query($con, "
    //       SELECT id, categoryId, title, author, price 
    //       FROM books 
    //       WHERE title 
    //       LIKE ? LIMIT ?, ?;
    //   ", ["%" . $term . "%", intval($offset), intval($numPerPage)]);
    //     while ($book = self::fetchObject($res)) {
    //         $books[] = new Book($book->id, $book->categoryId, $book->title, $book->author, $book->price);
    //     }
    //     self::close($res);
    //     self::closeConnection($con);
    //     return new PagingResult($books, $offset, $totalCount);
    // }

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
        DateTime $dueDateTime,
        bool $closed,
        int $entrepreneurUserId,
        float $pricePaid
    ): int {
        $con = self::getConnection();
        $con->beginTransaction();

        try {

            self::query($con, "
                INSERT INTO shoppinglist ( 
                    userId, 
                    caption, 
                    dueDateTime,
                    closed,
                    entrepreneurUserId,
                    pricePaid
                ) VALUES (
                    ?, ?, ?, ?, ?, ?
                );
            ", [$userId, $caption, $dueDateTime, $closed, $entrepreneurUserId, $pricePaid]);

            $shoppingListId = self::lastInsertId($con);
            $con->commit();
        } catch (\Exception $e) {
            $con->rollBack();
            $shoppingListId = null;
        }
        self::closeConnection();
        return $shoppingListId;
    }
}
