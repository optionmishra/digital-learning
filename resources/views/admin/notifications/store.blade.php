<div class="modal fade" id="notificationStore" tabindex="-1" aria-labelledby="notificationStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="notificationStoreLabel">Notification Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.notifications.store') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" id="title" type="text" placeholder="Title" name="title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <input class="form-control" id="description" type="text" placeholder="Description"
                            name="description">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="startDate">Start Date</label>
                        <input class="form-control" id="startDate" type="datetime-local" name="start_date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="endDate">End Date</label>
                        <input class="form-control" id="endDate" type="datetime-local" name="end_date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="status">Status</label>
                        <select class="form-control" name="is_active" id="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
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
