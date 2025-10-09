@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Feedback</h3>
                    <div class="card-tools">
                        <a href="{{ route('feedback.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Feedback
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Booking</th>
                                <th>Rating</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feedbacks as $feedback)
                            <tr>
                                <td>{{ $feedback->guest->full_name }}</td>
                                <td>{{ $feedback->booking ? $feedback->booking->booking_reference : 'N/A' }}</td>
                                <td>
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $feedback->rating)
                                                <i class="fas fa-star text-warning"></i>
                                            @else
                                                <i class="far fa-star text-warning"></i>
                                            @endif
                                        @endfor
                                        ({{ $feedback->rating }})
                                    </div>
                                </td>
                                <td>{{ $feedback->category }}</td>
                                <td>
                                    <span class="badge bg-{{ $feedback->status == 'resolved' ? 'success' : ($feedback->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($feedback->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('feedback.show', $feedback->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('feedback.edit', $feedback->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" style="display: inline;">
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