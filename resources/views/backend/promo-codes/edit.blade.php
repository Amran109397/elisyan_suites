@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Promo Code</h3>
                    <div class="card-tools">
                        <a href="{{ route('promocodes.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('promocodes.update', $promoCode->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Promo Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" name="code" value="{{ old('code', $promoCode->code) }}" placeholder="e.g., SUMMER2023" required>
                                    @error('code')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount_type">Discount Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="percentage" {{ old('discount_type', $promoCode->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                        <option value="free_night" {{ old('discount_type') == 'free_night' ? 'selected' : '' }}>Free Night</option>
                                    </select>
                                    @error('discount_type')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="discount_value">Discount Value <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        @if(old('discount_type', $promoCode->discount_type) == 'percentage')
                                            <input type="number" class="form-control @error('discount_value') is-invalid @enderror" id="discount_value" name="discount_value" value="{{ old('discount_value', $promoCode->discount_value) }}" step="0.01" min="0" max="100" required>
                                            <span class="input-group-text">%</span>
                                        @else
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control @error('discount_value') is-invalid @enderror" id="discount_value" name="discount_value" value="{{ old('discount_value', $promoCode->discount_value) }}" step="0.01" min="0" required>
                                        @endif
                                    </div>
                                    @error('discount_value')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="max_uses">Max Uses</label>
                                    <input type="number" class="form-control @error('max_uses') is-invalid @enderror" id="max_uses" name="max_uses" value="{{ old('max_uses', $promoCode->max_uses) }}" min="1">
                                    @error('max_uses')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="valid_from">Valid From <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('valid_from') is-invalid @enderror" id="valid_from" name="valid_from" value="{{ old('valid_from', $promoCode->valid_from->format('Y-m-d')) }}" required>
                                    @error('valid_from')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="valid_until">Valid Until <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('valid_until') is-invalid @enderror" id="valid_until" name="valid_until" value="{{ old('valid_until', $promoCode->valid_until->format('Y-m-d')) }}" required>
                                    @error('valid_until')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input @error('is_active') is-invalid @enderror" type="checkbox" id="is_active" name="is_active" {{ old('is_active', $promoCode->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                            @error('is_active')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Promo Code</button>
                            <a href="{{ route('promocodes.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection