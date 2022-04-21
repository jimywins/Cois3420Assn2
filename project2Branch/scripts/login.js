"use strict";


window.addEventListener("DOMContentLoaded",() =>{

    
let error=false;
    const logform=document.querySelector("#login");

    logform.addEventListener("submit",(ev)=>{ //When Submit button is pushed
     let error=false;

     const userinput=document.getElementById("username");
  
    if(usererror.value ==null){ //Nothing was entered
        error=true;
    }
     const passinput=document.getElementById("password");
     
    if(passerror.value ==null){ //Check if empty
        error=true;
    }

if(error){//There was an empty entry
ev.preventDefault();//Stops submiting
}

    });//Submit Button listiner complete



});



