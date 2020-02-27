<?php 

use Data\DataManager;
$categories = DataManager::getCategories();


require_once('views/partials/header.php'); ?>
<div class="page-header">
    <h2>List</h2>
</div>

<ul class="nav nav-tabs">
    <?php foreach ($categories as $cat) { ?>
        <li role="presentation">
            <a href="#"><?php echo $cat->getName(); ?></a>
        </li>
    <?php } ?>    
</ul>


<?php require_once('views/partials/footer.php'); ?>

