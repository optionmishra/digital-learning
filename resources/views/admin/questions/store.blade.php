<div class="modal fade" id="questionStore" tabindex="-1" aria-labelledby="questionStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="questionStoreLabel">Question Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.questions.store') }}" id="updateDataForm"
                class="question-store-form" data-single-route="{{ route('admin.questions.store') }}"
                data-batch-route="{{ route('admin.questions.storeBatch') }}">
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
                            <label class="form-label" for="subject">Subject</label>
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
                            <label class="form-label" for="book">Book</label>
                            <select class="form-control" name="book_id" id="book">
                                @foreach ($subjects[0]->books as $book)
                                    <option value="{{ $book->id }}">{{ $book->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 col-lg-3 col-sm-12">
                            <label class="form-label" for="topic">Chapter</label>
                            <select class="form-control" name="topic_id" id="topic">
                                @foreach ($books[0]->topics as $topic)
                                    <option value="{{ $topic->id }}">{{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="assessment">Assessment</label>
                        <select class="form-control" name="assessment_id" id="assessment">
                            @foreach ($books[0]->assessments as $assessment)
                                <option value="{{ $assessment->id }}">{{ $assessment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="question_type_id">Question Type</label>
                        <select class="form-control" name="question_type_id" id="question_type_id">
                            <option value="">Select Question Type</option>
                            @foreach ($questionTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="single-question">
                        <div class="mb-3">
                            <label class="form-label" for="question_text">Question</label>
                            <input class="form-control" id="question_text" type="text" placeholder="Question"
                                name="question_text">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="question_img">Question Image</label>
                            <input class="form-control" id="question_img" type="file" placeholder="Question Image"
                                name="question_img">
                        </div>
                        <div class="mb-3 row">
                            <div class="col-lg-6 col-sm-12">
                                <label for="option_1" class="form-label">Option 1</label>
                                <input id="option_1" type="text" name="option_1" class="mb-1 form-control"
                                    placeholder="Enter Option 1">
                                <input id="option_1_img" type="file" name="option_1_img" class="form-control"
                                    placeholder="Enter Option 1">
                                <div class="mt-2 form-check">
                                    <input id="correct_option_1" type="radio" name="correct_option" value="1"
                                        class="form-check-input" required>
                                    <label class="form-check-label" for="correct_option_1">Mark as Correct</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="option_2" class="form-label">Option 2</label>
                                <input id="option_2" type="text" name="option_2" class="mb-1 form-control"
                                    placeholder="Enter Option 2">
                                <input id="option_2_img" type="file" name="option_2_img" class="form-control"
                                    placeholder="Enter Option 2">
                                <div class="mt-2 form-check">
                                    <input id="correct_option_2" type="radio" name="correct_option" value="2"
                                        class="form-check-input" required>
                                    <label class="form-check-label" for="correct_option_2">Mark as Correct</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-lg-6 col-sm-12">
                                <label for="option_3" class="form-label">Option 3</label>
                                <input id="option_3" type="text" name="option_3" class="mb-1 form-control"
                                    placeholder="Enter Option 3">
                                <input id="option_3_img" type="file" name="option_3_img" class="form-control"
                                    placeholder="Enter Option 3">
                                <div class="mt-2 form-check">
                                    <input id="correct_option_3" type="radio" name="correct_option" value="3"
                                        class="form-check-input" required>
                                    <label class="form-check-label" for="correct_option_3">Mark as Correct</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <label for="option_4" class="form-label">Option 4</label>
                                <input id="option_4" type="text" name="option_4" class="mb-1 form-control"
                                    placeholder="Enter Option 4">
                                <input id="option_4_img" type="file" name="option_4_img" class="form-control"
                                    placeholder="Enter Option 4">
                                <div class="mt-2 form-check">
                                    <input id="correct_option_4" type="radio" name="correct_option" value="4"
                                        class="form-check-input" required>
                                    <label class="form-check-label" for="correct_option_4">Mark as Correct</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="batch-question">
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
                    <span class="text-danger text-center">Please ensure all images are exactly 400x250 pixels in
                        dimension.</span>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                    <div class="batch-question">
                        <a class="btn btn-primary" href="{{ route('admin.questions.downloadTemplate') }}">
                            Download Sample CSV
                        </a>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
