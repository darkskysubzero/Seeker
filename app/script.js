 

const hamburger = document.querySelector('.hamburger');
const mobile_menu = document.querySelector('.mobile-nav');


hamburger.addEventListener('click',function(){ 
    hamburger.classList.toggle('is-active');
    mobile_menu.classList.toggle('is-active');
})


const cartButton = document.querySelector(".cartBtn");
const cartBox = document.querySelector(".cartWindowContainer");
const continueBtn = document.getElementById("continue");
cartButton.addEventListener("click",function(){
            cartBox.classList.toggle("hideCart");
});

continueBtn.addEventListener("click",function(){
    cartBox.classList.toggle("hideCart");
});


//for mobile
const cartButton2 = document.querySelector(".mobile-nav .cartBtn");
cartButton2.addEventListener('click',function(){
    cartBox.classList.toggle("hideCart");
})

//success message 
let popup = document.querySelector(".popup");
let blur = document.querySelector(".blur");
function showPopup(){
    popup.classList.remove("hide");
    blur.classList.remove("hide");
}
function closePopup(){
    popup.classList.add("hide");
    blur.classList.add("hide");
} 

let b = document.getElementById("closePBtn");
b.addEventListener("click",function(){
    closePopup(); 
    window.location.href = "admin.php";
});


