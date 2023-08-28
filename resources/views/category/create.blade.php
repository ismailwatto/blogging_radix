@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Category Create</h1>
                <div id="output" class="alert alert-success" style="display: none;"></div>
                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                <form action="{{ route('category.store') }}" id="category-create" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
                        <!-- Display the error message for the name field -->
                        <div class="alert alert-danger" id="error-name" style="display: none;"></div>
                    </div>
                    <button type="submit" id="create" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, if you need it for other features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#category-create').submit(function(event) {
                event.preventDefault();

                var form = $(this)[0];
                var formData = new FormData(form);

                $.ajax({
                    type: 'POST',
                    url: "{{ route('category.store') }}",
                    data: formData,
                    processData: false, 
                    contentType: false, 
                    success: function(response) {
                        $("#output").text(response.res)
                            .show();

                        setTimeout(function() {
                            $("#output").hide();
                        }, 3000);
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            if (errors.name) {
                                $("#error-name").text(errors.name[0]).show();
                            } else {
                                $("#error-name").hide();
                            }
                        }
                    }
                });
            });
        });
        $('#create').click(function() {
            $(this).css('background-color', 'red');
        }).mouseleave(function() {
            $(this).css('background-color', '');
        });
    </script>
@endsection