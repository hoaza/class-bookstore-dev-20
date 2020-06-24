<?php 
    require_once('views/partials/header.php');
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
    foreach ($shoppingLists as $list):
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


            
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
