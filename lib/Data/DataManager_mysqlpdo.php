<?php


namespace Data;
use Bookshop\Category;
use Bookshop\Book;
use Bookshop\User;



class DataManager implements IDataManager
{

    private static $__connection;

    private static function getConnection() {

        if (!isset(self::$__connection)) {

            $type = 'mysql';
            $host = 'localhost';
            $name = 'fh_scm4_bookshop';
            $user = 'root';
            $pass = '';

            self::$__connection = new \PDO($type . ':host=' . $host . ';dbname=' . $name . ';charset=utf8', $user, $pass);
        }
        return self::$__connection;


    }

    public static function exposeConnection() {
        return self::getConnection();
    }


    /**
     * get the categories
     *
     * note: global …; -> suboptimal
     *
     * @return array of Category-items
     */
    public static function getCategories() : array {
        $categories = [];
        $con = self::getConnection();
        var_dump($con);

        return $categories;

    }

    /**
     * get the books per category
     *
     * @param integer $categoryId  numeric id of the category
     * @return array of Book-items
     */
    public static function getBooksByCategory(int $categoryId) : array {


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
     * @param string $term  search term: book title string match
     * @return array of Book-items
     */
    public static function getBooksForSearchCriteria(string $term) : array {


    }

    /**
     * get the books per search term – paginated set only
     *
     * @param string $term  search term: book title string match
     * @param integer $offset  start at the nth item
     * @param integer $numPerPage  number of items per page
     * @return PagingResult
     */
    public static function getBooksForSearchCriteriaWithPaging(string $term, int $offset, int $numPerPage) : PagingResult {

    }

    /**
     * get the User item by id
     *
     * @param integer $userId  uid of that user
     * @return User | null
     */
    public static function getUserById(int $userId) { // no return type, cos "null" is not a valid User

    }

    /**
     * get the User item by name
     *
     * note: show for case sensitive and insensitive options
     *
     * @param string $userName  name of that user - must be exact match
     * @return User | null
     */
    public static function getUserByUserName(string $userName) { // no return type, cos "null" is not a valid User

    }

    /**
     * place to order with the shopping cart items
     *
     * note: nothing to do here without the database
     * random order id can be used to demonstrate that POST is only executed once
     *
     * @param integer $userId   id of the ordering user
     * @param array $bookIds    integers of book ids
     * @param string $nameOnCard  cc name
     * @param string $cardNumber  cc number
     * @return integer
     */
    public static function createOrder(int $userId, array $bookIds, string $nameOnCard, string $cardNumber) : int {
        return rand();
    }

}
