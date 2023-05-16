<?php
session_start();

include("../classes/Item.inc.php");
include("../classes/Category.inc.php");
include("../classes/CartLine.inc.php");
include("../classes/ShoppingCart.inc.php");

$id = $_POST['id'];
if (isset($_POST['delete_button'])) {
    $result = Item::removeItem($id);
    echo $result;
    header("Location: ../index.php");


//////////////////////////////////////////////////////////////
// TODO: Currently busy with
} else if (isset($_POST['add_to_cart_button'])) {
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        $servername = "localhost";
        $username = "root";
        $password = "";
        $db = "dbwebshop";
        $conn = new mysqli($servername, $username, $password, $db);
        $query = "SELECT * FROM dbusers WHERE user_email = '$email'";
        $result = $conn->query($query);
    
        if ($result) {
            $user = mysqli_fetch_object($result);
            $conn->close();
        } else {
            $conn->close();
            header("Location: index.php");
        }

        $user_id = $user->user_id;
        $shoppingCart = new ShoppingCart($user_id);


        // TODO: Change id to item_id
        $shoppingCart->addToCart($id);

        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = $shoppingCart->getCartLinesCount();
        }
    }
    header("Location: ../index.php");

} else if (isset($_POST['info_button'])) {
    $item = Item::getItemById($id);
    echo $item->name;
} else if (isset($_POST['update_button'])) {
    $item = Item::getItemById($id);?>

    <!-- TODO: Have the validation form to interpret if there is an id -->
    <!-- TODO: Create a hidden field in the form and in the validation, check if id is set. -->
    <form method="POST" id="createItemForm" action="validations/item_form_validation.php">
        <div class="form-group">
            <?php echo '<input class="form-control" type="text" placeholder="New item" name="item" value="'.$item->name.'">';?>
        </div>
        <div class="form-group">
            <select class="form-control" name="category_id">
                <?php
                    $categories = Category::getCategories();
                    foreach($categories as $category) {
                        echo $category->id."<br />";
                        echo $item->category_id."<br />";
                        if ($category->id == $item->category_id) {
                            echo '<option value ='.$category->id.'" selected>'.$category->category.'</option>';
                        } else {
                            echo '<option value ='.$category->id.'">'.$category->category.'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <div class="form-group">
            <textarea class="form-control" rows="3" name="description"><?php echo $item->description; ?></textarea>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value=1 name="is_sale" <?php if ($item->is_sale) { echo 'checked'; }; ?>>
                <label class="form-check-label">
                    Sale
                </label>
            </div>
        </div>
        <div class="form-group">
            <input type="number" class="form-control" placeholder="Stock" name="stock" value=<?php echo $item->stock; ?>>
        </div>
        <div class="form-group">
            <input type="number" class="form-control" placeholder="Price" name="price" value=<?php echo $item->price; ?>>
        </div>
    </form>

<?php
}
?>