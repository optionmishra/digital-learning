<div class="modal fade" id="booksModal" tabindex="-1" aria-labelledby="booksModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="booksModalLabel">
                    User's Books
                </h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="updateDataForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        @foreach (App\Models\Book::all() as $book)
                            <div class="col-lg-4 col-sm-12 mb-3">
                                <input type="checkbox" name="books[]" id="book_{{ $book->id }}"
                                    value="{{ $book->id }}" class="form-check-input mx-1">
                                <label class="form-check-label"
                                    for="book_{{ $book->id }}">{{ $book->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-coreui-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-primary" type="submit">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
