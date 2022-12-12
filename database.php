<?php

$host = "localhost";
$username = "alin";
$password = "00000";
$dbname = "seekerdb";

$connection = new mysqli($host,$username,$password,$dbname);
if($connection->connect_errno){
    echo "there was an error!<br>";
    echo $connection->connect_error;
}

function checkLogin($connection, $table, $email,$password){
    $query = "";
    $passField = "";
    if($table==="admins"){
        $query = "SELECT * FROM $table where adminEmail='$email'";
        $passField = "adminPassword";
    }else if($table==="users"){
        $query = "SELECT * FROM $table where userEmail='$email'";
        $passField = "userPassword";
    }

    
    $result = $connection->query($query);
    
    if($result->num_rows){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $retrievedPassword = $row[$passField];
        $result->close();
        if($password===$retrievedPassword){
            return true;
        }else{
            return false;
        }
    } 
}

function insertProduct($connection, $name, $category,$description, $cost, $sale,$stock,$image){
    $q = $connection->prepare("insert into products values(null,?,?,?,?,?,?,?)");
    $q->bind_param("sssddis",$name,$category,$description,$cost,$sale,$stock,$image);
    $q->execute();
    $q->close();
    $connection->close();
}
 

function getProduct($connection){
    $idfromUpdateURL = 0;
    if(isset($_GET["id"])){
        $idfromUpdateURL=$_GET["id"];
    }

    $idfromDeleteURL = 0;
    if(isset($_GET["did"])){
        $idfromDeleteURL=$_GET["did"];
    }

    $q = "select * from products";
    $r = $connection->query($q);

    //if there are rows then show box otherwise not
    $rowCount = mysqli_num_rows($r); 
    if($rowCount>0){
        echo '<div class="productBox">';
            while($row=$r->fetch_assoc()){
                $productID = $row["productID"];
                $productTitle = $row["productName"];
                $productCategory = $row["productCategory"];
                $productDescription = $row["productDescription"];
                $productCostPrice = $row["productCostPrice"];
                $productSalePrice = $row["productSalePrice"];
                $productStock = $row["productStock"];
                $productImage = $row["productImage"];
                
                if($productImage===""){
                    $productImage = "css/placeholder.png";
                }
        
                if($idfromUpdateURL===$productID){
                    //if there is an update request (show update form)
                    echo '<div class="product">';
                    echo '<form name="updateFrm" method="post" action="updateproduct.php" onsubmit="return checkform(updateFrm);" enctype="multipart/form-data">';
                    echo '<label class="productTitle">';
                    echo 'Name:<input type="text" name="productName" value="'.$productTitle.'"/>';
                    echo '</label>';
                    
                    //creating categories
                    echo '<label class="productTitle">';
                    echo 'Category:';
                    echo '<select name="categories">';
                    echo '<option value="'.$productCategory.'" selected hidden>'.$productCategory.'</option>';
                    $categories = getCategories();
                    foreach ($categories as $category){
                        echo '<option value="'.$category.'">'.$category.'</option>';
                    }
                    echo '</select>';
                    echo '</label>';
                    //-----------------------
                    echo '<label class="productTitle">';
                    echo 'Description :';
                    echo '<textarea name="description">'.$productDescription.'</textarea>';
                    echo '</label>';
                    echo '<label class="productTitle">';
                    echo 'Cost Price : <input type="text" name="costPrice" value="'.$productCostPrice.'"/>';
                    echo '</label>';
                    echo '<label class="productTitle">';
                    echo 'Sale Price : <input type="text" name="salePrice" value="'.$productSalePrice.'"/>';
                    echo '</label>';
                    echo '<label class="productTitle">';
                    echo 'Stock: <input type="number" name="stock" value="'.$productStock.'"/>';
                    echo '</label>';
                    echo '<div class="product-image">';
                    //checking if file exists
                    if(file_exists($productImage)){   
                        echo '<img src="'.$productImage.'"/>';
                    }else{
                        echo '<img src="css/placeholder.png"/>';
                    }
                    echo '</div>';
                    echo '<label class="productTitle">';
                    echo 'File: <input type="file" name="productImage"/>';
                    echo '</label>';
                    echo '<input type="submit" value="Save" class="btnSaveChanges" name="saveButton"/>';
                    echo "<input type='hidden' name='productID' value=".$productID.">";
                    echo '</form>';
                    echo '</div>';
                }else{
                    echo "<div class='product'>";
                    echo "<h3 class='productTitle'>ID [$productID] - $productTitle</h3>";
                    echo "<div class='product-image'>";
                    //checking if file exists
                    if(file_exists($productImage)){   
                        echo '<img src="'.$productImage.'"/>';
                    }else{
                        echo '<img src="css/placeholder.jpg"/>';
                    }
                    echo "</div>";
                    echo "<a class='btnDeleteProduct' href='deleteproduct.php?id=".$productID."'>Delete</a>";
                    echo "<a class='btnChangeProduct' href='admin.php?id=".$productID."'>Modify</a>";
                    echo "</div>";
                }
            }
        echo '</div>';
    }

    
}


