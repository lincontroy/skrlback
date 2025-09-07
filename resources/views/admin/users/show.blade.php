@extends('admin.layout')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">User Details: {{ $user->name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary me-2">
            <i class="bi bi-pencil"></i> Edit User
        </a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5>User Information</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Name:</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                        <th>Customer ID:</th>
                        <td>{{ $user->customer_id }}</td>
                    </tr>
                    <tr>
                        <th>Skiller Badge:</th>
                        <td>{{ $user->skiller_badge ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Biometrics Enabled:</th>
                        <td>
                            <span class="badge bg-{{ $user->biometrics_enabled ? 'success' : 'secondary' }}">
                                {{ $user->biometrics_enabled ? 'Yes' : 'No' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Notifications Enabled:</th>
                        <td>
                            <span class="badge bg-{{ $user->notifications_enabled ? 'success' : 'secondary' }}">
                                {{ $user->notifications_enabled ? 'Yes' : 'No' }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Registered:</th>
                        <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Transaction History</h5>
                <a href="{{ route('admin.transactions.create') }}?user_id={{ $user->id }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Transaction
                </a>
            </div>
            <div class="card-body">
                @if($transactions->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->id }}</td>
                                        <td>
                                            <span class="badge bg-{{ $transaction->type == 'deposit' ? 'success' : 'warning' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $transaction->description }}</td>
                                        <td class="{{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                            KES {{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.transactions.show', $transaction) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $transactions->links() }}
                @else
                    <p class="text-muted">No transactions found for this user.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection