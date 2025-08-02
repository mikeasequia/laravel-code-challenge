@extends('index')

@section('childContent')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Dynamic Rule Engine</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('evaluator.submit') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">User</label>
                                <select name="user_id" class="form-select">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Action</label>
                                <select name="action" class="form-select">
                                    <option value="submit_form">Submit Form</option>
                                    <option value="create_content">Create Content</option>
                                    <option value="delete_content">Delete Content</option>
                                    <option value="view_reports">View Reports</option>
                                </select>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Test Permission</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection