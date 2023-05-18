<?php 
session_start();

spl_autoload_register(function($class) {
    $sources = array(
        "classes/entities/$class.inc.php", 
        "classes/renderers/$class.inc.php",
        "classes/renderers/base/$class.inc.php"
    );
    foreach ($sources as $source) { if (file_exists($source)) { require_once $source; } }
});

$isAdmin = false;
if (isset($_SESSION['user_info'])) {
    $user = unserialize($_SESSION['user_info']);
    if ($user->user_type == "admin") $isAdmin = true;
}
?>
<!DOCTYPE html>
<html>
<?php include "includes/head.html" ?>
<body>
    <div>
        <?php include("includes/header.php"); ?>
    </div>
    
    <div class="container pt-5 d-flex justify-content-center">
        <!-- <form id=loginForm action="validations/login_validation.php" method="POST"> -->
        <form id=loginForm action="validations/login_validation.php" method="POST">
            <input type='text' name='email' placeholder="email" size='50' class='form-control form-control-lg input-lg' /><br />
            <input type='password' name='password' placeholder="password" size='50' class='form-control form-control-lg input-lg' />
            <hr />
            <button type='submit' name='btn_login' class='btn btn-info btn-block btn-lg'>Submit</button>
        </form>
    </div>

    <!-- <div class="container pt-5 d-flex justify-content-center">
    <form id=loginForm action="validations/login_validation.php" method="POST">
        <input 
            type='text' 
            name='email' 
            placeholder="email" 
            size='50' 
            class='form-control form-control-lg input-lg'
            value=<?php echo "'"."email"."'"; ?>
        /><br />
        <input type='password' name='password' placeholder="password" size='50' class='form-control form-control-lg input-lg' value='fuck' />
        <hr />
        <button type='submit' name='btn_login' class='btn btn-info btn-block btn-lg'>Submit</button>
    </form>
    </div> -->


    <?php include("includes/footer.html"); ?>
</body>
</html>