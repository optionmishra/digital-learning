<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resetPasswordModalLabel">
                    Are you sure you want to reset password?
                </h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="resetPassword">
                @csrf
                <div class="modal-body d-flex justify-content-center">
                    <div class="d-flex flex-column">
                        <svg class="text-danger">
                            <use
                                xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-loop-circular') }}">
                            </use>
                        </svg>
                        <p class="fs-3 text-danger my-2 text-center">
                            This will set the user's email as their new password.
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
