"use strict";


//---select needed elements on main.php ---

const url = document.getElementById("url"); // the url for the shared link
const containslist = document.querySelector(".mainitems"); //select the ul with all wishlist items 
console.log(containslist);
// set child variables if the parent ul exists on page loaded 
if (containslist != null){ 
    var deleteb = containslist.querySelectorAll("#dltb");// check the ul and select all delete buttons 
    var list = containslist.querySelectorAll("div"); // selects all indiviual list items 
    var hide =containslist.querySelectorAll("button"); //seletcs all buttons 
}
    

//----select needed elements on pvlistitems.php---

var buy = document.getElementsByName("buy");//Confirm buy button 
const containspvItems  = document.querySelector(".pvitems"); //select the ul with all public view items  items 
if(containspvItems !=null ){
//const item = document.getElementById("thisitem");
     var item = document.querySelectorAll("div"); // select all the public view itens in a specific list 
// var confirmbuy = document.querySelectorAll("#buybutton"); // select all buy buttons on each individual item
     var itemsForm = containspvItems.querySelectorAll("#items"); // the html form for the list items 
     var buyy = containspvItems.querySelectorAll("#buybutton");// selct all buy buttons 
     var checkbuy = containspvItems.querySelectorAll("#check");// selct all checkoxes in each indiviual list item 
}


//---- select needed elements for update.php----

const update = document.getElementById("update"); //select update button 
const formupdate = document.querySelector("#update2");//selct the form to submit update data
 const password = document.querySelector("#password");// select the input password
console.log(update);


//---- slect needed elements on cList.php (create list)

const create = document.getElementById("createlist"); //select update button 







    

window.addEventListener("DOMContentLoaded", () => {

    if (formupdate !=null){formupdate.addEventListener("submit", (ev)=>{
        alert("Your wishlist has been updated ");
     
     })
     }
     

//On update.php selct the password input and toggle icon to hide/unhide password 
if(password != null){
    const togglePassword = document.querySelector("#togglePassword"); // select font icon to toggle password visibility 
    const password = document.querySelector("#password"); //select password input 
    
    togglePassword.addEventListener("click", function () {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        
        // toggle the icon
        this.classList.toggle("fa-eye");
    });
    }


 //--------  On pvlistitems.php add event listner to the the form submission for confirm buy ------
if(itemsForm != null) {
    itemsForm.forEach((form)=>{
    form.addEventListener("submit",(ev) => {
    let error =false;
    checkbuy.forEach((checkbought)=>{
    
            if(checkbought.checked != false ){
                alert("This item has been marked as bought")
                        
            }    
    })
  })
})
}


//--------- Hide wishlist item with javascript ------

if (list != null){
    list.forEach((item)=>{
        item.addEventListener("mouseover", mover);

    function mover(ev){

    hide.forEach((hideitem)=>{
    hideitem.addEventListener("click", hidei);

function hidei(event){
    var stylethis =  hideitem.parentElement.parentElement;
     
if(stylethis.classList.contains("list")){
    stylethis.classList.remove("list");
    stylethis.classList.add("hiddenlist");
    hideitem.innerText="Hidden";
           
            }
    

else if (stylethis.classList.contains("hiddenlist"))
            {
                stylethis.classList.remove("hiddenlist");
                stylethis.classList.add("list");
                hideitem.innerHTML="Hide List";
            }
    }
})
}
})

}



 
    
   
//--------copy url text to clipboard on main.php-------

if(url != null) {
    
    url.addEventListener("click",(ev)=>{   
    var copyText = url.innerHTML; 
    navigator.clipboard.writeText(url.value);
    alert("URL has been copied to clipboard ");
    console.log(url.value);
    
   })
}




//------ Confirmation dialog for deleting item from dataabse ----- 

if (deleteb !=null){
   
    deleteb.forEach((deleted)=>{
    deleted.addEventListener("click",(ev)=>{
var dltconfirm = confirm("Do you want to delete this list (maybe input the query to run in here) ?");

if (dltconfirm == true ){// if the user confims delete item 
// do xml http request for delte here 
return true;
}

else  {
return false; // dont do anything
}
})
    })
}


//------- chage a list item that has been bought ------- 
if (buyy != null){
    console.log(buyy);
    buyy.forEach((bought)=>{
        bought.addEventListener("submit", (ev) => {
            //Do  xml http request for styling bought item here 

    })
})
}


//-----Also need to view details wish item with js----
  


//XHMTP stuff
const view =document.querySelectorAll("item");
for(let i=0;i<view.length;i++){
    
view[i].addEventListener("submit",(ev)=>{
    const xhr= new XMLHttpRequest();//AJAX stuff
    var itemValue = '<%=session["id"]%>';
    xhr.open("GET","buy.php ?item="+item.value);
    xhr.addEventListener("checklist.php",(ev)=>{
        if(xhr.response ==200){//Actually responded

            if(xhr.response=="no"|| xhr.response==null){ //No item of that value exist
                alert("Item does not exist");
            }
            else{
                alert(xhr.response);
            }
        }


    });//End of XHR event listenr 

    
});

}//End of Loop







    





}); //event listener for dom content loaded