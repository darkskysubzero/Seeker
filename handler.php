<?php

include_once "database.php";
$conn = $connection;
session_start();

    if(isset($_POST["loginbtn"])){
        $email = stripString($conn, $_POST["email"]);
        $password = stripString($conn, $_POST["password"]);

        //if the email has admin in it then user is admin
        if(substr($email,0,6)==="admin-"){
            //admin-bruce@wayne.com
            $simpleEmail = substr($email,6,strlen($email));
            //check for admin login in admins table
            if(checkLogin($conn,"admins",$simpleEmail,$password)){
                //create admin session
                $_SESSION["adminLoggedIn"] = "true"; 
                //redirect to admin page
                header("location:admin.php");
            }else{
                header("location:login.php?error=1");
            }

        }else{
            //the user a regular user
            //check for user login in users table
            if(checkLogin($conn,"users",$email,$password)){ 
                $_SESSION["userLoggedIn"] = "true";
                $_SESSION["userName"] = 
                getNameFromEmail($conn,$email);
                $_SESSION["userID"]= getUserIDFromEmail($conn,$email);

                header("location:index.php");
            }else{
               header("location:login.php?error=2");
            }
        }

    }
        

    //if any user clicks logout 
    if(isset($_GET["logout"])){
        if($_GET["logout"]==="true"){
            session_start();

            //if admin session is set then destroy it
            if(isset($_SESSION["adminLoggedIn"])){
                unset($_SESSION["adminLoggedIn"]); 
                session_destroy();
            }
            //if user session is set then destroy it
            else if(isset($_SESSION["userLoggedIn"])){
                unset($_SESSION["userLoggedIn"]);
                unset($_SESSION["cart"]);
                unset($_SESSION["totals"]);
                session_destroy();
            } 
            header("location:index.php");
        }
    }
    

    

    if(isset($_POST["signupbtn"])){
        $name = stripString($conn,$_POST["name"]);
        $surname = stripString($conn,$_POST["surname"]);
        $email = stripString($conn,$_POST["email"]);
        $gender = stripString($conn,$_POST["gender"]);
        $age = stripString($conn,$_POST["age"]);
        $phone = stripString($conn,$_POST["phone"]);
        $password = stripString($conn,$_POST["password"]);

        if(userExists($conn,$email)){
            header("location:signup.php?error=1");
        }else{
            insertUser($conn,$name,$surname,$email,$gender,$age,$phone,$password);
            header("location:login.php");
        }

    }


    //so if user is logged in then do stuff else send them to login page
    if(isset($_GET["checkout"]) && isset($_SESSION["userLoggedIn"])){
        if(isset($_SESSION["cart"]) && !empty($_SESSION["cart"])){     
            header("location:checkoutpage.php");
        }else{
            header("location:index.php");
        }
    }


    /*
        so if make payyment button is clicked and user is logged in and cart is not exmpty
        then do the following.

    */
    if(isset($_POST["paymentBtn"]) && isset($_SESSION["userLoggedIn"]) && isset($_SESSION["cart"]) && !empty($_SESSION["cart"])){

        //payments details table        
        $noc = stripString($conn,$_POST["noc"]);
        $cn = stripString($conn,$_POST["cn"]);
        $cvc = stripString($conn,$_POST["cvc"]);
        $em = stripString($conn,$_POST["em"]);
        $ey = stripString($conn,$_POST["ey"]);
        $expiry = $em."/".$ey;
        //delivery details
        $pro = stripString($conn,$_POST["province"]);
        $cit = stripString($conn,$_POST["city"]);
        $add = stripString($conn,$_POST["address"]);
        $pos = stripString($conn,$_POST["postal"]);
        $uid = stripString($conn,$_SESSION["userID"]);
        
        //payments table
        $date = date("Y/m/d");
        $allTotals = 0;
        if(!empty($_SESSION["totals"])){
            foreach($_SESSION["totals"] as $item => $total){
                $allTotals +=$total;
            }
        }

        //insert user payment details
        insertPaymentDetails($conn,$noc,$cn,$cvc,$expiry,$uid);
        //add to delivery address table
        $deliveryAddressID = insertDeliveryAddress($conn,$pro,$cit,$add,$pos,$uid);
        //add to payment table
        $paymentID = addPayment($conn,$date,$allTotals,$uid);
        //add to order table
        $orderID = addOrder($conn,$date,$paymentID);
        //add to db cart table
        if(!empty($_SESSION["cart"])){
            foreach($_SESSION["cart"] as $pid => $quantity){
                addToDBCart($conn,$orderID,$pid,$quantity);
            }
        }
        //add to shipment table
        addToShipment($conn,$date,$orderID,$deliveryAddressID);
        //#####################################################
        #SUCCESS-----------------------------------------------
        unset($_SESSION["cart"]);
        unset($_SESSION["totals"]);
        
    } 

    if(isset($_GET["checkout"]) && !isset($_SESSION["userLoggedIn"])){
        header("location:login.php");
    }
    ?>

<html>
    <head><title>Success!</title>
    <link rel="icon" type="image/x-icon" href="css/s.png"></head>
    <link rel="stylesheet" href="css/handler.css?v=<?php echo time(); ?>"/>
                
    <body>
        <div class="box">
            <div class="container">
                <h1>Your order was placed successfully!</h1>
                <img src="css/done.gif" />
                <p>You will shortly be notified with a tracking number via email. The delivery will take 2-3 working days.</p>
                <a href="index.php">Continue</a>
            </div>
        </div>
    </body>
</html>