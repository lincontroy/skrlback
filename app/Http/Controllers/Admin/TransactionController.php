<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(15);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.transactions.create', compact('users'));
    }


    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $users = User::all();
        return view('admin.transactions.edit', compact('transaction', 'users'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'type' => 'required|in:deposit,withdrawal,transfer,exchange',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:3',
            'counterparty' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,completed,failed,cancelled',
        ]);
    
        $user = User::findOrFail($request->user_id);
        
        // Create transaction
        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'type' => $request->type,
            'description' => $request->description,
            'amount' => $request->amount,
            'fee' => $request->fee,
            'currency' => $request->currency,
            'counterparty' => $request->counterparty,
            'name' => $request->name,
            'email' => $request->email,
            'transaction_date' => $request->transaction_date,
            'status' => $request->status,
            'reference' => 'SKR' . time() . rand(100, 999),
        ]);
    
        // Update user balance if transaction is completed
        if ($request->status === 'completed') {
            $user->updateBalance($request->amount, $request->type);
        }
    
        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction created successfully.');
    }
    
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'type' => 'required|in:deposit,withdrawal,transfer,exchange',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:3',
            'counterparty' => 'nullable|string|max:255',
            'transaction_date' => 'required|date',
            'status' => 'required|in:pending,completed,failed,cancelled',
        ]);
    
        $user = $transaction->user;
        $oldStatus = $transaction->status;
        $oldAmount = $transaction->amount;
        $oldType = $transaction->type;
    
        // Reverse old transaction effect if it was completed
        if ($oldStatus === 'completed') {
            if ($oldType === 'deposit') {
                $user->balance -= $oldAmount;
            } elseif ($oldType === 'withdrawal') {
                $user->balance += $oldAmount;
            }
        }
    
        // Update transaction
        $transaction->update($request->all());
    
        // Apply new transaction effect if status is completed
        if ($request->status === 'completed') {
            if ($request->type === 'deposit') {
                $user->balance += $request->amount;
            } elseif ($request->type === 'withdrawal') {
                $user->balance -= $request->amount;
            }
        }
    
        $user->save();
    
        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }
}