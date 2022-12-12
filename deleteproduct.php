<?php

include_once "database.php";
include_once "filehandler.php";
$conn = $connection;
if(isset($_GET["id"])){
    $productID = stripString($conn,$_GET["id"]);
    $productImage = getProductImage($conn,$productID);
    deleteOldFile($productImage);
    deleteProduct($conn,$productID);
    header("location:admin.php");
}