"use strict";

let error=false;
window.addEventListener("DOMContentLoaded",() =>{

const passchange = document.querySelector("#Passchange")

passchange.addEventListener("submit",(ev) => {

    const NP =document.getElementById("NP");
    const CP= document.getElementById("CP");

    if(NP.value ==null || CP.value==null){ // Empty Check
        error =true;
    }
    if(!(CP === NP)){//See if their the same check

error=true;
    }

    if(error){
        ev.preventDefault();
    }
});



});