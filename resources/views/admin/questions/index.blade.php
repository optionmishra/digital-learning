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

        // Helper function to get element ID with form suffix
        function getElementId(baseId, formNumber) {
            return formNumber === 2 ? `${baseId}2` : baseId;
        }

        // Helper function to populate select options
        function populateSelect(selectElement, items, filterFn) {
            selectElement.innerHTML = '';
            if (items) {
                items.forEach(item => {
                    if (filterFn(item)) {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.name;
                        selectElement.appendChild(option);
                    }
                });
            }
        }

        function updateFormSelects(formNumber = null, updateType = 'all') {
            const getEl = (base) => document.getElementById(getElementId(base, formNumber));

            if (updateType === 'all' || updateType === 'books') {
                const subjectValue = getEl('subject').value;
                populateSelect(getEl('book'), books, book => book.subject_id == subjectValue);
            }

            if (updateType === 'all' || updateType === 'topics') {
                const bookValue = getEl('book').value;
                populateSelect(getEl('topic'), topics, topic => topic.book_id == bookValue);
            }

            if (updateType === 'all' || updateType === 'assessments') {
                const bookValue = getEl('book').value;
                populateSelect(getEl('assessment'), assessments, assessment => assessment.book_id == bookValue);
            }
        }

        const modalElement = document.querySelector(".modal");

        if (modalElement) {
            modalElement.addEventListener("shown.coreui.modal", function() {
                updateFormSelects();
            });
        }
    </script>
@endsection
