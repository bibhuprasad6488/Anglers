@extends('admin.layouts.app')
@section('title', 'Price Categoy Lists')
@section('content')
    <div class="container-fluid px-4">

        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Price Categoy Lists</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Price Categories</li>
                </ol>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.price-categories.create') }}" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            @if (session('success'))
                <div class="alert alert-success mx-4 mt-3 rounded-3 shadow-sm" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger mx-4 mt-3 rounded-3 shadow-sm" id="success-alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">

                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($priceCategories as $pc)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><b>{{ $pc->name }}</b></td>
                                <td>{{ $pc->desctiption }}</td>
                                <td>{{ \Carbon\Carbon::parse($pc->created_at)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.price-categories.edit', $pc->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.price-categories.destroy', $pc->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function editCategory(id, slNo, updateUrl) {
            fetch(`/admin/price-categories/${id}/edit`)
                .then(response => response.json())
                .then(data => {

                    document.getElementById('name').value = data.name;

                    const form = document.getElementById('categoryForm');

                    // Update action URL
                    form.setAttribute('action', updateUrl);
                    form.setAttribute('method', 'POST');

                    // Ensure _method = PUT
                    let methodInput = form.querySelector('input[name="_method"]');
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        form.appendChild(methodInput);
                    }
                    methodInput.value = 'PUT';

                    console.log('Form action:', form.action);
                    console.log('Method input:', methodInput);
                })
                .catch(error => {
                    console.error('Error fetching category data:', error);
                });
        }
    </script>
@endpush
