@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guest Preference Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('guest-preferences.edit', $guestPreference->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('guest-preferences.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Guest:</strong> {{ $guestPreference->guest->full_name }}</p>
                            <p><strong>Preference Type:</strong> {{ $guestPreference->preference_type }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Preference Value:</strong> {{ $guestPreference->preference_value }}</p>
                        </div>
                    </div>
                    @if($guestPreference->notes)
                    <div class="mt-3">
                        <h5>Notes</h5>
                        <p>{{ $guestPreference->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection