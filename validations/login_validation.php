<code>
<?php
session_start();

spl_autoload_register(function ($class) {
    include "../classes/entities/$class.inc.php";
});

function connectWithDataBase() {
    $SERVER_NAME = "localhost";
    $USER_NAME = "root";
    $PASSWORD = "";
    $DATABASE_NAME = "dbwebshop";
    return new mysqli($SERVER_NAME, $USER_NAME, $PASSWORD, $DATABASE_NAME);
}

$conn = connectWithDataBase();

// check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// ----------------------------------------------------------------------

$email = trim($_POST['email'], "<");
$email = stripslashes($email);
$email = htmlspecialchars($email);
$email = mysqli_real_escape_string($conn, $email);
echo 'Without trimming email:<br />'. '<b>'. $email .'</b>'.'<br />';

$password = trim($_POST['password']);
echo 'Without trimming password: <br />' . $password .'<br /><br />';

$sql = "SELECT user_email, user_password FROM dbusers WHERE user_email = '$email'";
echo "query used:<br /><br /> <b>$sql</b>".'<br /><br />';

echo 'Result: <br /><br />';
$res = $conn->query($sql);
if ($res != null) {
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            // if (password_verify($_POST['password'], $row['user_password'])) {
                echo $row['user_email'].'<br />';
            // }
        }
    }
} else {
    echo 'Result seems to be null for some reason. Perhaps there is an error!<br /><br />';
    print_r($conn->error_list[0]['error']);
}

$conn->close();






// $query = "SELECT user_id, user_email, user_password, user_type ";
// $query.= "FROM dbusers ";
// $query.= "WHERE user_email = '$email';";
// $conn = connectWithDataBase();
// $res = $conn->query($query);

// $conn->close();






// $email = trim($_POST['email']);
// echo 'With trimming email:<br />' . $email .'<br />';

// $password = trim($_POST['password']);
// echo 'With trimming password: <br />' . $password .'<br />';



// $email = stripslashes($email);
// $email = htmlspecialchars($email);



// $password = stripslashes($password);
// $password = htmlspecialchars($password);

// if (isset($_POST['btn_signUp'])) {
//     // TODO: Fix the sign up method
//     User::signUp($email, $password, true);
// } else if (isset($_POST['btn_login'])) {
//     $user = User::login($email, $password);
//     if (!is_null($user)) {
//         echo $user->user_email;
//         if ($user->user_type != "admin") {
//             $shoppingCart = new ShoppingCart($user->user_id);
//             $shoppingCartCount = $shoppingCart->getCartLinesCount();
//             if ($shoppingCartCount != 0) {
//             $_SESSION['cart'] = $shoppingCartCount;
//             }
//         }
//         $_SESSION['user_info'] = serialize($user);
//     }
// }


// header("Location: ../index.php");
?>
</code>

<?php /*phpinfo();*/ ?>