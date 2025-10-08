@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Seasons</h3>
                    <div class="card-tools">
                        <a href="{{ route('seasons.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Season
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Price Adjustment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($seasons as $season)
                            <tr>
                                <td>{{ $season->property->name }}</td>
                                <td>{{ $season->name }}</td>
                                <td>{{ $season->start_date->format('d M Y') }}</td>
                                <td>{{ $season->end_date->format('d M Y') }}</td>
                                <td>
                                    @if($season->price_adjustment > 0)
                                        <span class="text-success">+{{ $season->price_adjustment }}%</span>
                                    @elseif($season->price_adjustment < 0)
                                        <span class="text-danger">{{ $season->price_adjustment }}%</span>
                                    @else
                                        <span class="text-muted">0%</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('seasons.show', $season->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('seasons.edit', $season->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('seasons.destroy', $season->id) }}" method="POST" style="display: inline;">
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