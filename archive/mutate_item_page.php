<?php 
session_start();

spl_autoload_register(function($class) {
    $sources = array(
        "classes/entities/$class.inc.php", 
        "classes/renderers/$class.inc.php",
        "classes/renderers/base/$class.inc.php",
    );
    foreach ($sources as $source) { if (file_exists($source)) { require_once $source; } }
});

$buttonRenderer = new ButtonRenderer();
$item_id = (!isset($_POST['id'])) ? null : $_POST['id'];
$btn_pressed = (!isset($_POST['btn_pressed'])) ? null : $_POST['btn_pressed'];

$name = null;
$description = null;
$isSale = null;
$stock = null;
$price = null;
$categoryId = null;

if (!is_null($item_id)) {
    $item = Item::getItemById($item_id);
    $name = $item->name;
    $description = $item->description;
    $isSale = $item->is_sale;
    $stock = $item->stock;
    $price = $item->price;
    $categoryId = $item->category_id;
} else {
    $categoryId = Category::findCategoryByCategory("Uncategorized")->id;
}

?>
<!DOCTYPE html>
<html>
<?php include "includes/head.html" ?>
<body>
    <div>
        <?php include("includes/header.php"); ?>
    </div>
    <div class="container">
        <div class="row" style="padding-top: 20px;">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form id="mutateItemForm" name="mutateItemForm" action="validations/process_resource.php" method="POST">
                    <input name="id" type="number" value="<?php echo $item->id; ?>" hidden />
                    <div class="form-group row">
                        <label for="staticEmail" class="col-lg-2 col-form-label">Item name</label>
                        <div class="col-lg-10">
                            <input class="form-control" value="<?php echo $name; ?>" type="text" placeholder="New item" name="name"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-lg-2 col-form-label">Category</label>
                        <div class="col-lg-10">
                            <select class="form-control" name="category_id" id="category_id">
                                <?php
                                    $categories = Category::getCategories();
                                    foreach($categories as $category) {
                                        if ($category->id == $categoryId) {
                                            echo '<option selected value ="'.$category->id.'">'.$category->category.'</option>';
                                            continue;
                                        }
                                        echo '<option value ="'.$category->id.'">'.$category->category.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-lg-2 col-form-label">Description</label>
                        <div class="col-lg-10">
                            <textarea class="form-control" rows="3" name="description"><?php echo $description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-lg-2 col-form-label">Sale</label>
                        <div class="col-lg-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value=<?php echo $isSale; ?> <?php echo ($isSale)? "checked" : ""; ?> name="is_sale"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-lg-2 col-form-label">Stock</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" placeholder="Stock" name="stock" value="<?php echo $stock; ?>"/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="staticEmail" class="col-lg-2 col-form-label">Price</label>
                        <div class="col-lg-10">
                            <input type="number" class="form-control" placeholder="Price" name="price" step=".01" value="<?php echo $price; ?>"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="btn-group float-right">
                    <a href="index.php" class="btn btn-light border active" aria-pressed="true" style="background-color: white;" role="button">Back</a>
                    <?php
                    if (is_null($item_id)) {
                        $buttonRenderer->renderButton(
                            array(
                                'name' => "btn_create",
                                'type' => "submit",
                                'class' => "btn border",
                                'style' => "background-color: white;",
                                'form' => "mutateItemForm",
                            ), function() { echo "Create";}
                        );
                    } else {
                        $buttonRenderer->renderButton(
                            array(
                                'name' => "btn_update",
                                'type' => "submit",
                                'class' => "btn border",
                                'style' => "background-color: white;",
                                'form' => "mutateItemForm",
                            ), function() { echo "Update";}
                        );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php include("includes/footer.html"); ?>
</body>
</html>