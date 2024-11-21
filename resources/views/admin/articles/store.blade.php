<div class="modal fade" id="articleStore" tabindex="-1" aria-labelledby="articleStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="articleStoreLabel">Article Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.articles.store') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" class="">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" id="title" type="text" placeholder="Title" name="title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="content">Content</label>
                        <div id="content" class="editor">
                        </div>
                        <input class="" id="hidden_content" type="hidden" name="content">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="img">Image</label>
                        <input class="form-control" id="img" type="file" name="img" accept="image/*">
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
