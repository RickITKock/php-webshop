<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<?php include "includes/head.html";
spl_autoload_register(function($class) {
  $sources = array(
      "classes/entities/$class.inc.php", 
      "classes/renderers/$class.inc.php",
      "classes/renderers/base/$class.inc.php",
  );
  foreach ($sources as $source) { if (file_exists($source)) { require_once $source; } }
});
?>
<body>
    <?php include("includes/header.php");?>
    <br />
    <div class="container">
        <?php
        $isCustomer = false;
        if (isset($_SESSION['user_info'])) {
          $user = unserialize($_SESSION['user_info']);
          if ($user->user_type != "admin") {
            $isCustomer = true;
            $user_id = $user->user_id;
            $shoppingCart = new ShoppingCart($user_id);
            $shoppingCartCount = $shoppingCart->getCartLinesCount($user_id);
          }          
        }

        if ($isCustomer == false) {
          echo '<div class="alert alert-light border" role="alert">Oops! Wrong page.</div>';
          include("includes/footer.html");
          return;
        }
        ?>

        <div class='card'>
          <div class='card-body'>
            <?php
            $shoppingCartRenderer = new ShoppingCartRenderer();
            $items = Item::getItems();
            $cartlines = $shoppingCart->cartlines;
            $shoppingCartRenderer->renderShoppingCart($cartlines);
            ?>
          </div>
        </div>
    </div>
    <?php include("includes/footer.html");?>
</body>
</html>