@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Loyalty Members</h3>
                    <div class="card-tools">
                        <a href="{{ route('loyalty-members.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Member
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Program</th>
                                <th>Membership Number</th>
                                <th>Join Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loyaltyMembers as $loyaltyMember)
                            <tr>
                                <td>{{ $loyaltyMember->guest->full_name }}</td>
                                <td>{{ $loyaltyMember->loyaltyProgram->name }}</td>
                                <td>{{ $loyaltyMember->membership_number }}</td>
                                <td>{{ $loyaltyMember->join_date->format('d M Y') }}</td>
                                <td>{{ $loyaltyMember->status }}</td>
                                <td>
                                    <a href="{{ route('loyalty-members.show', $loyaltyMember->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('loyalty-members.edit', $loyaltyMember->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('loyalty-members.destroy', $loyaltyMember->id) }}" method="POST" style="display: inline;">
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