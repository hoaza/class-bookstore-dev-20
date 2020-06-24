<?php 

use Data\DataManager;
use Webshop\AuthenticationManager;
use Webshop\Util;

$user = AuthenticationManager::getAuthenticatedUser();
$userId = isset($user) ? $user->getId() : null; 
(isset($userId) && ((int) $userId > 0)) ? $shoppingLists = DataManager::getLinkedShoppingListsByStateAndUserId(false, $userId) : null;


require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>Einkaufslisten in Abarbeitung</h2>
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