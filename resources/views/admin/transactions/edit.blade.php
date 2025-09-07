@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Transaction</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-info me-2">
            <i class="bi bi-eye"></i> View Details
        </a>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Transactions
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">User</label>
                        <div class="form-control bg-light">
                            {{ $transaction->user->name }} ({{ $transaction->user->email }})
                        </div>
                        <small class="form-text text-muted">User cannot be changed for existing transactions.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="type" class="form-label">Transaction Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="deposit" {{ $transaction->type == 'deposit' ? 'selected' : '' }}>Deposit</option>
                            <option value="withdrawal" {{ $transaction->type == 'withdrawal' ? 'selected' : '' }}>Withdrawal</option>
                            <option value="transfer" {{ $transaction->type == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="exchange" {{ $transaction->type == 'exchange' ? 'selected' : '' }}>Exchange</option>
                        </select>
                        @error('type')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" 
                               value="{{ old('description', $transaction->description) }}" required>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" step="0.01" class="form-control" id="amount" 
                                       name="amount" value="{{ old('amount', $transaction->amount) }}" required>
                                @error('amount')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select class="form-select" id="currency" name="currency" required>
                                    <option value="KES" {{ old('currency', $transaction->currency) == 'KES' ? 'selected' : '' }}>KES</option>
                                    <option value="USD" {{ old('currency', $transaction->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                    <option value="EUR" {{ old('currency', $transaction->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                    <option value="GBP" {{ old('currency', $transaction->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                </select>
                                @error('currency')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="counterparty" class="form-label">Counterparty (Optional)</label>
                        <input type="text" class="form-control" id="counterparty" name="counterparty" 
                               value="{{ old('counterparty', $transaction->counterparty) }}" placeholder="e.g., MPESA *7136, John Doe">
                        @error('counterparty')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="transaction_date" class="form-label">Transaction Date</label>
                        <input type="datetime-local" class="form-control" id="transaction_date" 
                               name="transaction_date" value="{{ old('transaction_date', $transaction->transaction_date->format('Y-m-d\TH:i')) }}" required>
                        @error('transaction_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ old('status', $transaction->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ old('status', $transaction->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="failed" {{ old('status', $transaction->status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="cancelled" {{ old('status', $transaction->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Transaction</button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Current User Balance</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h3 class="text-{{ $transaction->user->balance >= 0 ? 'success' : 'danger' }}">
                        {{ $transaction->user->currency }} {{ number_format($transaction->user->balance, 2) }}
                    </h3>
                    <p class="text-muted">Current balance for {{ $transaction->user->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection