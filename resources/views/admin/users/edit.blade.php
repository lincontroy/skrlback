@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit User</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="pin" class="form-label">PIN (4 digits)</label>
                        <input type="text" class="form-control" id="pin" name="pin" 
                               value="{{ old('pin', $user->pin) }}" maxlength="4" pattern="[0-9]{4}" required>
                        @error('pin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Customer Id</label>
                        <input type="text" class="form-control" id="customer_id" name="customer_id" 
                               value="{{ old('customer_id', $user->customer_id) }}"  required>
                        @error('customer_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="balance" class="form-label">Balance</label>
                                <input type="number" step="0.01" class="form-control" id="balance" 
                                       name="balance" value="{{ old('balance', $user->balance) }}">
                                @error('balance')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select class="form-select" id="currency" name="currency" required>
                                    @foreach($currencies as $code => $name)
                                        <option value="{{ $code }}" {{ old('currency', $user->currency) == $code ? 'selected' : '' }}>
                                            {{ $code }} - {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('currency')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="skiller_badge" class="form-label">Skiller Badge (Optional)</label>
                        <input type="text" class="form-control" id="skiller_badge" name="skiller_badge" 
                               value="{{ old('skiller_badge', $user->skiller_badge) }}" placeholder="e.g., Gold, Silver, Bronze">
                        @error('skiller_badge')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="biometrics_enabled" 
                               name="biometrics_enabled" {{ old('biometrics_enabled', $user->biometrics_enabled) ? 'checked' : '' }}>
                        <label class="form-check-label" for="biometrics_enabled">Biometrics Enabled</label>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="notifications_enabled" 
                               name="notifications_enabled" {{ old('notifications_enabled', $user->notifications_enabled) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notifications_enabled">Notifications Enabled</label>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
                
                <!-- Optional: Add delete button -->
                <div class="mt-4 pt-3 border-top">
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="bi bi-trash"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection