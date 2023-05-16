<?php

// This page is supposed to be used after mutating an item

spl_autoload_register(function($class) {
    include "../classes/entities/$class.inc.php";
});

$item_id = (!isset($_POST['id'])) ? null : $_POST['id'];
$name = (!isset($_POST['name'])) ? null : $_POST['name'];
$description = (!isset($_POST['description'])) ? null : $_POST['description'];
$isSale = (isset($_POST['is_sale']))? 1 : 0;
$stock = (!isset($_POST['stock'])) ? null : $_POST['stock'];
$price = (!isset($_POST['price'])) ? null : $_POST['price'];
$categoryId = (!isset($_POST['category_id'])) ? null : $_POST['category'];


if (is_null($item_id)) {
    echo "Item is null";
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


// if (isset($_POST['is_sale'])) {
//     $isSale = 1;
// } else {
//     $isSale = 0;
// }

// Item::createNewItem(
//     $_POST['item'], 
//     $_POST['description'], 
//     $isSale, 
//     $_POST['stock'], 
//     $_POST['price'],
//     $_POST['category_id']
// );

// header("Location: ../mutate_item_page.php");
?>