@extends('admin.layouts.app')
@section('title', 'Will Details')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Will Details</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Will Details</li>
                </ol>
            </div>
            <div class="ms-auto d-none">
                <div class="btn-group">
                    <a href="{{ route('admin.pricings.create') }}" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 my-2 ">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3><i class="my-1 fa fa-tasks me-2"></i>Want to Setup</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @if (in_array('will', $will->setup_array))
                                <li class="detail-item">
                                    <i class="my-1 fa fa-check-circle"></i>
                                    <span>A Will</span>
                                </li>
                            @endif

                            @if (in_array('lpa', $will->setup_array))
                                <li class="detail-item">
                                    <i class="my-1 fa fa-check-circle"></i>
                                    <span>A Lasting Power of Attorney</span>
                                </li>
                            @endif

                            @if (in_array('trust', $will->setup_array))
                                <li class="detail-item">
                                    <i class="my-1 fa fa-check-circle"></i>
                                    <span>A Trust</span>
                                </li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-md-6 my-2 ">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3><i class="my-1 fa fa-cubes me-2"></i>Assets</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @if (in_array('savings', $will->assets_array))
                                <li class="detail-item">
                                    <i class="my-1 fa fa-piggy-bank"></i>
                                    Savings or Investments
                                </li>
                            @endif

                            @if (in_array('property', $will->assets_array))
                                <li class="detail-item">
                                    <i class="my-1 fa fa-building"></i>
                                    Property
                                </li>
                            @endif

                            @if (in_array('business', $will->assets_array))
                                <li class="detail-item">
                                    <i class="my-1 fa fa-briefcase"></i>
                                    Business
                                </li>
                            @endif
                        </ul>

                        @if (empty($will->assets_array))
                            <div class="detail-muted">
                                No asset information provided.
                            </div>
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-md-6 my-2 ">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3><i class="my-1 fa fa-user me-2"></i>Personal Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-muted small">Full Name</div>
                            <div class="fw-semibold fs-5">{{ $will->full_name }}</div>
                        </div>

                        <div class="mb-3">
                            <div class="text-muted small">Email</div>
                            <div class="fw-semibold">{{ $will->email }}</div>
                        </div>

                        <div>
                            <div class="text-muted small">Postal Code</div>
                            <div class="fw-semibold">{{ $will->postcode }}</div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 my-2 ">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3><i class="my-1 fa fa-info-circle me-2"></i>Useful Information</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            @if ($will->confirm_england === 'yes')
                                <li class="detail-item">
                                    <i class="my-1 fa fa-angle-right"></i>
                                    I live in England or Wales
                                </li>
                            @endif

                            @if ($will->confirm_self === 'yes')
                                <li class="detail-item">
                                    <i class="my-1 fa fa-angle-right"></i>
                                    I am completing this for myself
                                </li>
                            @endif

                            @if ($will->confirm_no_advice === 'yes')
                                <li class="detail-item">
                                    <i class="my-1 fa fa-angle-right"></i>
                                    I understand this is not legal advice
                                </li>
                            @endif

                            @if ($will->confirm_free_will === 'yes')
                                <li class="detail-item">
                                    <i class="my-1 fa fa-angle-right"></i>
                                    I am doing this of my own free will
                                </li>
                            @endif
                        </ul>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <a href="{{ route('admin.wills.list') }}" class="btn btn-secondary">  Back</a>
            </div>
        </div>
    </div>

    <style>
        .detail-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 6px 0;
            font-size: 0.95rem;
        }

        .detail-item i {
            color: #0d6efd;
            margin-top: 2px;
        }

        .detail-muted {
            color: #6c757d;
            font-style: italic;
        }

        .card {
            box-shadow: 0px 15px 13px 2px #6c757d;
        }
    </style>
@endsection
