@extends('layouts.admin')

@section('content')
    <div class="body flex-grow-1">
        <div class="container-lg px-4">
            <div class="row card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Schools</h5>
                        <button class="btn btn-primary px-2 py-2" type="button" title="Edit" data-coreui-toggle="modal"
                            data-coreui-target="#schoolStore">Create</button>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table-striped table-bordered table"
                        data-table-route="{{ route('admin.schools.datatable') }}">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col">Teacher Code</th>
                                <th scope="col">Student Code</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.schools.store')
@endsection