function modifyProduct($connection, $name, $category,$description, $cost, $sale,$stock,$image,$id){
    $q = $connection->prepare("update products set productName=?, productCategory=?, productDescription=?, productCostPrice=?, productSalePrice=?, productStock=?, productImage=? where productID=?");
    $q->bind_param("sssddisi",$name,$category,$description,$cost,$sale,$stock,$image,$id);
    $q->execute(); 
    $q->close();
}

function deleteProduct($connection, $id){
    $q = "delete from products where productID=$id";
    $r = $connection->query($q); 
    $connection->close();
}

function stripString($connection, $s){
    $s = trim($s);//trimming whitespaces
    $s = stripslashes($s);
    $s = htmlentities($s);
    return $connection->real_escape_string($s);
}


function getProductImage($connection, $id){
    $query = "SELECT * FROM products where productID=$id";
    $result = $connection->query($query);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $image = $row["productImage"];
    if($image!==""){
        return $image;
    }
    return "css/placeholder.png";
}

function getCategories(){
    $a = array(
        "Electronics",
        "Computers",
        "Arts & Crafts",
        "Automotive",
        "Baby",
        "Fashion",
        "Movies",
        "Software",
        "Tools",
        "Video Games",
        "Outdoors"
    );
    return $a; 
}


//getting messages
function getMessages($connection){
    $q = "select * from contact";
    $r = $connection->query($q);
    while($row=$r->fetch_assoc()){
        $messageID = $row["messageID"];
        $messageTitle = $row["messageTitle"];
        $messageText = $row["messageText"];
        $messageDate = $row["messageDate"];
        $userID = $row["userID"];
        $userName = getUserName($connection,$userID);
        $userEmail = getUserEmail($connection,$userID);
        echo '<div class="message">';
        echo '<div class="messageID">'.$messageID.'</div>';
        echo '<div class="messageTitle">';
        echo '<h2>'.$messageTitle.'</h2>';
        echo '</div>';
        echo '<div class="messageText">';
        echo '<p>'.$messageText.'</p>';
        echo '</div>';
        echo '';
        echo '<div class="meta">';
        echo '<div class="messageDate">'.$messageDate.'</div>';
        echo '<div class="messageBy">By, '.$userName.'</div>';
        echo '<div class="messageEmail">'.$userEmail.'</div>';
        echo '</div>';
        echo '';
        echo '</div>';
    }
}

function getUserName($connection,$id){
    $q = "select userName from users inner join contact on users.userID=$id";
    $r = $connection->query($q);
    $row =  $r->fetch_array(MYSQLI_ASSOC); 
    return $row["userName"];
}

function getUserEmail($connection,$id){
    $q = "select userEmail from users inner join contact on users.userID=$id";
    $r = $connection->query($q);
    $row =  $r->fetch_array(MYSQLI_ASSOC); 
    return $row["userEmail"];
}



function insertUser($connection, $name, $surname,$email, $gender, $age,$phone,$password){
    $q = $connection->prepare("insert into users values(null,?,?,?,?,?,?,?)");
    $q->bind_param("ssssiis",$name,$surname,$email,$gender,$age,$phone,$password);
    $q->execute();
    $q->close();
    $connection->close();
}

function userExists($connection,$email){
    $q = "select userEmail from users where userEmail='$email'";
    $r = $connection->query($q);
    $rowCount = mysqli_num_rows($r); 
    if($rowCount>0){
        return true;
    }
    return false;
}

function getNameFromEmail($connection, $email){
    $q = "select userName from users where userEmail='$email'";
    $r = $connection->query($q); 
    $row =  $r->fetch_array(MYSQLI_ASSOC); 
    return $row["userName"];
}

function getProductForIndex($connection,$search){
    $q = "";
    if($search==="all"){
        $q = "select * from products";
    }else{
        $q = "select * from products where productCategory='$search'";
    } 

    $r = $connection->query($q);
    $rowCount = mysqli_num_rows($r); 
    if($rowCount>0){
        while($row=$r->fetch_assoc()){
            $productID = $row["productID"];
            $productTitle = $row["productName"];
            $productCategory = $row["productCategory"];
            $productDescription = $row["productDescription"];
            $productCostPrice = $row["productCostPrice"];
            $productSalePrice = $row["productSalePrice"];
            $productStock = $row["productStock"];
            $productImage = $row["productImage"];
                    
            if($productImage===""){
                $productImage = "css/placeholder.png";
            }            
            echo '<form method="get" action="index.php">';
            echo '<div class="product">';
            echo '<div class="product-image">';
            //checking if file exists
            if(file_exists($productImage)){   
                echo '<img src="'.$productImage.'"/>';
            }else{
                echo '<img src="css/placeholder.jpg"/>';
            }
            echo '</div>';
            echo '<div class="product-title">';
            echo '<h3>'.$productTitle.'</h3>';
            echo '</div>';
            echo '<div class="product-description">';
            echo '<p>'.$productDescription.'</p>';
            echo '</div>';
            echo '<div class="product-category">';
            echo '<p>'.$productCategory.'</p>';
            echo '</div>';
            echo '<div class="product-price">';
            echo '<h3>R'.$productSalePrice.'</h3>';
            echo '</div>';
            echo '<div class="product-quantity">';
            echo '<input type="number"  value="1" name="quantity" min="0" max="500"/>';
            echo '</div>';
            echo '<input type="hidden" name="pid" value="'.$productID.'" />';
            echo '<input type="submit" class="addBtn" value="Add to cart"/>';
            echo '</div>';
            echo '</form>';
        }
    }else {
        echo '<h1 class="noProducts">There are no products for this category</h1>';
    }

}

function getPriceFromID($connection, $id){
    $q = "select productSalePrice from products where productID='$id'";
    $r = $connection->query($q); 
    $row =  $r->fetch_array(MYSQLI_ASSOC); 
    return $row["productSalePrice"];
}

function getTitleFromID($connection, $id){
    $q = "select productName from products where productID='$id'";
    $r = $connection->query($q); 
    $row =  $r->fetch_array(MYSQLI_ASSOC); 
    return $row["productName"];
}

function getProductImageFromID($connection, $id){
    $q = "select productImage from products where productID='$id'";
    $r = $connection->query($q); 
    $row =  $r->fetch_array(MYSQLI_ASSOC); 
    $product_image = $row["productImage"];
    if(strlen($product_image)===0){
        $product_image = "css/placeholder.jpg";
    } 
    return $product_image;
}

function getDescriptionFromID($connection, $id){
    $q = "select productDescription from products where productID='$id'";
    $r = $connection->query($q); 
    $row =  $r->fetch_array(MYSQLI_ASSOC); 
    return $row["productDescription"];
}


function getUserIDFromEmail($connection,$email){
    $q = "select userID from users where userEmail='$email'";
    $r = $connection->query($q); 
    $row =  $r->fetch_array(MYSQLI_ASSOC); 
    return $row["userID"];
}

function insertPaymentDetails($c,$nam,$con,$cvc,$exp,$uid){
    $q = $c->prepare("insert into paymentdetails values(null,?,?,?,?,?)");
    $q->bind_param("ssisi",$nam,$con,$cvc,$exp,$uid);
    $q->execute();
    $q->close(); 
}


function insertDeliveryAddress($c,$pro,$cit,$loc,$pos,$uid){
    $q = $c->prepare("insert into deliveryaddress values(null,?,?,?,?,?)");
    $q->bind_param("ssssi",$pro,$cit,$loc,$pos,$uid);
    $q->execute();
    $q->close(); 
    return $c->insert_id;
}

function addPayment($c,$date,$amount,$uid){
    $q = $c->prepare("insert into payments values(null,?,?,?)");
    $q->bind_param("sdi",$date,$amount,$uid);
    $q->execute();
    $q->close(); 
    return $c->insert_id;
}

function addOrder($c, $date, $pid){
    $q = $c->prepare("insert into orders values(null,?,?)");
    $q->bind_param("si",$date,$pid);
    $q->execute();
    $q->close(); 
    return $c->insert_id;
}

function addToDBCart($c, $oid,$pid,$quantity){
    $q = $c->prepare("insert into orderproducts values(?,?,?)");
    $q->bind_param("iii",$oid,$pid,$quantity);
    $q->execute();
    $q->close();  
}

function addToShipment($c, $date, $oid, $did){
    $q = $c->prepare("insert into shipment values(null,?,?,?)");
    $q->bind_param("sii",$date,$oid,$did);
    $q->execute();
    $q->close();  
}