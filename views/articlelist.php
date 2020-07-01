<?php

use Data\DataManager;
use Webshop\AuthenticationManager;
use Webshop\UserType;
use Webshop\Util;

$user = AuthenticationManager::getAuthenticatedUser();
$userId = isset($user) ? $user->getId() : null;

if (!AuthenticationManager::isAuthenticated()) {
    Util::redirect("index.php?view=login"); 
}

$shoppingListId = $_GET['shoppingListId'];
$list;
$articles = array();
(isset($userId) && ((int) $userId > 0)) ? $list = DataManager::getShoppingListById($shoppingListId) : null;
(isset($userId) && ((int) $userId > 0)) ? $articles = DataManager::getArticlesByShoppingListId($shoppingListId) : null;

require_once('views/partials/header.php');


$addArticleVisible = is_null($list) == false && is_null($userId) == false && $user->isTypeOf(UserType::NEEDSHELP) &&  $list->getClosed() == false && is_null($list->getEntrepreneurUserId());
?>



<div class="page-header">
    <h2>Einkaufsliste <?php echo Util::escape(is_null($list) == false ? $list->getCaption() : "");  ?></h2>
</div>


<div class="panel-heading" <?php echo Util::escape($addArticleVisible == false ? "hidden" : ""); ?>>
    <h3>Artikel hinzufügen</h3>
</div>

<div class="panel-body" <?php echo Util::escape($addArticleVisible == false ? "hidden" : ""); ?>>
    <form class="form-horizontal" method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_ADD_ARTICLE, array('view' => $view)); ?>">
        <input type="text" hidden name="<?php echo Webshop\Controller::SHOPPING_LIST_ID; ?>" value="<?php echo $_GET['shoppingListId']; ?>" />
        <div class="form-group">
            <label for="inputCaption" class="col-sm-2 control-label">Bezeichnung</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputCaption" name="<?php print Webshop\Controller::ARTICLE_CAPTION; ?>" placeholder="Bezeichnung">
            </div>
        </div>
        <div class="form-group">
            <label for="inputQuantity" class="col-sm-2 control-label">Anzahl</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" id="inputQuantity" name="<?php print Webshop\Controller::ARTICLE_QUANTITY; ?>" placeholder="Menge">
            </div>
        </div>
        <div class="form-group">
            <label for="inputMaxPrice" class="col-sm-2 control-label">Maximaler Preis</label>
            <div class="col-sm-6">
                <input type="number" step="0.01" class="form-control" id="inputMaxPrice" name="<?php print Webshop\Controller::ARTICLE_MAX_PRICE; ?>" placeholder="Maximaler Preis">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">Hinzufügen</button>
            </div>
        </div>
    </form>
</div>
<hr <?php echo Util::escape($addArticleVisible == false ? "hidden" : ""); ?>>
<div class="panel-heading">
    <h3>Artikel in Einkaufsliste</h3>
</div>

<?php if (isset($articles)) { ?>
    <?php
    if (sizeof($articles) <= 0) {
    ?><div class="alert alert-warning" role="alert">Keine Artikel vorhanden</div>
    <?php } else {
    ?>
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Name
                    </th>
                    <th>
                        Anzahl
                    </th>
                    <th>
                        Maximaler Preis
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($articles as $article) :
                ?>
                    <tr>
                        <td><strong>
                                <?php echo Util::escape($article->GetCaption()); ?>
                            </strong>
                        </td>
                        <td>
                            <?php echo Util::escape($article->getQuantity()); ?>
                        </td>
                        <td>
                            <?php echo Util::escape($article->getMaxPrice()); ?>
                        </td>
                        <?php if ($user->isTypeOf(UserType::NEEDSHELP) && $list->getClosed() == false && is_null($list->getEntrepreneurUserId()) == true) { ?>
                            <td class="add-remove">
                                <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_REMOVE_ARTICLE, array('articleId' => $article->getId())); ?>">
                                    <button type="submit" role="button" class="btn btn-default btn-xs btn-danger">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </form>
                            </td>
                        <?php } ?>
                        <?php if ($user->isTypeOf(UserType::ENTREPRENEUR) && $list->getClosed() == false && is_null($list->getEntrepreneurUserId()) == false) { ?>
                            <td class="add-remove">
                                <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_CHANGE_ARTICLE_DONE, array('articleId' => $article->getId())); ?>">
                                    <button type="submit" role="button" class="btn btn-default btn-xs btn-warning">
                                        <span class="glyphicon glyphicon-<?php echo Util::escape($article->getDone() ? "check" : "unchecked"); ?>"></span>
                                    </button>
                                </form>
                            </td>
                        <?php } ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php } ?>
<?php } ?>

<?php require_once('views/partials/footer.php'); ?>