<div class="modal fade" id="extendTrialModal" tabindex="-1" aria-labelledby="extendTrialModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="extendTrialModalLabel">
                    Extend Trial Period
                </h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="extendTrialForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="extendDays">Extend by</label>
                        <div class="input-group">
                            <input class="form-control" type="number" name="days" id="extendDays" value="7">
                            <span class="input-group-text">days</span>
                        </div>
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
