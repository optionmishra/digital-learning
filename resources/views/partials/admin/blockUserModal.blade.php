<div class="modal fade" id="blockModal" tabindex="-1" aria-labelledby="blockModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="blockModalLabel">
                    Are you sure you want to block this user?
                </h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="blockUser">
                @csrf
                <div class="modal-body d-flex justify-content-center">
                    <div class="d-flex flex-column">
                        <svg class="text-danger">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-x-circle') }}">
                            </use>
                        </svg>
                        <p class="fs-3 text-danger my-2 text-center">
                            This user will be blocked and will no longer be able to access the platform until the block
                            is removed.
                        </p>
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
