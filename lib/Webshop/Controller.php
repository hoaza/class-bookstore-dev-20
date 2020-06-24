<?php


namespace Webshop;

use Data\DataManager;
use Exception;
use Logger\LoggerManager;

class Controller extends BaseObject
{
    const ACTION = 'action';
    const PAGE = 'page';

    const ACTION_SHOW_ARTICLES = 'showArticles';
    const ACTION_REMOVE_ARTICLE = 'removeFromShoppingList';
    const ACTION_REMOVE_LIST = 'ACTION_REMOVE_LIST';
    const ACTION_TAKE_OVER_LIST = 'ACTION_TAKE_OVER_LIST';
    const ACTION_CLOSE_SHOPPING_LIST = 'ACTION_CLOSE_SHOPPING_LIST';

    const ACTION_ADD_SHOPPING_LIST = 'addShoppingList';
    const ACTION_ADD_ARTICLE = 'addArticle';
    const ACTION_LOGIN = 'login';
    const ACTION_LOGOUT = 'logout';
    const ACTION_ORDER = 'placeOrder';

    const USER_NAME = 'userName';
    const USER_PASSWORD = 'password';

    const SHOPPING_LIST_ID = 'shoppingListId';
    const SHOPPING_LIST_CAPTION = 'caption';
    const SHOPPING_LIST_DUEDATETIME = 'dueDateTime';

    const ARTICLE_ID = 'articleId';

    const ARTICLE_CAPTION = 'caption';
    const ARTICLE_QUANTITY = 'ARTICLE_QUANTITY';
    const ARTICLE_MAX_PRICE = 'articleMaxPrice';

    private static $instance = false;

    public static function getInstance(): Controller
    {
        if (!self::$instance) {
            self::$instance = new Controller();
        }
        return self::$instance;
    }

    private function __construct()
    {
    }


