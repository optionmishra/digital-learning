@if (!$user->hasRole('admin'))
    <div class="d-flex">
        <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Reset Password"
            data-coreui-toggle="modal" data-coreui-target="#resetPasswordModal"
            data-btn-route="{{ route('admin.users.reset.password', $user->id) }}" data-form="resetPassword">
            <svg class="icon icon-lg text-danger">
                <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-loop-circular') }}">
                </use>
            </svg>
        </button>
        @if ($user->profile->status == 'approved')
            <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Reject"
                data-coreui-toggle="modal" data-coreui-target="#blockModal"
                data-btn-route="{{ route('admin.users.reject', $user->id) }}" data-form="blockUser">
                <svg class="icon icon-lg text-danger">
                    <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-x-circle') }}">
                    </use>
                </svg>
            </button>
        @else
            <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Approve"
                data-coreui-toggle="modal" data-coreui-target="#booksModal"
                data-update-route="{{ route('admin.users.approve', $user->id) }}"
                data-row-data="{{ json_encode(['books[]' => $user->booksIdArr]) }}">
                <svg class="icon icon-lg text-success">
                    <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-check') }}">
                    </use>
                </svg>
            </button>
        @endif
        <button class="px-2 py-2 btn btn-link nav-link d-flex align-items-center" type="button" title="Extend Trial"
            data-coreui-toggle="modal" data-coreui-target="#extendTrialModal"
            data-btn-route="{{ route('admin.users.extend.trial', $user->id) }}" data-form="extendTrialForm">
            <svg class="icon icon-lg text-primary">
                <use xlink:href="{{ url('coreui/vendors/@coreui/icons/svg/free.svg#cil-clock') }}">
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
