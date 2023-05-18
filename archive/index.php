<?php 
// session_start();

// spl_autoload_register(function($class) {
//     $sources = array(
//         "classes/entities/$class.inc.php", 
//         "classes/renderers/$class.inc.php",
//         "classes/renderers/base/$class.inc.php"
//     );
//     foreach ($sources as $source) { if (file_exists($source)) { require_once $source; } }
// });

// $isAdmin = false;
// if (isset($_SESSION['user_info'])) {
//     $user = unserialize($_SESSION['user_info']);
//     if ($user->user_type == "admin") $isAdmin = true;
// }
?>
<!DOCTYPE html>
<html>
<?php include "includes/head.html" ?>
<body>
    <div>
        <?php include("includes/header.php"); ?>
    </div>
    <div class="container-fluid">
        <div class="row" style="padding-top: 20px;">
            <div class="col-lg-3 col-md-5 col-sm-8">
                <?php // include "includes/category_menu.php" ?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class='row' style='height: 500px; overflow: auto;'>
                    <div id="items" class="container-fluid">
                        <div class="row">
                            <?php
                                include "includes/items.php";
                            ?>
                        </div>
                    </div>
                </div>
                <?php 
                    // if ($isAdmin) {
                    //     echo "<div class='row mt-3'>";
                    //     echo '<div class="col-lg-12">';
                    //     $linkRenderer->renderLink(
                    //         array(
                    //             'href' => "mutate_item_page.php",
                    //             'class' => "btn btn-light border active float-right",
                    //             'style' => "background-color: white;",
                    //             'role' => "button",
                    //             'form' => "mutateItemForm",
                    //         ), function() { echo "Create new item";}
                    //     );
                    //     echo '</div>';
                    //     echo "</div>";
                    // }
                ?>
                <!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    This website only uses cookies for login purposes.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
            </div>
        </div>
    </div>
    <?php include("includes/footer.html"); ?>
</body>
</html>