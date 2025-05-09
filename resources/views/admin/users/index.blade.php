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
                                <th scope="col">School</th>
                                <th scope="col">Code</th>
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
