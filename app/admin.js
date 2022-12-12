
//Add product form validation
function productNameValid(field){
    if(field==="" || field.length<3){
        return false;
    }else{
        return true;
    }
}
function categoryValid(field){
    return (field=="none") ? false : true; 
}
function productDescriptionValid(field){
    return (field==="") ? false : true; 
}
function costPriceValid(field){
    return (field==="") ? false : true; 
}
function salePriceValid(field){
    return (field==="") ? false : true; 
}
function stockValid(field){
    return (field==="") ? false : true; 
}


function checkform(form){
    if(form.name==="addFrm"){
        //checking if product name is valid
        if(!productNameValid(form.productName.value)){
            document.getElementsByName("productName")[0].style.border="2px solid red";
            document.getElementsByName("productName")[0].placeholder = "Enter a valid product name";
            return false;
        }
        //checking if category is valid
        if(!categoryValid(form.categories.value)){
            document.getElementsByName("categories")[0].style.border="2px solid red"; 
            return false;
        }
        //checking if description is valid
        if(!productDescriptionValid(form.description.value)){
            document.getElementsByName("description")[0].style.border="2px solid red"; 
            document.getElementsByName("description")[0].placeholder = "Enter a description";
            return false;
        }
        
        //checking cost price is valid
        if(!costPriceValid(form.costPrice.value)){
            document.getElementsByName("costPrice")[0].style.border="2px solid red"; 
            document.getElementsByName("costPrice")[0].placeholder = "Enter a cost price";
            return false;
        }

        //checking cost price is valid
        if(!salePriceValid(form.salePrice.value)){
            document.getElementsByName("salePrice")[0].style.border="2px solid red"; 
            document.getElementsByName("salePrice")[0].placeholder = "Enter a sale price";
            return false;
        }

        //checking stock is valid
        if(!stockValid(form.stock.value)){
            document.getElementsByName("stock")[1].style.border="2px solid red"; 
            document.getElementsByName("stock")[1].placeholder = "Enter a stock amount";
            return false;
        }

    }else if(form.name==="updateFrm"){
         //checking if product name is valid
        if(!productNameValid(form.productName.value)){
            document.getElementsByName("productName")[1].style.border="2px solid red";
            document.getElementsByName("productName")[1].placeholder = "Enter a valid product name";
            return false;
        }
        //checking if category is valid
        if(!categoryValid(form.categories.value)){
            document.getElementsByName("categories")[1].style.border="2px solid red"; 
            return false;
        }
        //checking if description is valid
        if(!productDescriptionValid(form.description.value)){
            document.getElementsByName("description")[1].style.border="2px solid red"; 
            document.getElementsByName("description")[1].placeholder = "Enter a description";
            return false;
        }
        
        //checking cost price is valid
        if(!costPriceValid(form.costPrice.value)){
            document.getElementsByName("costPrice")[1].style.border="2px solid red"; 
            document.getElementsByName("costPrice")[1].placeholder = "Enter a cost price";
            return false;
        }

        //checking cost price is valid
        if(!salePriceValid(form.salePrice.value)){
            document.getElementsByName("salePrice")[1].style.border="2px solid red"; 
            document.getElementsByName("salePrice")[1].placeholder = "Enter a sale price";
            return false;
        }

        //checking stock is valid
        if(!stockValid(form.stock.value)){
            document.getElementsByName("stock")[1].style.border="2px solid red"; 
            document.getElementsByName("stock")[1].placeholder = "Enter a stock amount";
            return false;
        }   
    }
    

    //return true;
    return true;
}

