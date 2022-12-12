<?php

    session_start();
    if(isset($_SESSION["userLoggedIn"])){
        header("location:index.php");
    }
    if(isset($_SESSION["adminLoggedIn"])){
        header("location:admin.php");
    }


    $itemsInCart = 0;
    if(!empty($_SESSION["cart"])){
        $itemsInCart =count($_SESSION["cart"]); 
    }
    
    $cartButton = '
    <a href="handler.php" class="cartBtn">
    <img src="css/cart.png"/>
    <p>'.$itemsInCart.'</p>
    </a>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | Seeker</title>
    <link rel="icon" type="image/x-icon" href="css/s.png">
    <link rel="stylesheet" href="css/navigation.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/login.css?v=<?php echo time(); ?>"/>
    
    <script src="app/login.js"></script>
</head>
<body>

    <!-- Responsive navigation -->
    <nav>
        <div class="container">
        <h1 class="logo"><a href="index.php">Seeker</a></h1>
            <div class="menu">
                <a href="index.php" >Home</a>
                <a href="login.php" class="is-active">Login</a>
                <a href="signup.php">Sign up</a>
                <?=$cartButton?>
            </div>
            <button class="hamburger">
                <span></span>
                <span></span>
                <span></span>        
            </button>
        </div>
    </nav>
    <nav class="mobile-nav">
        <a href="index.php" >Home</a>
        <a href="login.php" class="is-active">Login</a>
        <a href="signup.php">Sign Up</a>
        <?=$cartButton?>
    </nav>

     
    <!-- Login form = -->
    <div class="loginForm">
        <h1>Login</h1>
        <form method="post" action="handler.php" id="formValidation" onsubmit="return checkform(this)" >
            <div class="field">
                <label>Email</label>
                <input type="email" autocomplete="off"  name="email" value="bruce@wayne.com"/>
            </div>
            <div class="field">  
                <label>Password</label>
                <input type="password" autocomplete="off"  name="password" value="00000" /> 
            </div>
            <div class="forgot">Forgot Password?</div>
            <input type="submit" value="Login" name="loginbtn"/>
        </form>
    </div>


    <div class="footer-container-login">
        <footer>
            <p><a href="contact.php">Contact us</a></p>
            <p><a href="aboutus.php">About us</a></p>  
            <p class="cr"><a href="index.php">Seeker &copy;</a> </p>
        </footer>
    </div>
     
    <script src="app/script.js"></script>
    <?php
         if(isset($_GET["error"]) && $_GET["error"]==1){
            echo '<script>';
            echo 'alert("Invalid admin login!");';
            echo 'window.location.href="login.php"';
            echo'</script>';
        }else if(isset($_GET["error"]) && $_GET["error"]==2){
            echo '<script>';
            echo 'alert("Invalid user login!");';
            echo 'window.location.href="login.php"';
            echo'</script>';
        }
    ?>
</body>
</html>