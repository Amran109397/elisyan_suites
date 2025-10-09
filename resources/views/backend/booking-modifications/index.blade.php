@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Booking Modifications</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking-modifications.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Modification
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Booking Reference</th>
                                <th>Modification Type</th>
                                <th>Modified By</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookingModifications as $modification)
                            <tr>
                                <td>{{ $modification->booking->booking_reference }}</td>
                                <td>{{ $modification->modification_type }}</td>
                                <td>{{ $modification->modifiedBy->name }}</td>
                                <td>{{ $modification->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('booking-modifications.show', $modification->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('booking-modifications.edit', $modification->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('booking-modifications.destroy', $modification->id) }}" method="POST" style="display: inline;">
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