<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-form" enctype="multipart/form-data"  class="form">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        
                        <input type="hidden" id="product-id">
                    <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" name="name">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="description">Description</label>
                            <input type="text"  class="form-control" id="edit_description" name="description">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="stock">Stock</label>
                            <input type="number"  class="form-control" id="edit_stock" name="stock">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="price">Price</label>
                            <input  class="form-control" type="number" id="edit_price" name="price">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="main_image">Primary Image</label>
                            <input  type="file"  class="form-control"  id="edit_main_image" name="main_image">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="price">images</label>
                            <input type="file" multiple  class="form-control"  id="edit_images" name="images[]">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>