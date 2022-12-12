<?php

    session_start();
    include_once "database.php";
    global $conn;
    $conn = $connection;

     //getting total items in cart
     $itemsInCart = 0;
     if(!empty($_SESSION["cart"])){
         $itemsInCart =count($_SESSION["cart"]); 
     }

     $logoutButton = "";
     $profileButton = "";
     $cartButton = '
     <a href="#" class="cartBtn">
     <img src="css/cart.png"/>
     <p>'.$itemsInCart.'</p>
     </a>';

     //if user is logged in 
     if(isset($_SESSION["userLoggedIn"])){
        //getting username from db
        $un = $_SESSION["userName"];
        $logoutButton = "<a href='handler.php?logout=true'>Logout</a>"; 
        $profileButton = "<a href='handler.php'>Hi ".$un." / Profile </a>";
        $signUpButton = ""; 
     }
     
     else{
        header("location:login.php");
     }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout | Seeker</title>
    <link rel="icon" type="image/x-icon" href="css/s.png">
    <link rel="stylesheet" href="css/navigation.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/cart.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/checkout.css?v=<?php echo time(); ?>"/>
      
    <script src="app/payment.js"></script>
</head>
<body>


 <!-- Responsive navigation -->
 <nav>
        <div class="container">
            <h1 class="logo"><a href="index.php">Seeker</a></h1>
            <div class="menu">
                <a href="index.php">Home</a>
                <?=$profileButton?>
                <?=$logoutButton?>
                <?=$cartButton?>
                
                <!-- <?=$contactButton?> -->
            </div>
            <button class="hamburger">
                <span></span>
                <span></span>
                <span></span>        
            </button>
        </div>
    </nav>


    <nav class="mobile-nav">
        <a href="index.php">Home</a>
        <?=$profileButton?>
        <?=$logoutButton?>
        <?=$cartButton?>
    </nav>
    
    <!-- cart  -->
    <div class="cartWindowContainer hideCart">
    <h1 class="cartTitle">My Cart</h1>
        <div class="holder">
            <div class="itemsContainer">
                <!-- an item -->
                <?php
                if(!empty($_SESSION["cart"])){
                    $cartItems = $_SESSION["cart"];
                    foreach($cartItems as $itemID => $itemQuantity){
                        echo '<div class="item">';
                        echo '<div class="item-price">R'.getPriceFromID($conn,$itemID).'</div>';
                        echo '<div class="item-name">'.getTitleFromID($conn,$itemID).'</div>';
                        echo '<div class="item-image"><img src="'.getProductImageFromID($conn,$itemID).'" alt=""></div>';
                        echo '<div class="item-description">'.getDescriptionFromID($conn,$itemID).'</div> ';
                        echo '<div class="item-count">'.$itemQuantity.'</div>';
                        echo '<div class="item-quantity">';
                        echo '<form method="get" action="index.php">';
                        echo '<input type="number" value="1" min="0" max="100" name="quantity">';
                        echo '<input type="hidden" name="pid" value="'.$itemID.'"/>';
                        echo '<input type="submit" value="Add" name="updateQuantity">';
                        echo '<a href="index.php?del='.$itemID.'&page=checkout">Delete</a>';
                        echo '</form>';
                        echo '</div> ';
                        echo '<div class="item-total">Total [ R'.$_SESSION["totals"][$itemID].' ]</div>';
                        echo '</div>';
                    }
                }
                ?>

                <div class="all-total">
                    <div class="total-text">Total</div>
                    <div class="total-money">R<?php
                        //calulating all totals
                        $allTotals = 0;
                        if(!empty($_SESSION["totals"])){
                            foreach($_SESSION["totals"] as $item => $total){
                                $allTotals +=$total;
                            }
                        }
                        echo $allTotals;

                    ?></div>
                </div>
            </div>
        </div> 
        <div class="buttons">
            <a href="handler.php?checkout=true" class="cBtn"><img src="css/checkout.png">Check out</a>
            <a href="index.php?clear=all" class="cBtn" id="reset"><img src="css/reset.png">Clear cart</a>
            <a href="index.php" class="cBtn" id="continue"><img src="css/continue.png">Continue shopping</a>
            </div> 
    </div>
     

    <!-- check out form -->
    <div class="checkout-container">
        <div class="wrapper">
        <form method="post" action="handler.php" onsubmit="return checkform(this);" autocomplete="off">
            <h1>Enter your details</h1>
            <div class="box">
            <div class="card-details">
                <h3>Card details</h3>
                <p>Name on card:</p>
                <input type="text" name="noc" placeholder="Bruce Wayne" value="Bruce Wayne" required/>
                <p>Card number:</p>
                <input type="number" name="cn" placeholder="0000000000000" value="0000000000000" required maxlength="13"/>
                <p>CVC number:</p>
                <input type="number" name="cvc" placeholder="343" value="343" required maxlength="4"/>
                <p>Expiry month:</p>
                <input type="number" name="em" placeholder="04" value="04"required maxlength="2"/>
                <p>Expiry year:</p>
                <input type="number" name="ey" placeholder="24" value="24" required maxlength="2"/>
            </div>
            <div class="delivery-details">
            <h3>Delivery address</h3>
                <p>Province:</p>
                <input type="text" name="province" placeholder="Eastern Cape" value="Eastern Cape" required/>
                <p>City:</p>
                <input type="text" name="city" placeholder="East London" value="East London" required/>
                <p>Address:</p>
                <input type="text" name="address" placeholder="Forest Street, 2B" value="Forest Street, 2B" required/>
                <p>Postal code:</p>
                <input type="text" name="postal" placeholder="5209" value="5209" required/>
            </div>
            </div>
            <input type="submit" value="Make payment" name="paymentBtn"/>
        </form>
        </div>

    </div>



    <div class="footer-container-checkout">
        <footer>
            <p><a href="contact.php">Contact us</a></p>
            <p><a href="aboutus.php">About us</a></p>  
            <p class="cr"><a href="index.php">Seeker &copy;</a> </p>
        </footer>
    </div>

    <script src="app/script.js"></script>

</body>
</html>
