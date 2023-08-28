@extends('layouts.app')

@section('content')
    <div class="container mt-4" >
        <div id="output" class="alert alert-success" style="display: none;">
            Your data has been submitted successfully.
        </div>
        <div id="error-message" class="alert alert-danger" style="display: none;">
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4" style="color: black">Post Create</h1>
                <form action="{{ route('posts.store') }}" id="create-post">
                    @csrf
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category:</label>
                        <select class="form-select" aria-label="Default select example" name="category_id" id="category_id">
                            <option selected disabled>Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="title" class="form-label">Title:</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter title" name="title">
                        @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content:</label>
                        <textarea class="form-control" id="content" placeholder="Enter content" name="content" rows="5"></textarea>
                        @error('content')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="views" class="form-label">Views:</label>
                        <input type="number" class="form-control" id="views" placeholder="Enter views" name="views">
                        @error('views')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    @auth
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    @endauth

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, if you need it for other features) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#create-post').submit(function(event) {
                event.preventDefault();

                var form = $(this)[0];
                var formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('posts.store') }}",
                    data: formData,
                    processData: false, // Important: Don't process data, let jQuery handle it
                    contentType: false, // Important: Don't set content type (jQuery will set it automatically)
                    success: function(response) {
                        $("#output").text(response.res)
                            .show(); // Show the success message at the top

                        // Hide the success message after 3 seconds (3000 milliseconds)
                        setTimeout(function() {
                            $("#output").hide();
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = "An error occurred. Please try again later.";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            // Customize the error message based on the specific errors
                            if (errors.category_id) {
                                errorMessage = errors.category_id[0];
                            } else if (errors.title) {
                                errorMessage = errors.title[0];
                            } else if (errors.content) {
                                errorMessage = errors.content[0];
                            } else if (errors.views) {
                                errorMessage = errors.views[0];
                            }
                        }
                        $("#error-message").text(errorMessage).show();
                    }
                });
            });
        });
    </script>
@endsection
