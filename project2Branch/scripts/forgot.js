"use strict";

let emailvalid = true;
let error =false;
window.addEventListener("DOMContentLoaded",() =>{
    const emailIsValid = (string) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(string);

   const forgetform =document.querySelector("#forgotF");

   forgetform.addEventListener("submit",(ev) => {

    const emailInput = document.getElementById("email");
    const userinput = document.getElementById("user");
    if(!emailIsValid(emailInput.value)){
        error=true;
    }
    if(userinput.value ==null){ //Check if anything was enter
        error=true;
    }
    if(error){
        ev.preventDefault();
    }

   });



});