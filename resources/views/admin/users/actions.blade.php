@if (!$user->hasRole('admin'))
    <div class="d-flex">
        <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Reset Password"
            data-btn-route="{{ route('admin.users.reset.password', $user->id) }}">
            <svg class="icon icon-lg text-danger">
                <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-loop-circular') }}">
                </use>
            </svg>
        </button>
        <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Delete"
            data-coreui-toggle="modal" data-coreui-target="#deleteModal"
            data-delete-route="{{ route('admin.users.destroy', $user->id) }}">
            <svg class="icon icon-lg text-danger">
                <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}">
                </use>
            </svg>
        </button>
    </div>
@endif
