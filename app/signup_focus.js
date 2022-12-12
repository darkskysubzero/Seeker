let n = document.getElementById("name");
let s = document.getElementById("surname");
let e = document.getElementById("email");
let a = document.getElementById("age");
let ph = document.getElementById("phone");
let p = document.getElementById("password");

n.addEventListener('input',function(){
    if(signup_fieldEmpty(n.value)){
    n.style.border="2px solid red";
    document.getElementById("ername").innerHTML="Name cant be empty"; 
    }else{
        n.style.border="none";
        document.getElementById("ername").innerHTML=""; 
        //check name length after
        if(signup_fieldLength(n.value)){
            n.style.border="2px solid red";
            document.getElementById("ername").innerHTML="Name must be at least 2 characters"; 
            }else{
                n.style.border="none";
                document.getElementById("ername").innerHTML=""; 
            }
    }
});

s.addEventListener('input',function(){
    if(signup_fieldEmpty(s.value)){
        s.style.border="2px solid red";
        document.getElementById("ersurname").innerHTML="Surname cant be empty"; 
        }else{
            s.style.border="none";
            document.getElementById("ersurname").innerHTML=""; 

            if(signup_fieldLength(s.value)){
                s.style.border="2px solid red";
                document.getElementById("ersurname").innerHTML="Surname  must be at least 2 characters"; 
                }else{
                    s.style.border="none";
                    document.getElementById("ersurname").innerHTML=""; 

                    
                }
        }
});

e.addEventListener('input',function(){
    if(signup_fieldEmpty(e.value)){
        e.style.border="2px solid red";
        document.getElementById("eremail").innerHTML="Email cant be empty"; 
        }else{
            e.style.border="none";
            document.getElementById("eremail").innerHTML=""; 

            if(signup_fieldLength(e.value)){
                e.style.border="2px solid red";
                document.getElementById("eremail").innerHTML="Email too short!"; 
                }else{
                    e.style.border="none";
                    document.getElementById("eremail").innerHTML=""; 

                    if(!signup_validEmail(e.value)){
                        e.style.border="2px solid red";
                        document.getElementById("eremail").innerHTML="Email is invalid"; 
                        }else{
                            e.style.border="none";
                            document.getElementById("eremail").innerHTML=""; 
                        }
                }
        }
});


a.addEventListener('input',function(){
    if(signup_fieldEmpty(a.value)){
        a.style.border="2px solid red";
        document.getElementById("erage").innerHTML="Age cant be empty"; 
        }else{
            a.style.border="none";
            document.getElementById("erage").innerHTML=""; 

            if(!signup_ageValid(a.value)){
                a.style.border="2px solid red";
                document.getElementById("erage").innerHTML="Invalid age!"; 
                }else{
                    a.style.border="none";
                    document.getElementById("erage").innerHTML=""; 
                }
        }
});

ph.addEventListener('input',function(){
    if(signup_fieldEmpty(ph.value)){
        ph.style.border="2px solid red";
        document.getElementById("ernumber").innerHTML="Phone cant be empty"; 
        }else{
            ph.style.border="none";
            document.getElementById("ernumber").innerHTML=""; 

            if(!signup_validPhone(ph.value)){
                ph.style.border="2px solid red";
                document.getElementById("ernumber").innerHTML="Invalid number!"; 
                }else{
                    ph.style.border="none";
                    document.getElementById("ernumber").innerHTML=""; 
                }
        }
});

p.addEventListener('input',function(){
    if(signup_fieldEmpty(p.value)){
        p.style.border="2px solid red";
        document.getElementById("erpassword").innerHTML="Password cant be empty"; 
        }else{
            p.style.border="none";
            document.getElementById("erpassword").innerHTML=""; 

            if(!signup_validPassword(p.value)){
                p.style.border="2px solid red";
                document.getElementById("erpassword").innerHTML="Password must be at least 6 characters"; 
                }else{
                    p.style.border="none";
                    document.getElementById("erpassword").innerHTML=""; 
                }
        }
});