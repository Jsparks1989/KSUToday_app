



/*

  NOT SURE WHAT THIS IS USED FOR. NOT USED FOR ANYTHING

*/ 


// Get the modal
var editModal = document.getElementById("modal_edit");

// Get the modal form input
var modal_edit_user_id = document.getElementById("modal_edit_user_id");



// Get the button that opens the modal
var editBtn = document.getElementsByClassName("myEditBtn");

// Get the <span> element that closes the modal
var editClose = document.getElementsByClassName("editClose");


// Function that runs when moderator clicks "Remove Contributor" button
// Sets contributor_id & displays modal
function modalEdit(id){
    modal_edit_user_id.setAttribute('value', id);
    for(var i = 0; i < editBtn.length; i++) {
        editBtn[i].onclick = function() {
          editModal.style.display = "block";
        }
    }
}


for(var i = 0; i < editClose.length; i++) {
    // When the user clicks on <span> (x) || "Cancel" button, close the modal
    editClose[i].onclick = function() {
      editModal.style.display = "none";
        modal_edit_user_id.removeAttribute("value");
    }
}

  
  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == editModal) {
      editModal.style.display = "none";
      modal_edit_user_id.removeAttribute("value");
    }
  }




  (function () { GLOBAL_scriptsLoaded.push( 'modal-edit-user.js' ) })();