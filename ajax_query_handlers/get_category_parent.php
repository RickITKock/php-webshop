<?php
$q = $_GET['q'];

// echo $q;

spl_autoload_register(function($class) {
    include "../classes/entities/$class.inc.php";
});

$parent = Category::getCategoryParent($q);

if ($parent == null) {
    echo "No parent";
    // echo $parent;
} else {
    // Change the following
    echo $parent;
}

?>