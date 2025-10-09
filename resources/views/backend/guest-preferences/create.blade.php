@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Guest Preference</h3>
                    <div class="card-tools">
                        <a href="{{ route('guest-preferences.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('guest-preferences.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="guest_id">Guest <span class="text-danger">*</span></label>
                            <select class="form-select @error('guest_id') is-invalid @enderror" id="guest_id" name="guest_id" required>
                                <option value="">Select Guest</option>
                                @foreach($guests as $guest)
                                    <option value="{{ $guest->id }}">{{ $guest->full_name }}</option>
                                @endforeach
                            </select>
                            @error('guest_id')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="preference_type">Preference Type <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('preference_type') is-invalid @enderror" id="preference_type" name="preference_type" value="{{ old('preference_type') }}" required>
                                    @error('preference_type')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="preference_value">Preference Value <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('preference_value') is-invalid @enderror" id="preference_value" name="preference_value" value="{{ old('preference_value') }}" required>
                                    @error('preference_value')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Preference</button>
                            <a href="{{ route('guest-preferences.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection