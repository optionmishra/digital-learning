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
                            <select class="form-control" name="book_id" id="book"
                                onchange="updateTopics(), updateAssessments()">
                                @foreach ($subjects[0]->books as $book)
                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-4 col-sm-12">
                            <label class="form-label" for="topic">Topic</label>
                            <select class="form-control" name="topic_id" id="topic">
                                @foreach ($books[0]->topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label" for="assessment">Assessment</label>
                        <select class="form-control" name="assessment_id" id="assessment">
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
