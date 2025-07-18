@extends('layouts.admin')

@section('content')
    <div class="body flex-grow-1">
        <div class="px-4 container-lg">
            <div class="mb-4 row card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Questions</h5>
                        <div>
                            <button class="px-2 py-2 btn btn-primary" type="button" title="Edit" data-coreui-toggle="modal"
                                data-coreui-target="#questionStore">Create</button>
                            <button class="px-2 py-2 btn btn-primary" type="button" title="Edit"
                                data-coreui-toggle="modal" data-coreui-target="#questionStoreBatch">Create Multiple</button>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered"
                        data-table-route="{{ route('admin.questions.datatable') }}">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Book</th>
                                <th scope="col">Topic</th>
                                <th scope="col">Assessment</th>
                                <th scope="col">Question</th>
                                <th scope="col">Option_1</th>
                                <th scope="col">Option_2</th>
                                <th scope="col">Option_3</th>
                                <th scope="col">Option_4</th>
                                <th scope="col">Answer</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.questions.store')
    @include('admin.questions.store-batch')
@endsection
@section('bottom-scripts')
    <script>
        const books = @json($books);
        const topics = @json($topics);
        const assessments = @json($assessments);

        function updateBooks() {
            const subject = document.getElementById("subject").value;
            const bookSelect = document.getElementById("book");

            bookSelect.innerHTML = '';
            if (subject && books) {
                books.forEach(book => {
                    if (book.subject_id == subject) {
                        const option = document.createElement("option");
                        option.value = book.id;
                        option.textContent = book.name;
                        bookSelect.appendChild(option);
                    }
                });
            }
            updateTopics();
            updateAssessments();
        }

        function updateTopics() {
            const book = document.getElementById("book").value;
            const topicSelect = document.getElementById("topic");
            topicSelect.innerHTML = '';
            if (book && topics) {
                topics.forEach(topic => {
                    if (topic.book_id == book) {
                        const option = document.createElement("option");
                        option.value = topic.id;
                        option.textContent = topic.name;
                        topicSelect.appendChild(option);
                    }
                });
            }
        }

        function updateAssessments() {
            const book = document.getElementById("book").value;
            const assessmentSelect = document.getElementById("assessment");
            assessmentSelect.innerHTML = '';
            if (book && assessments) {
                assessments.forEach(assessment => {
                    if (assessment.book_id == book) {
                        const option = document.createElement("option");
                        option.value = assessment.id;
                        option.textContent = assessment.name;
                        assessmentSelect.appendChild(option);
                    }
                });
            }
        }
    </script>
@endsection
