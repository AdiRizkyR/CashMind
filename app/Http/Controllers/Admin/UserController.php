<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.users', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->role === 'admin') {
            abort(403);
        }

        // Return ONLY metadata (name, email, account id, registered, last login, status, verified).
        // NO financial data (balances, income, expense, transactions)!
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'status' => $user->status,
            'email_verified' => $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'Unverified',
            'last_login_at' => $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Belum pernah login',
            'created_at' => $user->created_at->format('Y-m-d H:i:s'),
        ]);
    }

    public function toggleStatus(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->back()->withErrors(['user' => 'Role admin tidak dapat diubah statusnya.']);
        }

        $newStatus = $user->status === 'active' ? 'suspended' : 'active';
        $user->update(['status' => $newStatus]);

        SecurityLog::log($newStatus === 'suspended' ? 'ACCOUNT_SUSPENDED' : 'ACCOUNT_ACTIVATED', $user);

        return redirect()->back()->with('success', "Status akun {$user->name} berhasil diubah menjadi {$newStatus}.");
    }

    public function sendResetLink(User $user)
    {
        Password::sendResetLink(['email' => $user->email]);

        SecurityLog::log('PASSWORD_RESET_LINK_SENT', $user);

        return redirect()->back()->with('success', "Link reset password telah dikirim ke email {$user->email}.");
    }
}
