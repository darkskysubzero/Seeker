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
    <a href="#" class="cartBtn">
    <img src="css/cart.png"/>
    <p>'.$itemsInCart.'</p>
    </a>';

?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <title>Signup | Seeker</title>
    <link rel="icon" type="image/x-icon" href="css/s.png">
    <link rel="stylesheet" href="css/navigation.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/signup.css?v=<?php echo time(); ?>"/>

    <script src="app/signup.js"></script>

</head>
<body>


    <!-- Responsive navigation -->
    <nav>
        <div class="container">
        <h1 class="logo"><a href="index.php">Seeker</a></h1>
            <div class="menu">
                <a href="index.php" >Home</a>
                <a href="login.php">Login</a>
                <a href="signup.php"  class="is-active">Sign up</a>
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
        <a href="login.php">Login</a>
        <a href="signup.php"  class="is-active">Sign up</a>
        <?=$cartButton?>
    </nav>

    <div class="centerer"> 
        <!-- signup form -->
        <div class="signupForm">
        <h1>Signup</h1>
        <form method="post" action="handler.php" id="formValidation" onsubmit="return checkform(this);" autocomplete="off" >
            <div class="field">
                <label>Name</label>
                <input type="text" id="name" name="name"/>
                <p id="ername" class="error"></p>
            </div>
            <div class="field">  
                <label>Surname</label>
                <input type="text" id="surname" name="surname"/> 
                <p id="ersurname" class="error"></p>
            </div> 
            <div class="field">  
                <label>Email</label>
                <input type="email" id="email" name="email"/> 
                <p id="eremail" class="error"></p>
            </div> 
            <div class="rfield">  
                <label>Gender</label>
                Female<input type="radio" name="gender"  value="F"/> 
                Male<input type="radio" name="gender" value="M"/>
                <p id="ergender" class="error"></p> 
            </div> 
            <div class="field">  
                <label>Age</label>
                <input type="number" id="age" name="age" min="10" max="99"> 
                <p id="erage" class="error"></p>
            </div> 
            <div class="field">  
                <label>Phone</label>
                <input type="number" name="phone" id="phone"/> 
                <p id="ernumber" class="error"></p>
            </div>
            <div class="field">  
                <label>Password</label>
                <input type="password" name="password" id="password"/> 
                <p id="erpassword" class="error"></p>
            </div> 

            <input type="submit" value="Sign up" name="signupbtn"/>
        </form>
    </div>
    
    <div class="footer-container-signup">
        <footer>
            <p><a href="contact.php">Contact us</a></p>
            <p><a href="aboutus.php">About us</a></p>  
            <p class="cr"><a href="index.php">Seeker &copy;</a> </p>
        </footer>
    </div>
    
     

    <script src="app/script.js"></script>
    <script src="app/signup_focus.js"></script>
    <?php
         if(isset($_GET["error"]) && $_GET["error"]==1){
            echo '<script>';
            echo 'alert("User already exists!");';
            echo 'window.location.href="signup.php"';
            echo'</script>';
        }
    ?>

</body>
</html>