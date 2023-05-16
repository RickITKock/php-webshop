<?php

$servername = "localhost";
$username = "root";
$password = "";
$db = "dbwebshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>

<?php echo $_POST['email'] ?>
<br/>
<?php echo $_POST['firstPasswordInput'] ?>
<br/>
Encrypted password: <?php echo crypt($_POST['firstPasswordInput'], 'st') ?>

<?php
$email = "'" . $_POST['email'] . "'";
$password = "'" . crypt($_POST['firstPasswordInput'], 'st') . "'";
$type = "'user'";
$sql = "INSERT INTO dbusers (user_email, user_password, user_type) VALUES ($email, $password, $type);";


// VALUES (".$_POST['email'].",".$encryptedPassword.");";

if ($conn->query($sql) === true) {
    echo "New record created successfully";
    $conn->close();
    header("Location: ../index.php");
} else {
    $conn->close();
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>