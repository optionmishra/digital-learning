@extends('layouts.admin')
@section('content')
    <div class="body flex-grow-1">
        <div class="container-lg px-4">
            <div class="row card mb-4">
                <div class="card-header">
                    <h5 class="card-title">{{ ucfirst($role->name) }}s</h5>
                </div>
                <div class="card-body table-responsive">
                    <table id="users-table" class="table-striped table-bordered table" data-table-route="{{ route('admin.users.datatable') }}">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">School Name</th>
                                <th scope="col">User Code</th>
                                <th scope="col">Mobile</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("admin.users.datatable") }}', 
            columns: [
                 { data: 'serial', name: 'serial' },
                 { data: 'school_name', name: 'school_name' },  
                 { data: 'user_code', name: 'user_code' },      
                 { data: 'mobile', name: 'mobile' },
                 { data: 'status', name: 'status' },
                 { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });
</script>
@endsection