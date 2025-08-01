@extends('layouts.admin')

@section('content')
    <div class="body flex-grow-1">
        <div class="px-4 container-lg">
            <div class="mb-4 row card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Assessments</h5>
                        <button class="px-2 py-2 btn btn-primary" type="button" title="Edit" data-coreui-toggle="modal"
                            data-coreui-target="#assessmentStore">Create</button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-bordered"
                        data-table-route="{{ route('admin.assessments.datatable') }}">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Standard</th>
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
    @include('admin.assessments.store')
@endsection

@section('bottom-scripts')
    <script>
        const books = @json($books);

        function updateBooks() {
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
        }

        const modalElement = document.querySelector(".modal");

        if (modalElement) {
            modalElement.addEventListener("shown.coreui.modal", function() {
                updateBooks();
            });
        }
    </script>
@endsection
