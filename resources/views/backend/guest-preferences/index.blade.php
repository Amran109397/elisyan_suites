@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guest Preferences</h3>
                    <div class="card-tools">
                        <a href="{{ route('guest-preferences.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Preference
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Preference Type</th>
                                <th>Preference Value</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guestPreferences as $guestPreference)
                            <tr>
                                <td>{{ $guestPreference->guest->full_name }}</td>
                                <td>{{ $guestPreference->preference_type }}</td>
                                <td>{{ $guestPreference->preference_value }}</td>
                                <td>
                                    <a href="{{ route('guest-preferences.show', $guestPreference->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('guest-preferences.edit', $guestPreference->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('guest-preferences.destroy', $guestPreference->id) }}" method="POST" style="display: inline;">
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