@extends('layouts.admin')

@section('content')
    <div class="body flex-grow-1">
        <div class="container-lg px-4">
            <div class="row card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Topics</h5>
                        <button class="btn btn-primary px-2 py-2" type="button" title="Edit" data-coreui-toggle="modal"
                            data-coreui-target="#topicStore">Create</button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-striped table-bordered table"
                        data-table-route="{{ route('admin.topics.datatable') }}">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Serial No.</th>
                                <th scope="col">Name</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Book</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.topics.store')
@endsection
@section('bottom-scripts')
    <script>
        const books = @json($books);

        function updateBooks() {
            // const standard = document.getElementById("standard").value;
            const subject = document.getElementById("subject").value;
            const bookSelect = document.getElementById("book");

            // Clear previous options
            bookSelect.innerHTML = '';

            if (subject && books) {
                // Populate book options based on selected class and subject
                books.forEach(book => {
                    if (book.subject_id == subject) {
                        const option = document.createElement("option");
                        option.value = book.id;
                        option.textContent = book.name;
                        bookSelect.appendChild(option);
                    }
                });
            }
        }

        const modalElement = document.querySelector(".modal");

        if (modalElement) {
            modalElement.addEventListener("shown.coreui.modal", function() {
                updateBooks();
            });
        }
    </script>
@endsection
