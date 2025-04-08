<div class="modal fade" id="schoolStore" tabindex="-1" aria-labelledby="schoolStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="schoolStoreLabel">School Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.schools.store') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <label class="form-label" for="name">Name *</label>
                        <input class="form-control" id="name" type="text" placeholder="School Name"
                            name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input class="form-control" id="email" type="email" placeholder="School Email"
                            name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">Address</label>
                        <input class="form-control" id="address" type="text" placeholder="School Address"
                            name="address">
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