    public function invokePostAction(): ?bool
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            throw new \Exception('Controller can only handle Post Requests');
            return null;
        } elseif (!isset($_REQUEST[self::ACTION])) {
            throw new \Exception(self::ACTION . ' not specified.');
            return null;
        }

        $action = $_REQUEST[self::ACTION];


        switch ($action) {
            case self::ACTION_LOGIN:
                if (!AuthenticationManager::authenticate($_REQUEST[self::USER_NAME], $_REQUEST[self::USER_PASSWORD])) {
                    $this->forwardRequest(array('Invalid user name or password.'));
                }

                LoggerManager::logAction("ACTION_LOGIN");

                Util::redirect();
                break;

            case self::ACTION_ADD_SHOPPING_LIST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Nicht eingelogged. Bitte anmelden']);
                    Util::redirect('index.php?view=login');
                } else if (!$user->isTypeOf(UserType::NEEDSHELP)) {
                    $this->forwardRequest(['Sie haben keine Berechtigung dafür!']);
                }

                LoggerManager::logAction("ACTION_ADD_SHOPPING_LIST");

                $caption = $_POST[self::SHOPPING_LIST_CAPTION];
                $dueDateTime = $_POST[self::SHOPPING_LIST_DUEDATETIME];

                DataManager::createShoppingList($user->getId(), $caption, $dueDateTime);

                Util::redirect();
                break;

            case self::ACTION_CLOSE_SHOPPING_LIST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Nicht eingelogged. Bitte anmelden']);
                    Util::redirect('index.php?view=login');
                } else if (!$user->isTypeOf(UserType::ENTREPRENEUR)) {
                    $this->forwardRequest(['Sie haben keine Berechtigung dafür!']);
                }

                $shoppingListId = $_POST[self::SHOPPING_LIST_ID];
                $maxPrice = $_POST[self::ARTICLE_MAX_PRICE];

                DataManager::closeShoppingList($shoppingListId, $maxPrice);

                Util::redirect();
                break;

            case self::ACTION_ADD_ARTICLE:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Nicht eingelogged. Bitte anmelden']);
                    Util::redirect('index.php?view=login');
                } else if ($user->isTypeOf(UserType::NEEDSHELP) == false) {
                    $this->forwardRequest(['Sie haben keine Berechtigung dafür!']);
                }

                $shoppingListId = $_POST[self::SHOPPING_LIST_ID];
                $caption = $_POST[self::ARTICLE_CAPTION];
                $quantity = $_POST[self::ARTICLE_QUANTITY];
                $maxPrice = $_POST[self::ARTICLE_MAX_PRICE];

                DataManager::createArticle($shoppingListId, $caption, $quantity, $maxPrice);

                Util::redirect();
                break;

            case self::ACTION_SHOW_ARTICLES:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }
                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID];
                Util::redirect('index.php?view=articlelist&shoppingListId=' . rawurlencode($shoppingListId));
                break;

            case self::ACTION_REMOVE_ARTICLE:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }
                $articleId = $_REQUEST[self::ARTICLE_ID];
                DataManager::removeArticle($articleId);
                Util::redirect();
                break;

            case self::ACTION_REMOVE_LIST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }
                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID];
                DataManager::removeShoppingList($shoppingListId);
                Util::redirect();
                break;

            case self::ACTION_TAKE_OVER_LIST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }

                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID];

                DataManager::takeOverShoppingList($shoppingListId, $user->getId());
                Util::redirect();
                break;

            case self::ACTION_LOGIN:
                if (!AuthenticationManager::authenticate($_REQUEST[self::USER_NAME], $_REQUEST[self::USER_PASSWORD])) {
                    $this->forwardRequest(array('Invalid user name or password.'));
                }
                Util::redirect();
                break;

            case self::ACTION_LOGOUT:
                //sign out current user
                AuthenticationManager::signOut();
                Util::redirect();
                break;



                // case self::ACTION_ORDER:
                //     $user = AuthenticationManager::getAuthenticatedUser();
                //     if ($user == null) {
                //         $this->forwardRequest(['Not logged in.']);
                //     }
                //     if (!$this->processCheckout($_POST[self::CC_NAME], $_POST[self::CC_NUMBER])) {
                //         $this->forwardRequest(['Checkout failed']);
                //     }
                //     break;

            default:
                throw new \Exception('Unknown controller action: ' . $action);
                return null;
                break;
        }
    }


    protected function processCheckout(string $nameOnCard = null, string $cardNumber = null): bool
    {
        // $errors = [];

        // if ($nameOnCard == null || strlen($nameOnCard) == 0) {
        //     $errors[] = 'Invalid name on card';
        // }
        // if ($cardNumber == null || strlen($cardNumber) != 16 || !ctype_digit($cardNumber)) {
        //     $errors[] = 'Card number must be sixteen digits';
        // }

        // if (sizeof($errors) > 0) {
        //     $this->forwardRequest($errors);
        //     return false;
        // }

        // // check cart
        // if (ShoppingList::size() == 0) {
        //     $this->forwardRequest(['Shopping cart is empty']);
        //     return false;
        // }

        // $user = AuthenticationManager::getAuthenticatedUser();
        // $orderId = \Data\DataManager::createOrder($user->getId(), ShoppingList::getAll(), $nameOnCard, $cardNumber);
        // if (!$orderId) {
        //     $this->forwardRequest(['Could not create order']);
        //     return false;
        // }
        // ShoppingList::clear();
        // Util::redirect('index.php?view=success&orderId=' . rawurlencode($orderId));

        return true;
    }


    /**
     *
     * @param array $errors : optional assign it to
     * @param string $target : url for redirect of the request
     */
    protected function forwardRequest(array $errors = null, $target = null)
    {
        //check for given target and try to fall back to previous page if needed
        if ($target == null) {
            if (!isset($_REQUEST[self::PAGE])) {
                throw new Exception('Missing target for forward.');
            }
            $target = $_REQUEST[self::PAGE];
        }
        //forward request to target
        // optional - add errors to redirect and process them in view
        if (count($errors) > 0)
            $target .= '&errors=' . urlencode(serialize($errors));
        header('location: ' . $target);
        exit();
    }
}
