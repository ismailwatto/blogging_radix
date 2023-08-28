@extends('layouts.app')

@section('content')
    <div class="container-fluid d-flex justify-content-center align-items-center mt-4">
        <div class="container">
            <h1 class="text-center mb-4">Categories List</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="text-center">Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td class="text-center">{{ $category->name }}</td>
                            <td>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-success">
                                    <i class="fa fa-edit"></i> <!-- Edit icon -->
                                </a>
                                <a href="{{ route('category.destroy', $category->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fa fa-trash"></i> <!-- Delete icon -->
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS (optional, if you need it for other features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection