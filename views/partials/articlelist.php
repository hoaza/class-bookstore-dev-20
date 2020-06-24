<?php

use Webshop\Util; ?>

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
            <th>
                <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>
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
                <td class="add-remove">

                    <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_REMOVE, array('articleId' => $article->getId())); ?>">
                        <button type="submit" role="button" class="btn btn-default btn-xs btn-info">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>
                    </form>


                    <!-- <form method="post" action="<?php echo Util::action(Webshop\Controller::ACTION_ADD, array('articleId' => $article->getId())); ?>">
                            <button type="submit" role="button" class="btn btn-default btn-xs btn-success">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </form> -->

                    <!-- </td> -->
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>