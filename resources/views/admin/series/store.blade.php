<div class="modal fade" id="seriesStore" tabindex="-1" aria-labelledby="seriesStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="seriesStoreLabel">Series Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.series.store') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" class="updateDataField">
                    <div class="mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control updateDataField" id="name" type="text" placeholder="Name"
                            name="name">
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label" for="content">Content</label>
                        <div id="content">
                        </div>
                        <input class="updateDataField" id="hiddenContent" type="hidden" name="content">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="seriesMedia">Media File</label>
                        <input class="form-control" id="seriesMedia" type="file" name="media_file" accept="image/*">
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
