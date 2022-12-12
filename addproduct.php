<?php

    include_once "database.php";
    include_once "filehandler.php";
    $conn = $connection;
    
    //if submit button clicked
    if(isset($_POST["addButton"])){
        $productName = stripString($conn,$_POST["productName"]);
        $productCategory = stripString($conn,$_POST["categories"]);
        $productDescription = stripString($conn,$_POST["description"]);
        $productCostPrice = stripString($conn,$_POST["costPrice"]);
        $productSalePrice = stripString($conn,$_POST["salePrice"]);
        $productStock = stripString($conn,$_POST["stock"]);

        if(isset($_FILES["productImage"])){   
            $file = $_FILES["productImage"];   
             //if image was set
            if($file["tmp_name"]!=""){
                moveFile($file,$productName,"products");
                $productImage = getFileDir();
                insertProduct($conn,$productName,$productCategory,$productDescription,$productCostPrice,$productSalePrice,$productStock,$productImage);
                header("location:admin.php?success=true");
            }else{
               //if no image was uploaded
                insertProduct($conn,$productName,$productCategory,$productDescription,$productCostPrice,$productSalePrice,$productStock,"");
                header("location:admin.php?success=true");
            }
        } 
    }
 


    
