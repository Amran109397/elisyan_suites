@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Event Resource</h3>
                    <div class="card-tools">
                        <a href="{{ route('event-resources.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('event-resources.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_id">Event <span class="text-danger">*</span></label>
                                    <select class="form-select @error('event_id') is-invalid @enderror" id="event_id" name="event_id" required>
                                        <option value="">Select Event</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('event_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="resource_id">Resource <span class="text-danger">*</span></label>
                                    <select class="form-select @error('resource_id') is-invalid @enderror" id="resource_id" name="resource_id" required>
                                        <option value="">Select Resource</option>
                                        @foreach($resources as $resource)
                                            <option value="{{ $resource->id }}" {{ old('resource_id') == $resource->id ? 'selected' : '' }}>{{ $resource->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('resource_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="quantity">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                            @error('quantity')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Event Resource</button>
                            <a href="{{ route('event-resources.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection