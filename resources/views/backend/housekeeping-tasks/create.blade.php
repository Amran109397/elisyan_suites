@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Housekeeping Task</h3>
                    <div class="card-tools">
                        <a href="{{ route('housekeeping-tasks.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('housekeeping-tasks.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="property_id">Property <span class="text-danger">*</span></label>
                                    <select class="form-select @error('property_id') is-invalid @enderror" id="property_id" name="property_id" required>
                                        <option value="">Select Property</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>{{ $property->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_id">Room <span class="text-danger">*</span></label>
                                    <select class="form-select @error('room_id') is-invalid @enderror" id="room_id" name="room_id" required>
                                        <option value="">Select Room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->room_number }}</option>
                                        @endforeach
                                    </select>
                                    @error('room_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="staff_id">Staff</label>
                                    <select class="form-select @error('staff_id') is-invalid @enderror" id="staff_id" name="staff_id">
                                        <option value="">Select Staff</option>
                                        @foreach($staff as $member)
                                            <option value="{{ $member->id }}" {{ old('staff_id') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('staff_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="task_type">Task Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('task_type') is-invalid @enderror" id="task_type" name="task_type" required>
                                        <option value="">Select Task Type</option>
                                        <option value="cleaning" {{ old('task_type') == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                                        <option value="maintenance" {{ old('task_type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="inspection" {{ old('task_type') == 'inspection' ? 'selected' : '' }}>Inspection</option>
                                        <option value="turndown" {{ old('task_type') == 'turndown' ? 'selected' : '' }}>Turndown</option>
                                    </select>
                                    @error('task_type')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority">Priority <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority" required>
                                        <option value="">Select Priority</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                    @error('priority')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="assigned" {{ old('status', 'assigned') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="skipped" {{ old('status') == 'skipped' ? 'selected' : '' }}>Skipped</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="completed_at">Completed At</label>
                                    <input type="datetime-local" class="form-control @error('completed_at') is-invalid @enderror" id="completed_at" name="completed_at" value="{{ old('completed_at') }}">
                                    @error('completed_at')
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
                            <button type="submit" class="btn btn-primary">Create Task</button>
                            <a href="{{ route('housekeeping-tasks.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection