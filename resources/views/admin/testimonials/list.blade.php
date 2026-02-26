@extends('admin.layouts.app')
@section('title', 'Testimonials List')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Testimonials List</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Testimonials List</li>
                </ol>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">Add New</a>
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
                            <th>Location</th>
                            <th>Testimonial Text</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonials as $t)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><b>{{ $t->client_name }}</b></td>
                                <td>
                                    @if (!$t->client_position)
                                        {{ 'N/A' }}
                                    @else
                                        {{ $t->client_position }}
                                    @endif
                                </td>
                                <td>

                                    {{-- Star Rating --}}
                                    @php
                                        // $rating = $t->client_rating ?? 0;
                                        // $fullStars = floor($rating);
                                        // $halfStar = $rating - $fullStars >= 0.5 ? true : false;
                                        // $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                    @endphp

                                    {{-- <div class="star-rating text-warning mb-1">
                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <i class="fas fa-star"></i>
                                        @endfor

                                        @if ($halfStar)
                                            <i class="fas fa-star-half-alt"></i>
                                        @endif

                                        @for ($i = 0; $i < $emptyStars; $i++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </div> --}}

                                    {{ Str::limit($t->testimonial_text, 100) }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($t->created_at)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.testimonials.edit', $t->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.testimonials.destroy', $t->id) }}" method="POST"
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
