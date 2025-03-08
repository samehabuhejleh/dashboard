
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    
    $('.user-table').DataTable({
        ajax: '/super-admin/users',
        columns: [
            { data: 'id' },
            // { data: 'image' },
            { data: 'name' },
            { data: 'email' },
            { data: 'action' },
        ],
    });
    
    $('#create-form').on('submit', function(e) {
        e.preventDefault();
    
        let formData = new FormData(this); 
    
        $.ajax({
            url: "/super-admin/users/create",
            type: "POST",
            data: formData,
            processData: false, 
            contentType: false, 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(res) {
                console.log(res);
                Swal.fire({
                    title:" Created !",
                    text:res.message,
                    icon:"success"
                });
                $("#createModal").modal('hide');
                $('.user-table').DataTable().ajax.reload(); 
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $(document).on('click','#btn_edit',function(e){
        e.preventDefault();
        let id =  $(this).data('user-id');
        $.ajax({
            url:'/super-admin/users/edit/'+id,
            type:"GET",
            success:function(response){
                let data = response.data;

                $('#user-id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_email').val(data.email);
            },
            error:function(response){

            }
        })
    });

    $('#edit-form').on('submit', function(e) {
        e.preventDefault();
        let id =  $('#user-id').val();
        let formData = new FormData(this); 
        $.ajax({
            url: "/super-admin/users/update/"+id,
            type: "POST",
            data: formData,
            processData: false, 
            contentType: false, 
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(res) {
                console.log(res);
                Swal.fire({
                    title:" Updated !",
                    text:res.message,
                    icon:"success"
                });
                $("#editModal").modal('hide');
                $('.user-table').DataTable().ajax.reload(); 
            },
            error: function(error) {
                console.log(error);
            }
        });
    });


    $(document).on("click","#btn_delete",function(e){
        e.preventDefault();
        let id = $(this).data('user-id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
          
                $.ajax({
                    url:"/super-admin/users/delete/"+id,
                    type:"DELETE",
                    success:function(res){
                        Swal.fire({
                            title: "Deleted!",
                            text: res.message,
                            icon: "success"
                          });
                          $('.user-table').DataTable().ajax.reload(); 

                    },
                    error:function(res){
                        Swal.fire({
                            title: "Deleted failed!",
                            text: res.message,
                            icon: "error"
                          });                    }
                })
            }
          });
    });
    
});

// TYPE: //GET POST DELETE

// PUT //INSIDE THE FORM OPN BLADE 