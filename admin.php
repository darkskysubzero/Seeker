<?php
        session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Seeker</title>
    <link rel="icon" type="image/x-icon" href="css/s.png">
    <link rel="stylesheet" href="css/navigation.css?v=<?php echo time(); ?>"/>
    <link rel="stylesheet" href="css/admin.css?v=<?php echo time(); ?>"/>
    <script src="app/admin.js"></script>
</head>
<body>

    <?php
        $adminButton ="";
        $logoutButton = "";
        $messagesButton = ""; 
        if(isset($_SESSION["adminLoggedIn"])){
            $adminButton = "<a href='admin.php' class='is-active'>Products</a>";
            $logoutButton = "<a href='handler.php?logout=true'>Logout</a>";
            $messagesButton = "<a href='messages.php'>Messages</a>";
        }else{
            header("location:index.php");
        }       
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

    <!-- product management code -->
    <div class="p-container">

        <!-- add product box -->
        <div class="addBox">
            <h2>Add Product</h2>
            <p>Use this form to add products to table</p>
            <form name="addFrm" action="addproduct.php" method="post" onsubmit="return checkform(addFrm)" autocomplete="off" enctype="multipart/form-data">
                <div class="formAddProduct">
                    <label>
                            Name : <input type="text" name="productName"/>
                    </label>
                    <label>
                        Category : 
                        <select name="categories">
                            <option value="none" selected disabled hidden>Select category</option>
                            <?php
                            //including database file for method
                            include_once "database.php";
                            $categories = getCategories();
                            foreach ($categories as $category){
                                echo '<option value="'.$category.'">'.$category.'</option>';
                            }
                        ?>
                        </select>

                        
                    </label>
                    <label>Description : 
                        <textarea name="description">Hi</textarea>
                    </label>
                    <label>
                        Cost Price : <input type="text" name="costPrice"/>
                    </label>
                    <label>
                        Sale Price : <input type="text" name="salePrice"/>
                    </label>
                    <label>
                        Stock : <input type="number" name="stock"/>
                    </label>
                    <label>
                        Image : <input type="file" name="productImage"/>
                    </label>
                </div>
                <input type="submit" name="addButton" value="Add Product" id="addButton"/>
            </form>

            <div class="popup hide">
                <img src="css/tick.png" alt="tick"/>
                <h2>Success!</h2>
                <p>Product has been added.</p>
                <button type="button" id="closePBtn">Ok</button>
            </div>
        </div>


        <!-- displaying product for modification/deletion -->            
            <?php
                $conn = $connection;
                getProduct($conn);
            ?>
 



    <!-- background blur relative to body -->
    <div class="blur hide"></div>
    <script src="app/script.js"></script>
 
    <?php
             //displaying success message
            if(isset($_GET["success"]) && $_GET["success"]==="true"){
                echo "<script>showPopup();</script>";
                
            }
    ?>
  
</body>

</html>

