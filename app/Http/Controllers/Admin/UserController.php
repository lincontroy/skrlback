<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withCount('transactions')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

  

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'pin' => 'required|digits:4',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'pin' => $request->pin,
            'customer_id' => User::generateCustomerId(),
            'skiller_badge' => $request->skiller_badge,
            'biometrics_enabled' => $request->has('biometrics_enabled'),
            'notifications_enabled' => $request->has('notifications_enabled'),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $transactions = $user->transactions()->latest()->paginate(10);
        return view('admin.users.show', compact('user', 'transactions'));
    }
    
    public function create()
    {
        $currencies = ['KES' => 'Kenyan Shilling', 'USD' => 'US Dollar', 'EUR' => 'Euro', 'GBP' => 'British Pound'];
        return view('admin.users.create', compact('currencies'));
    }
    
    public function edit(User $user)
    {
        $currencies = ['KES' => 'Kenyan Shilling', 'USD' => 'US Dollar', 'EUR' => 'Euro', 'GBP' => 'British Pound'];
        return view('admin.users.edit', compact('user', 'currencies'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'pin' => 'nullable|digits:4',
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'skiller_badge' => $request->skiller_badge,
            'biometrics_enabled' => $request->has('biometrics_enabled'),
            'notifications_enabled' => $request->has('notifications_enabled'),
        ];

        if ($request->filled('pin')) {
            $updateData['pin'] = $request->pin;
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}