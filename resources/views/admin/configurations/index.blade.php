@extends('layouts.admin')

@section('content')
    <div class="body flex-grow-1">
        <div class="px-4 container-lg">
            <form action="{{ route('admin.configurations.store') }}" method="POST">
                @csrf
                <div class="mb-4 row card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Configurations</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 row">
                            <div class="col-md-4 col-sm-12">
                                <label for="series" class="form-label">Series</label>
                                <select class="form-select" name="series" id="series">
                                    <option value="">Select Status</option>
                                    <option value="true" {{ ($configs->series ?? null) == 'true' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="false" {{ ($configs->series ?? null) == 'false' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <label for="author" class="form-label">Author</label>
                                <select class="form-select" name="author" id="author">
                                    <option value="">Select Status</option>
                                    <option value="true" {{ ($configs->author ?? null) == 'true' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="false" {{ ($configs->author ?? null) == 'false' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <label for="olympiad" class="form-label">Olympiad</label>
                                <select class="form-select" name="olympiad" id="olympiad">
                                    <option value="">Select Status</option>
                                    <option value="true" {{ ($configs->olympiad ?? 'true') == 'true' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="false"
                                        {{ ($configs->olympiad ?? 'true') == 'false' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="aboutus" class="form-label">About Us</label>
                            <textarea class="form-control" id="aboutus" name="aboutus" rows="10">{{ $configs->aboutus ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
