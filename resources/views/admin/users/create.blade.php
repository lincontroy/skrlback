@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create User</h1>
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
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="{{ old('name') }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="{{ old('email') }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="pin" class="form-label">PIN (4 digits)</label>
                        <input type="text" class="form-control" id="pin" name="pin" 
                               value="{{ old('pin') }}" maxlength="4" pattern="[0-9]{4}" required>
                        @error('pin')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="balance" class="form-label">Initial Balance</label>
                                <input type="number" step="0.01" class="form-control" id="balance" 
                                       name="balance" value="{{ old('balance', 0) }}">
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
                                        <option value="{{ $code }}" {{ old('currency', 'KES') == $code ? 'selected' : '' }}>
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
                               value="{{ old('skiller_badge') }}" placeholder="e.g., Gold, Silver, Bronze">
                        @error('skiller_badge')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="biometrics_enabled" 
                               name="biometrics_enabled" {{ old('biometrics_enabled') ? 'checked' : '' }}>
                        <label class="form-check-label" for="biometrics_enabled">Biometrics Enabled</label>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="notifications_enabled" 
                               name="notifications_enabled" {{ old('notifications_enabled', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="notifications_enabled">Notifications Enabled</label>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection