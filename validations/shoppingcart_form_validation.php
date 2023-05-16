<?php
session_start();

spl_autoload_register(function($class) { include "../classes/entities/$class.inc.php"; });
$item_id = (!isset($_POST['id'])) ? null : $_POST['id'];
if (!is_null($item_id)) {
    $user = unserialize($_SESSION['user_info']);
    $user_id = $user->user_id;
    $shoppingCart = new ShoppingCart($user_id);
    if (isset($_POST['remove_cart'])) {
        $shoppingCart->removeCartLine($item_id);
    } else if (isset($_POST['update_cart'])) {
        $amount = $_POST['amount'];
        if ($amount != 0) {
            $result = $shoppingCart->updateCart($item_id, $amount);
        }
    }
    $_SESSION['cart'] = $shoppingCart->getCartLinesCount();
    header("Location: ../shopping_cart.php");
} else {
    echo "No id <br />";
}
?>