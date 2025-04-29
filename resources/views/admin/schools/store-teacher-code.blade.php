<div class="modal fade" id="teacherCodeStore" tabindex="-1" aria-labelledby="teacherCodeStoreLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="teacherCodeStoreLabel">Teacher Code Details</h5>
                <button class="btn-close" type="button" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.schools.code.store', $roles['teacher']) }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="teacherStandard">School *</label>
                        <select class="form-control" name="school" id="teacherStandard" required>
                            @foreach ($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="standards">Standards *</label>
                        <div class="d-flex flex-wrap gap-3">
                            @foreach ($standards as $standard)
                                <div class="d-flex gap-1">
                                    <input class="form-check" type="checkbox" name="standards[]"
                                        id="teacherStandard{{ $standard->id }}" value="{{ $standard->id }}">
                                    <label for="teacherStandard{{ $standard->id }}">{{ $standard->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-coreui-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
