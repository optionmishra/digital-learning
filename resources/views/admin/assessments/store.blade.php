<div class="modal fade" id="assessmentStore" tabindex="-1" aria-labelledby="assessmentStoreLabel">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="assessmentStoreLabel">Assessment Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.assessments.store') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" class="">
                    <div class="row mb-3">
                        <div class="col-lg-4 col-sm-12 mb-3">
                            <label class="form-label" for="standard">Standard</label>
                            <select class="form-control" name="standard_id" id="standard" onchange="updateBooks()">
                                @foreach ($standards as $standard)
                                    <option value="{{ $standard->id }}">{{ $standard->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-12 mb-3">
                            <label class="form-label" for="subject">Subject</label>
                            <select class="form-control" name="subject_id" id="subject" onchange="updateBooks()">
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-4 col-sm-12 mb-3">
                            <label class="form-label" for="book">Book</label>
                            <select class="form-control" name="book_id" id="book">
                                @foreach ($subjects[0]->books as $book)
                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input class="form-control" id="name" type="text" placeholder="Name" name="name">
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-6 col-sm-12 mb-3">
                            <label class="form-label" for="type">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option value="mcq">MCQ</option>
                                <option value="olympiad">Olympiad</option>
                            </select>
                        </div>
                        <div class="col-lg-6 col-sm-12 mb-3">
                            <label class="form-label" for="duration">Duration</label>
                            <input class="form-control" id="duration" type="text" placeholder="Duration (00:00:00)"
                                name="duration">
                        </div>
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
