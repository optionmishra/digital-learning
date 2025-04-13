<div class="d-flex">
    <button class="btn btn-link nav-link d-flex align-items-center edit-btn px-2 py-2" type="button" title="Edit"
        data-coreui-toggle="modal" data-coreui-target="#seriesStore" data-update-route="{{ route('admin.series.store') }}"
        data-row-data="{{ json_encode(['id' => $series->id, 'name' => $series->name]) }}">
        <svg class="icon icon-lg text-primary">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-pencil') }}">
            </use>
        </svg>
    </button>
    <button class="btn btn-link nav-link d-flex align-items-center px-2 py-2" type="button" title="Delete"
        data-coreui-toggle="modal" data-coreui-target="#deleteModal"
        data-delete-route="{{ route('admin.series.destroy', $series->id) }}">
        <svg class="icon icon-lg text-danger">
            <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
            </use>
        </svg>
    </button>
</div>
