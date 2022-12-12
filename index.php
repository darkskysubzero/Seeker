<?php
        //start session 
        session_start();                        
        include_once "database.php";
        global $conn;
        $conn = $connection;

        //cart session
        if(!isset($_SESSION["cart"])){      
            $_SESSION["cart"]=null;
        } 

        //totals session 
        if(!isset($_SESSION["totals"])){
            $_SESSION["totals"]=null;
        }

        //getting total items in cart
        $itemsInCart = 0;
        if(!empty($_SESSION["cart"])){
            $itemsInCart =count($_SESSION["cart"]); 
        }
        

        global $errorOutput;

        function addToCart(){
            global $errorOutput;
            $errorOutput = "";
            global $conn;
            //if add to cart button is clicked
            if(isset($_GET["pid"])){
                $productID = $_GET["pid"];      //get product id
                $quantity = $_GET["quantity"];  //get product quantity

                //checking if quantity is valid
                if($quantity>0){
                    //buy 
                    if(isset($_SESSION["cart"][$productID])){
                        $_SESSION["cart"][$productID] += $quantity;
                        header("location:index.php");
                    }else{
                        $_SESSION["cart"][$productID] = $quantity;
                        header("location:index.php");
                    }

                    if(isset($_SESSION["totals"][$productID])){
                        $_SESSION["totals"][$productID] += $quantity*getPriceFromID($conn,$productID); 
                        header("location:index.php");
                    }else{
                        $_SESSION["totals"][$productID] = $quantity*getPriceFromID($conn,$productID);
                        
                        header("location:index.php");
                    }

                }else{
                    $errorOutput = "<script>alert('Please enter a valid quantity!');</script>";
                }
            }
        }
        
        function removeFromCart(){
                //so if del button is clicked of an item then remove from cart
                if(isset($_GET["del"])){
                    $clearID = $_GET["del"]; //id of item to be deleted
                    //if item exists already then
                    if(isset($_SESSION["cart"][$clearID])){
                        //delete it
                        unset($_SESSION["cart"][$clearID]); 
                        unset($_SESSION["totals"][$clearID]);
                        //if request made from checkout page go back to checkout page
                        if(isset($_GET["page"]) && $_GET["page"]==="checkout"){
                            //if cart is not empty
                            if(!empty($_SESSION["cart"])){
                                //go back to that page
                                header("location:checkoutpage.php");
                            }else{
                                //else if empty, clean it and go to home
                                clearCart();
                                header("location:index.php");
                            }
                        }else{
                            header("location:index.php");
                        }
                    }
                }
        }
        
        function clearCart(){
            //so if clear cart button is pressed
            if(isset($_GET["clear"])){
                //assign empty array
                $_SESSION["cart"] = array();
                $_SESSION["totals"] = array();
                header("location:index.php");
            }
        }

        
        addToCart();
        clearCart();
        removeFromCart();


         $logoutButton = "";
         $signUpButton = "";
         $productsButton = "";
         $messagesButton = "";
         $profileButton = "";

         $cartButton = '
         <a href="#" class="cartBtn">
         <img src="css/cart.png"/>
         <p>'.$itemsInCart.'</p>
         </a>';

         //if admin is logged in 
         if(isset($_SESSION["adminLoggedIn"])){
            $logoutButton = "<a href='handler.php?logout=true'>Logout</a>";
            $productsButton = "<a href='admin.php'>Products</a>";
            $messagesButton = "<a href='messages.php'>Messages</a>";
            $signUpButton = "";
         }else if(isset($_SESSION["userLoggedIn"])){

            //getting username from db
            $un = $_SESSION["userName"];
            $logoutButton = "<a href='handler.php?logout=true'>Logout</a>"; 
            $profileButton = "<a href='#'>Hi ".$un." </a>";
            $signUpButton = ""; 
         }
         
         else{
             $logoutButton = " <a href='login.php'>Login</a>";
             $signUpButton = "<a href='signup.php'>Sign up</a>"; 
             $productsButton = "";
             $messagesButton = "";
         }

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home | Seeker</title>
    <link rel="icon" type="image/x-icon" href="css/s.png">
    <link rel="stylesheet" href="css/navigation.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/cart.css?v=<?php echo time(); ?>"/>
     
    <?=$errorOutput;?>

</head>
<body>
    

     <!-- Responsive navigation -->
    <nav>
        <div class="container">
            <h1 class="logo"><a href="index.php">Seeker</a></h1>
            <div class="menu">
                <a href="index.php" class="is-active">Home</a>
                <?=$productsButton?>
                <?=$messagesButton?>
                <?=$profileButton?>
                <?=$logoutButton?>
                <?=$signUpButton?>
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
        <a href="index.php" class="is-active">Home</a>
        <?=$productsButton?>
        <?=$messagesButton?>
        <?=$profileButton?>
        <?=$logoutButton?>
        <?=$signUpButton?>
        <?=$cartButton?>
    </nav>

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
                        echo '<a href="index.php?del='.$itemID.'">Delete</a>';
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
            <a href="#" class="cBtn" id="continue"><img src="css/continue.png">Continue shopping</a>
        </div> 
    </div>



     <!-- category buttons -->
    <div id="categories">
          <a href="index.php" id="categoryButton">All</a>
          <?php

            $allCategories = getCategories();
            foreach($allCategories as $category){
                echo '<a href="index.php?show='.$category.'" id="categoryButton">'.$category.'</a>';
            }
            
          ?>
            
    </div>

    <!-- some content -->
    <div class="content">
         <?php
            if(isset($_GET["show"])){
                $showThis = $_GET["show"];
                    getProductForIndex($conn,$showThis);
            }else{
                getProductForIndex($conn,"all");
            }
         ?>
    </div>

    
    <div class="footer-container">
        <footer>
            <p><a href="contact.php">Contact us</a></p>
            <p><a href="aboutus.php">About us</a></p>  
            <p class="cr"><a href="index.php">Seeker &copy;</a> </p>
        </footer>
    </div>

    <script src="app/script.js"></script>

</body>
</html>