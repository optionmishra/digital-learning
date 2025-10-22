<div class="d-flex">
    <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center edit-btn" type="button" title="Edit"
        data-coreui-toggle="modal" data-coreui-target="#bookStore" data-update-route="{{ route('admin.books.store') }}"
        data-row-data="{{ json_encode(['id' => $book->id, 'name' => $book->name, 'about' => $book->about, 'board_id' => $book->board?->id, 'standard_id' => $book->standard?->id, 'subject_id' => $book->subject?->id, 'author_id' => $book->author?->id]) }}">
        <svg class="icon icon-lg text-primary">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
            </use>
        </svg>
    </button>
    <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Delete"
        data-coreui-toggle="modal" data-coreui-target="#deleteModal"
        data-delete-route="{{ route('admin.books.destroy', $book->id) }}">
        <svg class="icon icon-lg text-danger">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
            </use>
        </svg>
    </button>
</div>
