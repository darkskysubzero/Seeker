 //signup form validation



 function signup_fieldEmpty(field){
    return (field=="") ? true : false;
}

function signup_fieldLength(field){
    return (field.length<2) ? true : false;
}
function signup_ageValid(field){
    let v = field.match(/^\d+$/);
    if((v==null) || (field<10 || field>100) && (field.length!=2)){
        return false;
    }
    return true;
    // return )? true : false;
}
function signup_validEmail(field){
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(field)){
        return true;
    }else{
        return false;
    }
}
function signup_validPhone(field){
    let v = field.match(/^\d+$/);
    if((v==null) || field.length!=10){
        return false;
    }
    return true;
}

function signup_validPassword(field){
    return (field.length>6)? true:false;
}



function checkform(form){
    //checking if fields are empty
    if(signup_fieldEmpty(form.name.value)){
        document.getElementsByName("name")[0].style.border="2px solid red";
        document.getElementById("ername").innerHTML="Name cant be empty";
        return false;
    }else if(signup_fieldLength(form.name.value)){
        document.getElementsByName("name")[0].style.border="2px solid red";
        document.getElementById("ername").innerHTML="Name must be at least 2 characters";
        return false;
    }


    if(signup_fieldEmpty(form.surname.value)){
        document.getElementsByName("surname")[0].style.border="2px solid red";
        document.getElementById("ersurname").innerHTML="Surname cant be empty";
        return false;
    }else  if(signup_fieldLength(form.surname.value)){
        s.style.border="2px solid red";
        document.getElementById("ersurname").innerHTML="Surname  must be at least 2 characters"; 
        return false;
    }

    if(signup_fieldEmpty(form.email.value)){
        document.getElementsByName("email")[0].style.border="2px solid red";
        document.getElementById("eremail").innerHTML="Email cant be empty";
        return false;
    }else if(signup_fieldLength(form.email.value)){
        document.getElementsByName("email")[0].style.border="2px solid red";
        document.getElementById("eremail").innerHTML="Email too short!"; 
        return false;
    }   

    if(signup_fieldEmpty(form.gender.value)){
        document.getElementsByName("gender")[0].style.border="2px solid red";
        document.getElementById("ergender").innerHTML="Select your gender"
        return false;
    }
    if(signup_fieldEmpty(form.age.value)){
        document.getElementsByName("age")[0].style.border="2px solid red";
        document.getElementById("erage").innerHTML="Age cant be empty"
        return false;
    }else  if(!signup_ageValid(form.age.value)){
        document.getElementsByName("age")[0].style.border="2px solid red";
        document.getElementById("erage").innerHTML="Invalid age!"; 
        return false;
    }


    if(signup_fieldEmpty(form.phone.value)){
        document.getElementsByName("phone")[0].style.border="2px solid red";
        document.getElementById("ernumber").innerHTML="Enter a phone number please"
        return false;
    }else if(!signup_validPhone(form.phone.value)){
        document.getElementsByName("phone")[0].style.border="2px solid red";
        document.getElementById("ernumber").innerHTML="Invalid number!";
        return false;
    }

    if(signup_fieldEmpty(form.password.value)){
        document.getElementsByName("password")[0].style.border="2px solid red";
        document.getElementById("erpassword").innerHTML="Password cannot be blank!"
        return false;
    }else if(!signup_validPassword(form.password.value)){
        document.getElementsByName("password")[0].style.border="2px solid red";
        document.getElementById("erpassword").innerHTML="Password must be at least 6 characters"; 
        return false;
    }
  
    
    return true;
}


