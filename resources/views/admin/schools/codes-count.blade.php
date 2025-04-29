<div class="d-flex justify-content-center">
    <button class="btn btn-success rounded-full px-2 py-1" type="button" title="Show Codes" data-coreui-toggle="modal"
        data-coreui-target="#codeModal"
        data-codes-route="{{ route('admin.schools.codesTable', [$school->id, $role->id]) }}">
        {{ $school->codes()->where('role_id', $role->id)->count() }}
    </button>
</div>
