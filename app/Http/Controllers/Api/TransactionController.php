<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
{
    $transactions = $request->user()
        ->transactions()
        ->latest()
        ->paginate(10);

    // Map to the TransactionItem structure expected by your Android app
    $mapped = $transactions->map(function ($tx) {
        return [
            'title' => $tx->description ?: ucfirst($tx->type),
            'type' => ucfirst($tx->type),
            'amount' => number_format($tx->amount, 2),
            'currency' => ($tx->currency),
            'fee' => number_format($tx->fee, 2),
            'name' => $tx->name ?: null,
            'email' => $tx->email ?: null,
            'reference' => $tx->reference ?: null,
            'date' => $tx->transaction_date->format('Y-m-d H:i:s'),
            'transactionType' => strtolower($tx->type) === 'withdrawal' ? 0 : 1,
        ];
    });

    return response()->json([
        'data' => $mapped,
        'current_page' => $transactions->currentPage(),
        'last_page' => $transactions->lastPage(),
        'per_page' => $transactions->perPage(),
        'total' => $transactions->total(),
    ]);
}


    public function show(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized');
        }

        return response()->json($transaction);
    }
}