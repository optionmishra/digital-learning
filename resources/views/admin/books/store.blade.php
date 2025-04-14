<div class="modal fade" id="bookStore" tabindex="-1" aria-labelledby="bookStoreLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="bookStoreLabel">Book Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.books.store') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" class="">
                    <div class="row mb-3">
                        <div class="col-lg-3 col-sm-1 mb-3">
                            <label class="form-label" for="series">Series</label>
                            <Select class="form-control updateSelectedValue" id="series" name="series_id"
                                @disabled(!$series->count())>
                                @forelse ($series as $series)
                                    <option value="{{ $series->id }}">{{ $series->name }}</option>
                                @empty
                                    <option value="">Please add a Series first</option>
                                @endforelse
                            </Select>
                        </div>
                        <div class="col-lg-3 col-sm-1 mb-3">
                            <label class="form-label" for="board">Board</label>
                            <Select class="form-control updateSelectedValue" id="board" name="board_id"
                                @disabled(!$boards->count())>
                                @forelse ($boards as $board)
                                    <option value="{{ $board->id }}">{{ $board->name }}</option>
                                @empty
                                    <option value="">Please add a Board first</option>
                                @endforelse
                            </Select>
                        </div>
                        <div class="col-lg-3 col-sm-1 mb-3">
                            <label class="form-label" for="standard">Standard</label>
                            <Select class="form-control updateSelectedValue" id="standard" name="standard_id"
                                @disabled(!$standards->count())>
                                @forelse ($standards as $standard)
                                    <option value="{{ $standard->id }}">{{ $standard->name }}</option>
                                @empty
                                    <option value="">Please add a Standard first</option>
                                @endforelse
                            </Select>
                        </div>
                        <div class="col-lg-3 col-sm-1 mb-3">
                            <label class="form-label" for="subject">Subject</label>
                            <Select class="form-control updateSelectedValue" id="subject" name="subject_id"
                                @disabled(!$subjects->count())>
                                @forelse ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @empty
                                    <option value="">Please add a Subject first</option>
                                @endforelse
                            </Select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4 col-sm-1 mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" id="name" type="text" placeholder="Name" name="name">
                        </div>
                        <div class="col-lg-4 col-sm-1 mb-3">
                            <label class="form-label" for="bookMedia">Image</label>
                            <input class="form-control" id="bookMedia" type="file" name="media_file"
                                accept="image/*">
                        </div>
                        <div class="col-lg-4 col-sm-1 mb-3">
                            <label class="form-label" for="author">Author</label>
                            <Select class="form-control updateSelectedValue" id="author" name="author_id"
                                @disabled(!$authors->count())>
                                @forelse ($authors as $author)
                                    <option value="{{ $author->id }}">{{ $author->name }}</option>
                                @empty
                                    <option value="">Please add a Author first</option>
                                @endforelse
                            </Select>
                        </div>
                    </div>
                    {{-- <div class="mb-3">
                        <label class="form-label" for="about">About</label>
                        <div id="about" class="editor">
                        </div>
                        <input class="" id="hidden_about" type="hidden" name="about">
                    </div> --}}
                    <div class="mb-3">
                        <label class="form-label" for="about">About</label>
                        <textarea class="form-control" name="about" id="about" cols="30" rows="10"></textarea>
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
