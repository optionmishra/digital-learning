<div class="modal fade" id="questionStoreBatch" tabindex="-1" aria-labelledby="questionStoreBatchLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="questionStoreBatchLabel">Question Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>

            </div>
            <form method="POST" action="{{ route('admin.questions.storeBatch') }}" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="id" class="">
                    <div class="mb-3 row">
                        <div class="mb-3 col-lg-3 col-sm-12">
                            <label class="form-label" for="standard">Standard</label>
                            <select class="form-control" name="standard_id" id="standard">
                                @foreach ($standards as $standard)
                                    <option value="{{ $standard->id }}">{{ $standard->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-3 col-sm-12">
                            <label class="form-label" for="subject2">Subject</label>
                            <select class="form-control" name="subject_id" id="subject">
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-3 col-sm-12">
                            <label class="form-label" for="series">Series</label>
                            <select class="form-control" name="series_id" id="series">
                                @foreach ($series as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-3 col-sm-12">
                            <label class="form-label" for="book2">Book</label>
                            <select class="form-control" name="book_id" id="book2">
                                @foreach ($subjects[0]->books as $book)
                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-3 col-sm-12">
                            <label class="form-label" for="topic2">Topic</label>
                            <select class="form-control" name="topic_id" id="topic2">
                                @foreach ($books[0]->topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label" for="assessment2">Assessment</label>
                        <select class="form-control" name="assessment_id" id="assessment2">
                            @foreach ($books[0]->assessments as $assessment)
                                <option value="{{ $assessment->id }}">{{ $assessment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <p>The CSV file must contain the following columns in this exact order:</p>
                        @include('admin.questions.csv-file-template')
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="questions_file">Questions File</label>
                        <input class="form-control" id="questions_file" name="questions_file" type="file"
                            accept="text/csv" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="images_file">Images File</label>
                        <input class="form-control" id="images_file" name="images_file" type="file"
                            accept="application/zip">
                    </div>
                    <span class="text-danger text-center">Please ensure all images are exactly 400x250 pixels in
                        dimension.</span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                    <a class="btn btn-primary" href="{{ route('admin.questions.downloadTemplate') }}">Download Sample
                        CSV</a>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
