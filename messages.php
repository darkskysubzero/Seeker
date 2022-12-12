<?php
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages | Seeker</title>
    <link rel="icon" type="image/x-icon" href="css/s.png">
    <link rel="stylesheet" href="css/navigation.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/message.css?v=<?php echo time(); ?>"/>
</head>
<body>

<?php
        $adminButton ="";
        $logoutButton = "";
        $messagesButton = ""; 
        if(isset($_SESSION["adminLoggedIn"])){
            $adminButton = "<a href='admin.php' >Products</a>";
            $logoutButton = "<a href='handler.php?logout=true'>Logout</a>";
            $messagesButton = "<a href='messages.php' class='is-active'>Messages</a>";
        }else{
            header("location:index.php");
        }
        
        include_once "database.php";
        $conn = $connection;
        
    ?>

    <!-- Responsive navigation -->
    <nav>
        <div class="container">
        <h1 class="logo"><a href="index.php">Seeker</a></h1>
            <div class="menu">
                <a href="index.php" >Home</a>
                <?=$adminButton?>
                <?=$messagesButton?>
                <?=$logoutButton?>
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
        <?=$messagesButton?>
        <?=$logoutButton?>
    </nav>

    <div class="messageContainer">
        <?=getMessages($conn);?>
    </div>

 
</body>
</html>