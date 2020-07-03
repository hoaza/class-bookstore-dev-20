<?php


namespace Webshop;

use Data\DataManager;
use Exception;
use Logger\LogManager;

class Controller extends BaseObject
{
    const ACTION = 'action';
    const PAGE = 'page';

    const ACTION_SHOW_ARTICLES = 'showArticles';
    const ACTION_REMOVE_ARTICLE = 'removeFromShoppingList';
    const ACTION_CHANGE_ARTICLE_DONE = 'ACTION_CHANGE_ARTICLE_DONE';

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

                $user = AuthenticationManager::getAuthenticatedUser();

                LogManager::logAction("ACTION_LOGIN");

                Util::redirect('index.php?view=' . $user->getTypeString() . '/openShopLists');
                break;

            case self::ACTION_ADD_SHOPPING_LIST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Nicht eingelogged. Bitte anmelden']);
                    Util::redirect('index.php?view=login');
                } else if (!$user->isTypeOf(UserType::NEEDSHELP)) {
                    $this->forwardRequest(['Sie haben keine Berechtigung dafür!']);
                }

                LogManager::logAction("ACTION_ADD_SHOPPING_LIST");

                $caption = $_POST[self::SHOPPING_LIST_CAPTION];

                if ($caption == null  || is_string($caption) == false || empty(trim($caption))) {
                    $this->forwardRequest(['Ungültiger Name, Der Name der Einkaufsliste darf nicht leer sein!']);
                }

                $dueDateTime = $_POST[self::SHOPPING_LIST_DUEDATETIME];

                if ($dueDateTime == null  || strtotime($dueDateTime) == false || strtotime($dueDateTime) < strtotime('-1 day', time())) {
                    $this->forwardRequest(['Ungültiges Datum, Das Datum der Einkaufsliste darf nicht leer sein und muss in der Zukunft sein!']);
                }

                DataManager::createShoppingList($user->getId(), $caption, $dueDateTime);

                Util::redirect(null, ['Einkaufsliste erfolgreich eingefügt!']);
                break;

            case self::ACTION_CLOSE_SHOPPING_LIST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Nicht eingelogged. Bitte anmelden']);
                    Util::redirect('index.php?view=login');
                } else if (!$user->isTypeOf(UserType::ENTREPRENEUR)) {
                    $this->forwardRequest(['Sie haben keine Berechtigung dafür!']);
                }

                LogManager::logAction("ACTION_CLOSE_SHOPPING_LIST");

                $shoppingListId = $_POST[self::SHOPPING_LIST_ID];
                $maxPrice = $_POST[self::ARTICLE_MAX_PRICE];

                if ($maxPrice == null  || is_numeric($maxPrice) == false || $maxPrice < 0) {
                    $this->forwardRequest(['Ungültiger Preis, Der Preis darf nicht leer und muss größer als 0 sein!']);
                }


                DataManager::closeShoppingList($shoppingListId, $maxPrice);

                Util::redirect(null, ['Einkaufsliste erfolgreich abgeschlossen!']);
                break;

            case self::ACTION_ADD_ARTICLE:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['Nicht eingelogged. Bitte anmelden']);
                    Util::redirect('index.php?view=login');
                } else if ($user->isTypeOf(UserType::NEEDSHELP) == false) {
                    $this->forwardRequest(['Sie haben keine Berechtigung dafür!']);
                }

                LogManager::logAction("ACTION_ADD_ARTICLE");

                $shoppingListId = $_POST[self::SHOPPING_LIST_ID];

                $caption = $_POST[self::ARTICLE_CAPTION];

                if ($caption == null  || is_string($caption) == false || empty(trim($caption))) {
                    $this->forwardRequest(['Ungültiger Name, Der Name des Artikels darf nicht leer sein!']);
                }

                $quantity = $_POST[self::ARTICLE_QUANTITY];

                if ($quantity == null  || is_numeric($quantity) == false || $quantity <= 0) {
                    $this->forwardRequest(['Ungültige Anzahl, Die Anzahl des Artikels darf nicht leer und muss größer als 0 sein!']);
                }

                $maxPrice = $_POST[self::ARTICLE_MAX_PRICE];

                if ($maxPrice == null  || is_numeric($maxPrice) == false || $maxPrice < 0) {
                    $this->forwardRequest(['Ungültiger Preis, Der Preis des Artikels darf nicht leer und muss größer als 0 sein!']);
                }

                DataManager::createArticle($shoppingListId, $caption, $quantity, $maxPrice);

                Util::redirect(null, ['Artikel erfolgreich eingefügt!']);
                break;

            case self::ACTION_SHOW_ARTICLES:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }

                LogManager::logAction("ACTION_SHOW_ARTICLES");

                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID];
                Util::redirect('index.php?view=articlelist&shoppingListId=' . rawurlencode($shoppingListId));
                break;

            case self::ACTION_REMOVE_ARTICLE:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }

                LogManager::logAction("ACTION_REMOVE_ARTICLE");

                $articleId = $_REQUEST[self::ARTICLE_ID];
                DataManager::removeArticle($articleId);
                Util::redirect(null, ['Artikel erfolgreich gelöscht!']);
                break;


            case self::ACTION_CHANGE_ARTICLE_DONE:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }else if ($user->getTypeString() != UserType::ENTREPRENEUR){
                    $this->forwardRequest(['keine Berechtigung']);
                }

                LogManager::logAction("ACTION_CHANGE_ARTICLE_DONE");

                $articleId = $_REQUEST[self::ARTICLE_ID];
                DataManager::invertArticleDoneStatus($articleId);
                Util::redirect(null, ['Status des Artikels erfolgreich umgestellt!']);
                break;
            case self::ACTION_REMOVE_LIST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }

                LogManager::logAction("ACTION_REMOVE_LIST");

                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID];
                DataManager::removeShoppingList($shoppingListId);
                Util::redirect(null, ['Einkaufsliste erfolgreich gelöscht!']);
                break;

            case self::ACTION_TAKE_OVER_LIST:
                $user = AuthenticationManager::getAuthenticatedUser();
                if ($user == null) {
                    $this->forwardRequest(['nicht eingeloggt']);
                }

                LogManager::logAction("ACTION_TAKE_OVER_LIST");
                $shoppingListId = $_REQUEST[self::SHOPPING_LIST_ID];
                DataManager::takeOverShoppingList($shoppingListId, $user->getId());
                Util::redirect(null, ['Einkaufsliste erfolgreich übernommen!']);
                break;
            case self::ACTION_LOGOUT:
                AuthenticationManager::signOut();
                LogManager::logAction("ACTION_LOGOUT");
                Util::redirect('index.php?view=login');
                break;
            default:
                throw new \Exception('Unknown controller action: ' . $action);
                return null;
                break;
        }
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
            $target .= '&successMessages=';

        header('location: ' . $target);

        exit();
    }
}
