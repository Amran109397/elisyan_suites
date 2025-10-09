@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Loyalty Member</h3>
                    <div class="card-tools">
                        <a href="{{ route('loyalty-members.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('loyalty-members.update', $loyaltyMember->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guest_id">Guest <span class="text-danger">*</span></label>
                                    <select class="form-select @error('guest_id') is-invalid @enderror" id="guest_id" name="guest_id" required>
                                        <option value="">Select Guest</option>
                                        @foreach($guests as $guest)
                                            <option value="{{ $guest->id }}" {{ old('guest_id', $loyaltyMember->guest_id) == $guest->id ? 'selected' : '' }}>{{ $guest->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('guest_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loyalty_program_id">Loyalty Program <span class="text-danger">*</span></label>
                                    <select class="form-select @error('loyalty_program_id') is-invalid @enderror" id="loyalty_program_id" name="loyalty_program_id" required>
                                        <option value="">Select Program</option>
                                        @foreach($loyaltyPrograms as $loyaltyProgram)
                                            <option value="{{ $loyaltyProgram->id }}" {{ old('loyalty_program_id', $loyaltyMember->loyalty_program_id) == $loyaltyProgram->id ? 'selected' : '' }}>{{ $loyaltyProgram->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('loyalty_program_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="membership_number">Membership Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('membership_number') is-invalid @enderror" id="membership_number" name="membership_number" value="{{ old('membership_number', $loyaltyMember->membership_number) }}" required>
                                    @error('membership_number')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="join_date">Join Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('join_date') is-invalid @enderror" id="join_date" name="join_date" value="{{ old('join_date', $loyaltyMember->join_date) }}" required>
                                    @error('join_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $loyaltyMember->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Member</button>
                            <a href="{{ route('loyalty-members.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection