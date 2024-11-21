<div class="d-flex">
    <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center edit-btn" type="button" title="Edit"
        data-coreui-toggle="modal" data-coreui-target="#boardStore" data-update-route="{{ route('admin.boards.store') }}"
        data-row-data="{{ json_encode(['id' => $board->id, 'name' => $board->name]) }}">
        <svg class="icon icon-lg text-primary">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
            </use>
        </svg>
    </button>
    <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Delete"
        data-coreui-toggle="modal" data-coreui-target="#deleteModal"
        data-delete-route="{{ route('admin.boards.destroy', $board->id) }}">
        <svg class="icon icon-lg text-danger">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
            </use>
        </svg>
    </button>
</div>
