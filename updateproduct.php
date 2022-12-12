<?php

    include_once "database.php";
    include_once "filehandler.php";
    $conn = $connection;
    
    if(isset($_POST["saveButton"])){
        //new data from update form
        $productID = stripString($conn,$_POST["productID"]);
        $productName = stripString($conn,$_POST["productName"]);
        $productCategory = stripString($conn,$_POST["categories"]);
        $productDescription = stripString($conn,$_POST["description"]);
        $productCostPrice = stripString($conn,$_POST["costPrice"]);
        $productSalePrice = stripString($conn,$_POST["salePrice"]);
        $productStock = stripString($conn,$_POST["stock"]);

        
        $productImage = getProductImage($conn,$productID);

        if(isset($_FILES["productImage"])){
            $file = $_FILES["productImage"];
            if($file["tmp_name"]!=""){
                deleteOldFile($productImage);
                moveFile($file,$productName,"products");
                $productImage = getFileDir();
                modifyProduct($conn,$productName,$productCategory,$productDescription,$productCostPrice,$productSalePrice,$productStock,$productImage,$productID);
                header("location:admin.php");
            }else{
                modifyProduct($conn,$productName,$productCategory,$productDescription,$productCostPrice,$productSalePrice,$productStock,$productImage,$productID);
                header("location:admin.php");
            }
        }

        // modifyProduct($conn,$productName,$productCategory,$productDescription,$productCostPrice,$productSalePrice,$productStock,"",$productID);

         
    }