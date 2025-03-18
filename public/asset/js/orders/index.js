
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    
    $('.order-table').DataTable({
        ajax: '/super-admin/orders',
        columns: [
            { data: 'id' },
            { data: 'user' },
            { data: 'quantity' },
            { data: 'price' },
            {data: 'status'},
            { data: 'action' },
        ],
    });
    
    
    $(document).on('click','#btn_edit',function(e){
        e.preventDefault();
        let id =  $(this).data('order-id');
        $.ajax({
            url:'/super-admin/orders/edit/'+id,
            type:"GET",
            success:function(response){
                let data = response.data;

                $('#order-id').val(data.id);
            },
            error:function(response){

            }
        })
    });

    $('#edit-form').on('submit', function(e) {
        e.preventDefault();
        let id =  $('#order-id').val();
        let formData = new FormData(this); 
        $.ajax({
            url: "/super-admin/orders/update/"+id,
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
                $('.order-table').DataTable().ajax.reload(); 
            },
            error: function(error) {
                console.log(error);
            }
        });
    });


   
    
});

// TYPE: //GET POST DELETE

// PUT //INSIDE THE FORM OPN BLADE 