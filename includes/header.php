<header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: rgba(0,0,0, 0.5);">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="index.php">Rick's webshop</a>
                <?php include "includes/searchform.html"; ?>
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                    <?php if (!isset($_SESSION['user_info'])) {  ?>

                        <li class="nav-item">
                            <a class="nav-link" href="#" data-toggle="modal" data-target='#signUpModal'>Signup</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    
                    <?php 
                    } else {
                        $user = unserialize($_SESSION['user_info']);

                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="#">'.$user->user_email.'</a>';
                        echo '</li>';
                        echo '<li class="nav-item">';
                        echo '<a class="nav-link" href="logout.php">Logout</a>';
                        echo '</li>';
                    }
                    ?>

                    <!-- TODO: Check of the user is an admin. If not, remove the cart link -->
                    <?php if (isset($_SESSION['user_info'])) {
                        $user = unserialize($_SESSION['user_info']);
                        if ($user->user_type != "admin") {
                        ?>
                        <li class="nav-item">
                            <?php if (isset($_SESSION['cart'])) { ?>
                                <a class="nav-link" href="shopping_cart.php"><?php echo $_SESSION['cart'] ?> Cart</a> <!-- TODO: Update and check for amount -->
                            <?php } ?>
                        </li>
                    <?php
                        }
                    } 
                    ?>

                </ul>
            </div>
        </div>
    </nav>
    <?php
    $modal = new OptionsModalRenderer(); 
    $modal->renderLoginModal("loginModal");
    $modal->renderSignUpModal("signUpModal");
    ?>
</header>