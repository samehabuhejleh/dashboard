<!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="create-form" enctype="multipart/form-data" class="form">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="email">Email</label>
                            <input type="email"  class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="password">Password</label>
                            <input type="password"  class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="password-confirm">Confirm Password</label>
                            <input  class="form-control" type="password" id="password-confirm" name="password_confirmation">
                        </div>
                        <div class="form-group">
                            <label  class="form-label" for="main_image">Primary Image</label>
                            <input  type="file"  class="form-control"  id="main_image" name="main_image">
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