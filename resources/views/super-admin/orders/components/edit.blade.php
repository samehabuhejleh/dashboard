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
                        
                        <input type="hidden" id="order-id">
                        <div class="form-group">
                        <select name="status" id="status">
                            <option value=""></option>

                            <option value="{{App\Enums\OrderStatus::Canceled}}">{{App\Enums\OrderStatus::Canceled}}</option>
                            <option value="{{App\Enums\OrderStatus::Pending}}">{{App\Enums\OrderStatus::Pending}}</option>
                            <option value="{{App\Enums\OrderStatus::Completed}}">{{App\Enums\OrderStatus::Completed}}</option>
                            <option value="{{App\Enums\OrderStatus::Processing}}">{{App\Enums\OrderStatus::Processing}}</option>

                        </select>     
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