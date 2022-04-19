"use strict";
const url = document.getElementById("url"); // the url for the shared link
var dlt = document.getElementById("dltb"); // the delete butotn for removing a list from the database 

var buy = document.getElementsByName("buy");
const item = document.getElementById("thisitem");
const update = document.getElementById("update"); //select update button 
const create = document.getElementById("createlist"); //select update button 
const itemsForm = document.querySelector("#items"); // the html form for the list items 
const containslist = document.querySelector(".listitems"); //select the ul with all wishlist items 

if (containslist != null){ 
var list = containslist.querySelectorAll("div");
var list1 = containslist.getElementsByTagName("div"); //set the div if the parent element is found  individual list item
var hide1 =containslist.querySelectorAll("button");
console.log(containslist);
}
const hide = document.getElementById("hide");






    



  




window.addEventListener("DOMContentLoaded", () => {
 
    if(itemsForm != null) {
    itemsForm.addEventListener("submit",(ev) => {
        let error =false;
    const confirmbuy = document.getElementById("item");
    
   if(confirmbuy.checked != false ){
    alert("This item has been marked as bought")
    item.classList.remove('itemlist');
    
    }

})
    }


    //Hide wishlist item with javascript
    if (list != null){
        list.forEach((item)=>{

            item.addEventListener("mouseover", mover);

function mover(ev){

    hide1.forEach((hideitem)=>{
    hideitem.addEventListener("click", hidei);

    function hidei(event){
        var stylethis =  hideitem.parentElement.parentElement;
     
            if(stylethis.classList.contains("list")){
            stylethis.classList.remove("list");
            stylethis.classList.add("hiddenlist");
            hideitem.innerText="hidden";
            }
    
            else if(stylethis.classList.contains("hiddenList"))
            {
                stylethis.classList.add("list");
                stylethis.classList.remove("hiddenlist");
                hideitem.innerHTML="hide";

            }
    }
})
}
})

}



 
    
   
//copy url text 
if(url != null) {
    
    url.addEventListener("click",(ev)=>{   
    var copyText = url.innerHTML; 
    navigator.clipboard.writeText(url.value);
    alert("URL has been copied to clipboard ");
    console.log(url.value);
    
   })
}

//Confirmation dialog for deleting item from dataabse 
if (dlt !=null){
    dlt.addEventListener("click",(ev)=>{
var dltconfirm = confirm("Do you want to delete this list ?");

if (dltconfirm == true )
return true;

else 
return false;
})
}


//chage a list item that has been bought 
if (buy != null){
    console.log(buy);
    buy.forEach((bought)=>{
        bought.addEventListener("submit", (ev) => {
            item.classList.remove('notbought'); // remove default size class
            item.classList.add('bought'); // add x2 img sizing 
            
            })


    })
  
}


if (update !=null){update.addEventListener("submit", (ev)=>{
   alert("Your wishlist has been updated ");


})
}










    





}); //event listener for dom content loaded