const { post } = require("jquery");
const { method, endsWith } = require("lodash");

//CUSTOM JS
$('#edit-modal').on('shown.bs.modal', function (event) {
    let button = $(event.relatedTarget) // Button that triggered the modal
    let user = button.data('user');
    let modal = $(this);
    
     modal.find('#editId').val(user.id);
     modal.find('#editName').text(user.name);
     modal.find('#editRole').val(user.role);

})
$('#savedata').on('click', function(e){
  e.preventDefault();
 let id= $(this).attr(id);
 let role = $('#editRole').val();


 $.ajax({
  method: "POST",
   url:"{{route('role.edit')}}",
   dataType:"json",
   data:{
     id:id,
     role:role
   },
   success:function(response){
     alert(response);
     
   }

 });
 });





