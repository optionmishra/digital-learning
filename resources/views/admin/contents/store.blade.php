<div class="modal fade" id="contentStore" tabindex="-1" aria-labelledby="contentStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="contentStoreLabel">{{ $contentType->name }} Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.contents.store') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" class="">
                    <input type="hidden" name="type" value="{{ $contentType->name }}">
                    <input type="hidden" name="content_type_id" value="{{ $contentType->id }}">

                    <div class="mb-3 row">
                        <div class="mb-3 col-lg-4 col-sm-12">
                            <label class="form-label" for="standard">Standard</label>
                            <select class="form-control" name="standard_id" id="standard" onchange="updateBooks()">
                                @foreach ($standards as $standard)
                                    <option value="{{ $standard->id }}">{{ $standard->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-4 col-sm-12">
                            <label class="form-label" for="subject">Subject</label>
                            <select class="form-control" name="subject_id" id="subject" onchange="updateBooks()">
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-4 col-sm-12">
                            <label class="form-label" for="book">Book</label>
                            <select class="form-control" name="book_id" id="book">
                                @foreach ($subjects[0]->books as $book)
                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" id="title" type="text" placeholder="Title" name="title">
                    </div>
                    <div class="mb-3 row">
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label class="form-label" for="tags">Tags</label>
                            <input class="form-control" id="tags" type="text"
                                placeholder="Tags (separated by comma)" name="tags">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label class="form-label" for="img_type">Image Upload Type</label>
                            <select class="form-control" name="img_type" id="img_type">
                                <option value="file">File</option>
                                <option value="url">URL</option>
                            </select>
                        </div>
                        <div id="imgFileInputContainer" class="mb-3 col-lg-6 col-sm-12">
                            <label class="form-label" for="img">File</label>
                            <input class="form-control" id="img" type="file" name="img" accept="image/*">
                        </div>
                        <div id="imgUrlInputContainer" class="mb-3 col-lg-6 col-sm-12 d-none">
                            <label class="form-label" for="img_url">URL</label>
                            <input class="form-control" id="img_url" type="url" name="img_url"
                                placeholder="https://www.example.com/">
                        </div>
                    </div>
                    @if ($contentType->name == 'Video')
                        <div class="mb-3 row">
                            <div class="mb-3 col-lg-6 col-sm-12">
                                <label class="form-label" for="creator">Creator</label>
                                <input class="form-control" id="creator" type="text" placeholder="Creator Name"
                                    name="creator">
                            </div>
                        </div>
                    @endif
                    <div class="mb-3 row">
                        <div class="mb-3 col-lg-6 col-sm-12">
                            <label class="form-label" for="src_type">Source Upload Type</label>
                            <select class="form-control" name="src_type" id="src_type">
                                <option value="file">File</option>
                                <option value="url">URL</option>
                            </select>
                        </div>
                        <div id="srcFileInputContainer" class="mb-3 col-lg-6 col-sm-12">
                            <label class="form-label" for="file">File</label>
                            <input class="form-control" id="file" type="file" name="file">
                        </div>
                        <div id="srcUrlInputContainer" class="mb-3 col-lg-6 col-sm-12 d-none">
                            <label class="form-label" for="url">URL</label>
                            <input class="form-control" id="url" type="url" name="url"
                                placeholder="https://www.example.com/">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="about">About</label>
                        {{-- <div id="about" class="editor">
                        </div>
                        <input class="" id="hidden_about" type="hidden" name="about"> --}}
                        <textarea class="form-control" name="about" id="about" rows="5"></textarea>
                    </div>
                    @if ($contentType->name == 'Ebook')
                        <div class="mb-3">
                            <label class="form-label" for="price">Price</label>
                            <input class="form-control" id="price" type="number" placeholder="Price"
                                name="price">
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
