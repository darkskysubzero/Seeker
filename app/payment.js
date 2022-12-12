function checkout_fieldEmpty(field){
    return (field=="") ? true : false;
}
 

function checkform(form){
    //checking if fields are empty
    if(checkout_fieldEmpty(form.noc.value) || form.noc.value.length<2 || !isNaN(form.noc.value)){
        document.getElementsByName("noc")[0].style.border="2px solid red";
        document.getElementsByName("noc")[0].placeholder = "Enter a valid name";
        alert("Invalid name");
        return false;
    }

    if(checkout_fieldEmpty(form.cn.value) || form.cn.value.length<13){
        document.getElementsByName("cn")[0].style.border="2px solid red";
        document.getElementsByName("cn")[0].placeholder = "Enter a valid card number";
        alert("Invalid card number!");
        return false;
    }

    if(checkout_fieldEmpty(form.cvc.value) || form.cvc.value.length>4 || form.cvc.value.length<3){
        document.getElementsByName("cvc")[0].style.border="2px solid red";
        document.getElementsByName("cvc")[0].placeholder = "Enter a valid CVC";
        alert("Invalid CVC code");
        return false;
    }

    if(checkout_fieldEmpty(form.em.value) || form.em.value.length!=2){
        document.getElementsByName("em")[0].style.border="2px solid red";
        document.getElementsByName("em")[0].placeholder = "Enter a valid month e.g 10";
        alert("Enter a valid month e.g 10");
        return false;
    }

    if(checkout_fieldEmpty(form.ey.value) || form.ey.value.length!=2){
        document.getElementsByName("ey")[0].style.border="2px solid red";
        document.getElementsByName("ey")[0].placeholder = "Enter a valid year e.g 24";
        alert("Enter a valid year e.g 24");
        return false;
    }

    if(checkout_fieldEmpty(form.province.value) || form.province.value.length<2 || !isNaN(form.province.value) ){
        document.getElementsByName("province")[0].style.border="2px solid red";
        document.getElementsByName("province")[0].placeholder = "Enter a valid province";
        alert("Invalid province");
        return false;
    }

    if(checkout_fieldEmpty(form.city.value) || form.city.value.length<2 ||!isNaN(form.city.value)){
        document.getElementsByName("city")[0].style.border="2px solid red";
        document.getElementsByName("city")[0].placeholder = "Enter a valid city";
        alert("Invalid city");
        return false;
    }

    if(checkout_fieldEmpty(form.address.value) || form.address.value.length<2 ||!isNaN(form.address.value)){
        document.getElementsByName("address")[0].style.border="2px solid red";
        document.getElementsByName("address")[0].placeholder = "Enter a valid address";
        alert("Invalid address");
        return false;
    }

    if(checkout_fieldEmpty(form.postal.value) || form.postal.value.length!=4){
        document.getElementsByName("postal")[0].style.border="2px solid red";
        document.getElementsByName("postal")[0].placeholder = "Enter a valid postal code";
        alert("Invalid postal code");
        return false;
    }
 
    return true;

}