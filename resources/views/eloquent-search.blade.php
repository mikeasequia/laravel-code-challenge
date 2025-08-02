@extends('index')

@section('childContent')
    <div class="container">
        <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-body">
                        <h2>Eloquent Nested Search</h2>
                        <form method="GET" action="{{ route('eloquent-search') }}">
                            <div class="mb-3">
                                <label for="filters" class="form-label">Filters (JSON)</label>
                                <textarea class="form-control" id="filters" name="filters" rows="5" placeholder='{"user.name": "Staff User", "state": "draft", "location.city": "CDO"}'></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>

                        @if(isset($results))
                            <h4 class="mt-4">Results</h4>
                            <pre>{{ json_encode($results, JSON_PRETTY_PRINT) }}</pre>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection