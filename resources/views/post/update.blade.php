@extends('layouts.app')

@section('content')
    <div class="container vh-100 d-flex justify-content-center align-items-center" style="background-color: white;">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Update Post</h1>
            <form action="{{ route('posts.update', $post->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <select class="form-select" aria-label="Default select example" name="category_id" id="category">
                        <option selected disabled>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if ($post->category_id == $category->id) selected @endif>
                                {{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter title" name="title"
                        value="{{ $post->title }}">
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3 mt-3">
                    <label for="content" class="form-label">Content:</label>
                    <textarea class="form-control" id="content" rows="4" placeholder="Enter content"
                        name="content">{{ $post->content }}</textarea>
                    @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="views" class="form-label">Views:</label>
                    <input type="number" class="form-control" id="views" placeholder="Enter views" name="views"
                        value="{{ $post->views }}">
                    @error('views')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS (optional, if you need it for other features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
