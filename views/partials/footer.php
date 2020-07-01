<!--display messages-->

<?php

use Webshop\Util;

if (isset($errors) && is_array($errors)): ?>
    <div class="errors alert alert-danger">
      <ul>
        <?php foreach ($errors as $errMsg): ?>
          <li><?php echo(Util::escape($errMsg)); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
<?php endif; 

if (isset($successMessages) && is_array($successMessages)): ?>
    <div class="alert alert-success">
      <ul>
        <?php foreach ($successMessages as $errMsg): ?>
          <li><?php echo(Util::escape($errMsg)); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
<?php endif; ?>

<!--/display messages-->

    <div class="footer">

        <hr />
  
     </div>
        <div class="col-sm-4 pull-right">
            <p><?php echo Util::escape(strftime('%c')); ?></p>
            </div>
    </div>
</div>

  <script src="assets/jquery-1.11.2.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assets/main.css">

  </body>
</html>