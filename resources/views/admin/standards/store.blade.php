<div class="modal fade" id="standardStore" tabindex="-1" aria-labelledby="standardStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="standardStoreLabel">Standard Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.standards.store') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" class="updateDataField">
                    <div class="mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control updateDataField" id="name" type="text" placeholder="Name"
                            name="name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="order">Order</label>
                        <input class="form-control updateDataField" id="order" type="number" placeholder="Order"
                            name="order">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
