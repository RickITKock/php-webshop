<?php

session_start();

spl_autoload_register(function($class) {
    include "../classes/entities/$class.inc.php";
});

$item_id = (!isset($_POST['id'])) ? null : $_POST['id'];

if (isset($_POST['btn_delete'])) {
    Item::deleteItem($item_id);
} else {
    echo "No btn delete set";
}

$name = (!isset($_POST['name'])) ? null : $_POST['name'];
$description = (!isset($_POST['description'])) ? null : $_POST['description'];
$isSale = (isset($_POST['is_sale']))? 1 : 0;
$stock = (!isset($_POST['stock'])) ? null : $_POST['stock'];
$price = (!isset($_POST['price'])) ? null : $_POST['price'];
$categoryId = (!isset($_POST['category_id'])) ? null : $_POST['category_id'];

if (is_null($item_id)) {
    echo "Item is null";
    Item::createNewItem($name, $description, $isSale, $stock, $price, $categoryId);
} else {
    echo $item_id."<br />";
    echo $name."<br />";
    echo $description."<br />";
    echo $isSale."<br />";
    echo $stock."<br />";
    echo $price."<br />";
    echo $categoryId."<br />";
    // echo Item::updateItem($item_id, $name, $description, $isSale, $stock, $price, $categoryId);
}

if (isset($_POST['btn_update'])) {
    Item::updateItem($item_id, $name, $description, $isSale, $stock, $price, $categoryId);
}

if (isset($_POST['btn_create'])) {
    echo "Creating new item";

    echo $categoryId;
    $itemIsCreated = Item::createNewItem($name, $description, $isSale, $stock, $price, $categoryId);
    if (is_null($itemIsCreated)) {
        echo "An error occurred or something";
    } else {
        echo $itemIsCreated;
    }
}

// Pressed "Add to cart" button
if (isset($_POST['btn_add_to_cart'])) {
    if (isset($_SESSION['user_info'])) {
        $user = unserialize($_SESSION['user_info']);
        if ($user->user_type != "admin") {
            $user_id = $user->user_id;
            $shoppingCart = new ShoppingCart($user_id);
            $shoppingCart->addToCart($item_id);
            if (isset($_SESSION['cart'])) {
                $_SESSION['cart'] = $shoppingCart->getCartLinesCount();
            }
        }
    }
}

header("Location: ../index.php");

?>