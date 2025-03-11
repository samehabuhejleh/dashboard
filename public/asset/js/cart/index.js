$(document).ready(function(e){
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $("#add-cart-form").on('submit',function(e){
        e.preventDefault();
        let formData = new FormData(this); 

        $.ajax({
            url: "/cart/add",
            type: "POST",
            data: formData,
            processData: false,  // Prevent jQuery from converting FormData into a string
            contentType: false,  // Prevent jQuery from setting content-type header
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                Swal.fire({
                    title: "Created!",
                    text: res.message,
                    icon: "success"
                });
            },
            error: function(xhr) {
                Swal.fire({
                    title: "Error!",
                    text: xhr.responseJSON?.message || "Something went wrong!",
                    icon: "error"
                });
            }
        });
        });
        

        $('#remove-item').on("click",function(e){
            e.preventDefault();
            let id = $(this).data('item-id');
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
                        url:"/cart/delete/"+id,
                        type:"DELETE",
                        success:function(res){
                            Swal.fire({
                                title: "Deleted!",
                                text: res.message,
                                icon: "success"
                              });

                              window.location.reload();
                    
                        },
                        error:function(res){
                            Swal.fire({
                                title: "Deleted failed!",
                                text: res.message,
                                icon: "error"
                              });           
                            
                        }
                    })
                }
              });
        });
});