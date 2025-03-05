
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    
    $('.product-table').DataTable({
        ajax: '/super-admin/products',
        columns: [
            { data: 'name' },
            { data: 'description' },
            { data: 'stock' },
            { data: 'price' },
            { data: 'action' },
        ],
    });
    
    $('#create-form').on('submit', function(e) {
        e.preventDefault();
    
        let formData = new FormData(this); 
    
        $.ajax({
            url: "/super-admin/products/create",
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
                $('.product-table').DataTable().ajax.reload(); 
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    $(document).on('click','#btn_edit',function(e){
        e.preventDefault();
        let id =  $(this).data('product-id');
        $.ajax({
            url:'/super-admin/products/edit/'+id,
            type:"GET",
            success:function(response){
                let data = response.data;

                $('#product-id').val(data.id);
                $('#edit_name').val(data.name);
                $('#edit_description').val(data.description);
                $('#edit_stock').val(data.stock);
                $('#edit_price').val(data.price);
            },
            error:function(response){

            }
        })
    });

    $('#edit-form').on('submit', function(e) {
        e.preventDefault();
        let id =  $('#product-id').val();
        let formData = new FormData(this); 
        $.ajax({
            url: "/super-admin/products/update/"+id,
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
                $('.product-table').DataTable().ajax.reload(); 
            },
            error: function(error) {
                console.log(error);
            }
        });
    });


    $(document).on("click","#btn_delete",function(e){
        e.preventDefault();
        let id = $(this).data('product-id');
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
                    url:"/super-admin/products/delete/"+id,
                    type:"DELETE",
                    success:function(res){
                        Swal.fire({
                            title: "Deleted!",
                            text: res.message,
                            icon: "success"
                          });
                          $('.product-table').DataTable().ajax.reload(); 

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