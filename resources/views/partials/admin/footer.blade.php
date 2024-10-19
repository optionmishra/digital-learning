<footer class="px-4 footer">
    {{-- <div><a href="https://coreui.io">CoreUI </a><a
            href="https://coreui.io/product/free-bootstrap-admin-template/">Bootstrap Admin Template</a> © 2024
        creativeLabs.</div>
    <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/docs/">CoreUI UI Components</a></div> --}}
</footer>


<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    Are you sure you want to delete?
                </h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body d-flex justify-content-center">
                    <div class="d-flex flex-column">
                        <svg class="text-danger">
                            <use xlink:href="{{ asset('coreui/vendors/@coreui/icons/svg/free.svg#cil-trash') }}"></use>
                        </svg>
                        <p class="my-2 text-center fs-3 text-danger">
                            You won't be able to revert this!
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-coreui-dismiss="modal">
                        Close
                    </button>
                    <button class="btn btn-primary" type="button" data-coreui-dismiss="modal" id="confirmDeleteBtn">
                        Confirm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
