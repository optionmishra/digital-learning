@extends('layouts.admin')

@section('content')
    <div class="body flex-grow-1">
        <div class="container-lg px-4">
            <div class="row card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">{{ $contentType->name }}s</h5>
                        <button class="btn btn-primary px-2 py-2" type="button" title="Edit" data-coreui-toggle="modal"
                            data-coreui-target="#contentStore">Create</button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-striped table-bordered table"
                        data-table-route="{{ route('admin.contents.datatable') }}">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Image</th>
                                <th scope="col">Tags</th>
                                <th scope="col">URL</th>
                                @if ($contentType->name == 'Video')
                                    <th scope="col">Creator</th>
                                    <th scope="col">Duration</th>
                                @elseif ($contentType->name == 'Ebook')
                                    <th scope="col">Price</th>
                                    <th scope="col">About</th>
                                @endif
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.contents.store')
@endsection
@section('bottom-scripts')
    {{-- @vite(['resources/js/quill.js']) --}}
    <script>
        const books = @json($books);
        const topics = @json($topics);

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
        }

        const modalElement = document.querySelector(".modal");

        if (modalElement) {
            modalElement.addEventListener("shown.coreui.modal", function() {
                updateFormSelects();
            });
        }
    </script>
@endsection
