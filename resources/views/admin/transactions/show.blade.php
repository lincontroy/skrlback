@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Transaction Details</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.transactions.edit', $transaction) }}" class="btn btn-sm btn-primary me-2">
            <i class="bi bi-pencil"></i> Edit Transaction
        </a>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Transactions
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Transaction Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">ID:</th>
                        <td>{{ $transaction->id }}</td>
                    </tr>
                    <tr>
                        <th>Reference:</th>
                        <td>{{ $transaction->reference }}</td>
                    </tr>
                    <tr>
                        <th>User:</th>
                        <td>
                            <a href="{{ route('admin.users.show', $transaction->user) }}">
                                {{ $transaction->user->name }} ({{ $transaction->user->email }})
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Type:</th>
                        <td>
                            <span class="badge bg-{{ $transaction->type == 'deposit' ? 'success' : 'warning' }}">
                                {{ ucfirst($transaction->type) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td>{{ $transaction->description }}</td>
                    </tr>
                    <tr>
                        <th>Amount:</th>
                        <td class="{{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                            {{ $transaction->currency }} {{ number_format($transaction->amount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <th>Counterparty:</th>
                        <td>{{ $transaction->counterparty ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Transaction Date:</th>
                        <td>{{ $transaction->transaction_date->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Created:</th>
                        <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>{{ $transaction->updated_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>User Balance Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="40%">Current Balance:</th>
                        <td>{{ $transaction->user->currency }} {{ number_format($transaction->user->balance, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Currency:</th>
                        <td>{{ $transaction->user->currency }}</td>
                    </tr>
                    <tr>
                        <th>Total Transactions:</th>
                        <td>{{ $transaction->user->transactions_count }}</td>
                    </tr>
                    <tr>
                        <th>Customer ID:</th>
                        <td>{{ $transaction->user->customer_id }}</td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="{{ route('admin.users.show', $transaction->user) }}" class="btn btn-sm btn-outline-primary">
                        View User Profile
                    </a>
                    <a href="{{ route('admin.transactions.create') }}?user_id={{ $transaction->user->id }}" class="btn btn-sm btn-primary ms-2">
                        Add New Transaction
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection