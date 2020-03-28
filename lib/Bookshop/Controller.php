<?php


namespace Bookshop;


class Controller extends BaseObject
{
    const ACTION = 'action';
    const PAGE = 'page';
    const CC_NAME = 'nameOnCard';
    const CC_NUMBER = 'cardNumber';
    const ACTION_ADD = 'addToCart';
    const ACTION_REMOVE = 'removeFromCart';


    private static $instance = false;

    public static function getInstance() : Controller {
        if (!self::$instance) {
            self::$instance = new Controller();
        }
        return self::$instance;
    }

    private function __construct() {}


    public function invokePostAction () : bool {

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            throw new \Exception('Controller can only handle Post Requests');
            return null;
        }
        elseif (!isset($_REQUEST[self::ACTION])) {
            throw new \Exception(self::ACTION . ' not specified.');
            return null;
        }

        $action = $_REQUEST[self::ACTION];

        switch ($action) {
            case self::ACTION_ADD :
                ShoppingCart::add((int) $_REQUEST['bookId']);
                break;


        }

    }


}