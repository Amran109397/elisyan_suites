@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Waiting List</h3>
                    <div class="card-tools">
                        <a href="{{ route('waiting-list.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add to Waiting List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Property</th>
                                <th>Room Type</th>
                                <th>Check-in Date</th>
                                <th>Check-out Date</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($waitingLists as $waitingList)
                            <tr>
                                <td>{{ $waitingList->guest->first_name }} {{ $waitingList->guest->last_name }}</td>
                                <td>{{ $waitingList->property->name }}</td>
                                <td>{{ $waitingList->roomType->name }}</td>
                                <td>{{ $waitingList->check_in_date->format('d M Y') }}</td>
                                <td>{{ $waitingList->check_out_date->format('d M Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $waitingList->priority >= 8 ? 'danger' : ($waitingList->priority >= 5 ? 'warning' : 'info') }}">
                                        {{ $waitingList->priority }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $waitingList->status == 'waiting' ? 'warning' : ($waitingList->status == 'contacted' ? 'info' : ($waitingList->status == 'booked' ? 'success' : 'danger')) }}">
                                        {{ ucfirst($waitingList->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('waiting-list.show', $waitingList->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('waiting-list.edit', $waitingList->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($waitingList->status == 'waiting')
                                    <form action="{{ route('waiting-list.contact', $waitingList->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary" title="Mark as Contacted">
                                            <i class="fas fa-phone"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @if($waitingList->status == 'contacted')
                                    <form action="{{ route('waiting-list.book', $waitingList->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success" title="Mark as Booked">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('waiting-list.destroy', $waitingList->id) }}" method="POST" style="display: inline;">
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