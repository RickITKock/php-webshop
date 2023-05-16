<?php

session_start();

spl_autoload_register(function($class) {
    $sources = array(
        "../classes/entities/$class.inc.php", 
        "../classes/renderers/$class.inc.php",
        "../classes/renderers/base/$class.inc.php"
    );
    foreach ($sources as $source) { if (file_exists($source)) { require_once $source; } }
});

$q = $_GET['q'];
$itemCardRenderer = new ItemCardRenderer();
$itemModalRenderer = new OptionsModalRenderer();

$isAdmin = false;
if (isset($_SESSION['user_info'])) {
    $user = unserialize($_SESSION['user_info']);
    if ($user->user_type == "admin") $isAdmin = true;
}

if ($q == "") {
     $items = Item::getItems();
} else {
    $items = Item::findItems($q);
}

if ($items == NULL) {
    echo "No results found.";
}
else {
    if ($isAdmin) {
        foreach($items as $item) {
            echo '<div class="col-lg-12">';
            $itemCardRenderer->renderForAdmin($item);
            echo '</div>';
            $itemModalRenderer->renderItemInfoModal("info", $item);
        }
    } else {
        echo '<div class="row">';
        foreach($items as $item) {
            echo '<div class="col-lg-4">';
            $itemCardRenderer->renderForUser($item);
            echo '</div>';
            $itemModalRenderer->renderItemInfoModal("info", $item);
        }
        echo '</div>';
    }
}

?>