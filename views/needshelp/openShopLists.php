<?php

use Data\DataManager;
use Webshop\AuthenticationManager;
use Webshop\Util;

$user = AuthenticationManager::getAuthenticatedUser();
$userId = isset($user) ? $user->getId() : null;
(isset($userId) && ((int) $userId > 0)) ? $shoppingLists = DataManager::getUnlinkedShoppingListsByUserId($userId) : null;

if (!AuthenticationManager::isAuthenticated()) {
    Util::redirect("index.php?view=login"); 
}

$caption = $_REQUEST[Webshop\Controller::SHOPPING_LIST_CAPTION] ?? null;
$dueDateTime = $_REQUEST[Webshop\Controller::SHOPPING_LIST_DUEDATETIME] ?? null;


require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2> Offene Einkaufslisten</h2>
</div>

<div class="panel-heading">
    <h3>Einkaufsliste hinzufügen</h3>
</div>

<div class="panel-body">
    <form class="form-horizontal" method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_ADD_SHOPPING_LIST, array('view' => $view)); ?>">
        <div class="form-group">
            <label for="inputCaption" class="col-sm-2 control-label">Einkaufsliste</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputCaption" name="<?php print Webshop\Controller::SHOPPING_LIST_CAPTION; ?>" placeholder="'Name eingeben'" value="<?php echo htmlentities($caption); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputDueDatetime" class="col-sm-2 control-label">Erledigt bis</label>
            <div class="col-sm-6">
                <input type="date" id="inputDueDatetime" name="<?php print Webshop\Controller::SHOPPING_LIST_DUEDATETIME; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                <button type="submit" class="btn btn-default">Hinzufügen</button>
            </div>
        </div>
    </form>
</div>
<hr>
<div class="panel-heading">
    <h3>Offene Listen</h3>
</div>
<?php if (isset($shoppingLists)) : ?>
    <?php
    if (sizeof($shoppingLists) > 0) :
        require('views/partials/shoppingLists.php');
    else :
    ?>
        <div class="alert alert-warning" role="alert">Keine Einkaufslisten vorhanden</div>
    <?php endif; ?>
<?php endif; ?>


<?php require_once('views/partials/footer.php'); ?>