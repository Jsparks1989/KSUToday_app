


/*

  NOT SURE WHAT THIS IS USED FOR. NOT USED FOR ANYTHING

*/ 



// Get the modal
var deleteModal = document.getElementById("modal_delete");

// Get the modal form input
var modal_delete_user_id = document.getElementById("modal_delete_user_id");



// Get the button that opens the modal
var deleteBtn = document.getElementsByClassName("myDeleteBtn");

// Get the <span> element that closes the modal
var deleteSpan = document.getElementsByClassName("deleteClose");


// Function that runs when moderator clicks "Remove Contributor" button
// Sets contributor_id & displays modal
function modalDelete(id){
    modal_delete_user_id.setAttribute('value', id);
    // When the user clicks the button, open the modal 
    for(var i = 0; i < deleteBtn.length; i++) {  
      deleteBtn[i].onclick = function() {
        deleteModal.style.display = "block";
      }
    }
}


for(var i = 0; i < deleteSpan.length; i++) {
    // When the user clicks on <span> (x) || "Cancel" button, close the modal
    deleteSpan[i].onclick = function() {
      deleteModal.style.display = "none";
        // modal_form_input.removeAttribute("value");
        modal_delete_user_id.removeAttribute("value");
    }
}

  
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == deleteModal) {
      deleteModal.style.display = "none";
      // modal_form_input.removeAttribute("value");
      modal_delete_user_id.removeAttribute("value");
    }
  }


  (function () { GLOBAL_scriptsLoaded.push( 'modal-delete.js' ) })();