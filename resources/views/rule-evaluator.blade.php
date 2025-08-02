<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Permissions Test</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">User Permissions Test</h4>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>