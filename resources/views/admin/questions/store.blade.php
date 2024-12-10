<div class="modal fade" id="questionStore" tabindex="-1" aria-labelledby="questionStoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="questionStoreLabel">Question Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.questions.store') }}" id="updateDataForm">
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
                    <div class="mb-3">
                        <label class="form-label" for="assessment">Assessment</label>
                        <select class="form-control" name="assessment_id" id="assessment">
                            @foreach ($books[0]->assessments as $assessment)
                                <option value="{{ $assessment->id }}">{{ $assessment->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="question_text">Question</label>
                        <input class="form-control" id="question_text" type="text" placeholder="Question"
                            name="question_text">
                    </div>
                    <div class="mb-3 row">
                        <div class="col-lg-6 col-sm-12">
                            <label for="option_1" class="form-label">Option 1</label>
                            <input id="option_1" type="text" name="option_1" class="form-control"
                                placeholder="Enter Option 1" required>
                            <div class="mt-2 form-check">
                                <input id="correct_option_1" type="radio" name="correct_option" value="1"
                                    class="form-check-input" required>
                                <label class="form-check-label" for="correct_option_1">Mark as Correct</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="option_2" class="form-label">Option 2</label>
                            <input id="option_2" type="text" name="option_2" class="form-control"
                                placeholder="Enter Option 2" required>
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
                            <input id="option_3" type="text" name="option_3" class="form-control"
                                placeholder="Enter Option 3" required>
                            <div class="mt-2 form-check">
                                <input id="correct_option_3" type="radio" name="correct_option" value="3"
                                    class="form-check-input" required>
                                <label class="form-check-label" for="correct_option_3">Mark as Correct</label>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label for="option_4" class="form-label">Option 4</label>
                            <input id="option_4" type="text" name="option_4" class="form-control"
                                placeholder="Enter Option 4" required>
                            <div class="mt-2 form-check">
                                <input id="correct_option_4" type="radio" name="correct_option" value="4"
                                    class="form-check-input" required>
                                <label class="form-check-label" for="correct_option_4">Mark as Correct</label>
                            </div>
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
