//Login form valiation
function login_emailEmpty(field){
    return (field==="") ? true : false;
}
function login_passEmpty(field){
    return (field==="") ? true : false;
}
function checkform(form){
    //checking if login email is empty
    if(login_emailEmpty(form.email.value)){
        document.getElementsByName("email")[0].style.border="2px solid red";
        document.getElementsByName("email")[0].placeholder = "cant be empty";
        return false;
    }
    //checking if password is empty
    if(login_passEmpty(form.password.value)){
        document.getElementsByName("password")[0].style.border="2px solid red";
        document.getElementsByName("password")[0].placeholder = "password cant be empty";
        return false;
    }
    return true;
}