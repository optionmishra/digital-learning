<div class="d-flex">
    <button class="btn btn-link nav-link d-flex align-items-center edit-btn px-2 py-2" type="button" title="Edit"
        data-coreui-toggle="modal" data-coreui-target="#topicStore" data-update-route="{{ route('admin.topics.store') }}"
        data-row-data="{{ json_encode(['id' => $topic->id, 'name' => $topic->name, 'subject_id' => $topic->subject_id, 'book_id' => $topic->book_id, 'serial' => $topic->serial]) }}">
        <svg class="icon icon-lg text-primary">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
            </use>
        </svg>
    </button>
    <button class="btn btn-link nav-link d-flex align-items-center px-2 py-2" type="button" title="Delete"
        data-coreui-toggle="modal" data-coreui-target="#deleteModal"
        data-delete-route="{{ route('admin.topics.destroy', $topic->id) }}">
        <svg class="icon icon-lg text-danger">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
            </use>
        </svg>
    </button>
</div>
