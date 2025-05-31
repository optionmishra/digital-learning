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

        function updateBooks() {
            console.log('update books');
            const standard = document.getElementById("standard").value;
            const subject = document.getElementById("subject").value;
            const bookSelect = document.getElementById("book");

            // Clear previous options
            bookSelect.innerHTML = '';

            if (standard && subject && books) {
                // Populate book options based on selected class and subject
                books.forEach(book => {
                    if (book.standard_id == standard && book.subject_id == subject) {
                        const option = document.createElement("option");
                        option.value = book.id;
                        option.textContent = book.name;
                        bookSelect.appendChild(option);
                    }
                });
            }
            updateTopics();
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

        const modalElement = document.querySelector(".modal");

        if (modalElement) {
            modalElement.addEventListener("show.coreui.modal", function() {
                updateBooks();
            });
        }
    </script>
@endsection
