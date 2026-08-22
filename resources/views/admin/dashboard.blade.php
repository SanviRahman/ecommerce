@extends('layouts.admin')

@section('meta_title', $title)

@section('content')
    @php
        $routeUrl = static fn (string $name): string => \Illuminate\Support\Facades\Route::has($name)
            ? route($name)
            : '#';
    @endphp

    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format($stats['products']) }}</h3>
                    <p>Products <small>({{ number_format($stats['active_products']) }} active)</small></p>
                </div>
                <div class="icon"><i class="fas fa-box-open"></i></div>
                <a href="{{ $routeUrl('admin.products.index') }}" class="small-box-footer">
                    Manage Products <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ number_format($stats['categories']) }}</h3>
                    <p>Categories <small>({{ number_format($stats['active_categories']) }} active)</small></p>
                </div>
                <div class="icon"><i class="fas fa-tags"></i></div>
                <a href="{{ $routeUrl('admin.categories.index') }}" class="small-box-footer">
                    Manage Categories <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($stats['reviews']) }}</h3>
                    <p>Reviews <small>({{ number_format($stats['active_reviews']) }} active)</small></p>
                </div>
                <div class="icon"><i class="fas fa-star"></i></div>
                <a href="{{ $routeUrl('admin.reviews.index') }}" class="small-box-footer">
                    Manage Reviews <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ number_format($stats['new_messages']) }}</h3>
                    <p>New Messages <small>({{ number_format($stats['contact_messages']) }} total)</small></p>
                </div>
                <div class="icon"><i class="fas fa-envelope"></i></div>
                <a href="{{ $routeUrl('admin.contact-messages.index') }}" class="small-box-footer">
                    View Messages <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-images"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Home Photos</span>
                    <span class="info-box-number">{{ number_format($stats['active_home_photos']) }} / {{ number_format($stats['home_photos']) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-secondary"><i class="fas fa-bullseye"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active Pixels</span>
                    <span class="info-box-number">{{ number_format($stats['active_pixels']) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-purple"><i class="fas fa-certificate"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Featured Products</span>
                    <span class="info-box-number">{{ number_format($stats['featured_products']) }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-dark"><i class="fas fa-photo-video"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Media Library</span>
                    <span class="info-box-number">{{ number_format($stats['media_files']) }} files · {{ $mediaUsage }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-envelope-open-text mr-2"></i>Recent Contact Messages</h3>
                    <div class="card-tools">
                        <a href="{{ $routeUrl('admin.contact-messages.index') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Received</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMessages as $message)
                                @php
                                    $badge = match ($message->status) {
                                        'new' => 'badge-danger',
                                        'in_progress' => 'badge-warning',
                                        'resolved' => 'badge-success',
                                        default => 'badge-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $message->name }}</strong>
                                        @if($message->subject)
                                            <div class="small text-muted">{{ \Illuminate\Support\Str::limit($message->subject, 38) }}</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $message->email ?: '—' }}</div>
                                        <div class="small text-muted">{{ $message->phone ?: '—' }}</div>
                                    </td>
                                    <td><span class="badge {{ $badge }}">{{ ucwords(str_replace('_', ' ', $message->status)) }}</span></td>
                                    <td>{{ optional($message->created_at)->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No contact messages yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-boxes mr-2"></i>Recent Products</h3>
                    <div class="card-tools">
                        <a href="{{ $routeUrl('admin.products.index') }}" class="btn btn-sm btn-success">View All</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @forelse($recentProducts as $product)
                            <li class="item">
                                <div class="product-info ml-2">
                                    <a href="{{ $routeUrl('admin.products.index') }}" class="product-title">
                                        {{ $product->name }}
                                        <span class="badge {{ $product->status ? 'badge-success' : 'badge-secondary' }} float-right">
                                            {{ $product->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </a>
                                    <span class="product-description">
                                        {{ $product->category?->name ?: 'Uncategorized' }} · {{ optional($product->created_at)->diffForHumans() }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="item text-center text-muted py-4">No products yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-server mr-2"></i>Media / Deployment Status</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Average Review Rating</span>
                        <strong>{{ number_format($stats['average_rating'], 1) }}/5</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Public Media URL</span>
                        <strong class="text-right text-break ml-3">{{ $publicMediaUrl }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Storage Doctor</span>
                        @if(\Illuminate\Support\Facades\Route::has('command.media-storage-doctor'))
                            <a href="{{ route('command.media-storage-doctor') }}" class="btn btn-xs btn-outline-secondary">Run Check</a>
                        @else
                            <span class="badge badge-secondary">CLI only</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
