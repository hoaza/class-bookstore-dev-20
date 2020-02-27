<?php 

use Data\DataManager;
$categories = DataManager::getCategories();

print_r($categories);
die();

require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>List</h2>
</div>





<?php require_once('views/partials/footer.php'); ?>

