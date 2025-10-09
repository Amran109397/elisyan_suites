@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Promo Codes</h3>
                    <div class="card-tools">
                        <a href="{{ route('promocodes.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Promo Code
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Discount Type</th>
                                <th>Discount Value</th>
                                <th>Usage</th>
                                <th>Validity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promoCodes as $promoCode)
                            <tr>
                                <td><strong>{{ $promoCode->code }}</strong></td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst(str_replace('_', ' ', $promoCode->discount_type)) }}
                                    </span>
                                </td>
                                <td>
                                    @if($promoCode->discount_type == 'percentage')
                                        {{ $promoCode->discount_value }}%
                                    @else
                                        {{ number_format($promoCode->discount_value, 2) }}
                                    @endif
                                </td>
                                <td>
                                    @if($promoCode->max_uses)
                                        {{ $promoCode->used_count }} / {{ $promoCode->max_uses }}
                                    @else
                                        {{ $promoCode->used_count }} / ∞
                                    @endif
                                </td>
                                <td>
                                    {{ $promoCode->valid_from->format('d M Y') }} - {{ $promoCode->valid_until->format('d M Y') }}
                                    @if($promoCode->valid_until < now())
                                        <span class="badge bg-danger ms-1">Expired</span>
                                    @endif
                                </td>
                                <td>
                                    @if($promoCode->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('promocodes.show', $promoCode->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('promocodes.edit', $promoCode->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('promocodes.toggle-active', $promoCode->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $promoCode->is_active ? 'btn-warning' : 'btn-success' }}" title="{{ $promoCode->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fas {{ $promoCode->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('promocodes.destroy', $promoCode->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection