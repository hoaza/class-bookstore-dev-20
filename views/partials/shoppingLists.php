<?php
require_once('views/partials/header.php');

use Webshop\UserType;
use Webshop\Util, Data\DataManager, Webshop\AuthenticationManager;

$user = AuthenticationManager::getAuthenticatedUser();

?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>
                Name
            </th>
            <th>
                Hilfesuchender
            </th>
            <th>
                Freiwilliger
            </th>
            <th>
                Enddatum
            </th>
            <th>
                Bezahlter Preis
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($shoppingLists as $list) :
        ?>
            <tr>
                <td>
                    <strong>
                        <?php echo Util::escape($list->getCaption()); ?>
                    </strong>
                </td>
                <td>
                    <?php
                    $name = DataManager::getUserById($list->getUserId());
                    echo Util::escape(is_null($name) ? "" : $name->getUserName());
                    ?>
                </td>
                <td>
                    <?php
                    $entrepreneurUserId = $list->getEntrepreneurUserId();
                    $name = DataManager::getUserById(is_null($entrepreneurUserId) ? -1 : $entrepreneurUserId);
                    echo Util::escape(is_null($name) ? "" : $name->getUserName());
                    ?>
                </td>
                <td>
                    <?php echo Util::escape($list->getDueDateTime()); ?>
                </td>
                <td>
                    <?php echo Util::escape(is_null($list->getPricePaid()) ? "" : $list->getPricePaid()); ?>

                </td>
                <td class="add-remove">
                    <form method="post" action="<?php echo Util::action(
                                                    Webshop\Controller::ACTION_SHOW_ARTICLES,
                                                    array(Webshop\Controller::SHOPPING_LIST_ID => $list->getId())
                                                ); ?>">
                        <button type="submit" role="button" class="btn btn-default btn-xs btn-success">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </button>
                    </form>
                </td>

                <?php if ($user->isTypeOf(UserType::NEEDSHELP) && is_null($list->getEntrepreneurUserId())) { ?>
                    <td class="add-remove">
                        <form method="post" action="<?php echo Util::action(
                                                        Webshop\Controller::ACTION_REMOVE_LIST,
                                                        array(Webshop\Controller::SHOPPING_LIST_ID => $list->getId())
                                                    ); ?>">
                            <button type="submit" role="button" class="btn btn-default btn-xs btn-danger">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                        </form>
                    </td>
                <?php } ?>
                <?php if ($user->isTypeOf(UserType::ENTREPRENEUR) && is_null($list->getEntrepreneurUserId())) { ?>
                    <td class="add-remove">
                        <form method="post" action="<?php echo Util::action(
                                                        Webshop\Controller::ACTION_TAKE_OVER_LIST,
                                                        array(Webshop\Controller::SHOPPING_LIST_ID => $list->getId())
                                                    ); ?>">
                            <button type="submit" role="button" class="btn btn-default btn-xs btn-primary">
                                <span class="glyphicon glyphicon-export"></span>
                            </button>
                        </form>
                    </td>
                <?php } ?>
                <?php if ($user->isTypeOf(UserType::ENTREPRENEUR) && is_null($list->getEntrepreneurUserId()) == false && $list->getClosed() == false) { ?>
                    <div class="modal fade" id="modalLoginForm<?php echo Util::escape($list->getId()) ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm" role="document">
                            <div class="modal-content">
                                <form class="form-horizontal" method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_CLOSE_SHOPPING_LIST, array('view' => $view)); ?>">
                                    <div class="modal-header text-center">
                                        <h4 class="modal-title w-100 font-weight-bold">Bitte bezahlten Preis eingeben</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" hidden name="<?php echo Webshop\Controller::SHOPPING_LIST_ID; ?>" value="<?php echo $list->getId() ?>" />
                                        <input type="number" step="0.01" required value="0" id="inputDueDatetime" name="<?php print Webshop\Controller::ARTICLE_MAX_PRICE; ?>" placeholder="Preis">
                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-6">
                                                <button type="submit" class="btn btn-default">Hinzufügen</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <td>
                        <button data-toggle="modal" data-target="#modalLoginForm<?php echo Util::escape($list->getId()) ?>" class="btn btn-default btn-xs btn-primary">
                            <span class="glyphicon glyphicon-export"></span>
                        </button>
                    </td>
                <?php } ?>

            </tr>
        <?php endforeach; ?>



    </tbody>
</table>