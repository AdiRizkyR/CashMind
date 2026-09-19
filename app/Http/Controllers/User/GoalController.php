<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Goal;
use Illuminate\Http\Request;

class GoalController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $goals = $user->goals()->with('contributions')->get();

        return view('user.goals', compact('goals'));
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'target_amount' => 'required|numeric|min:1000',
            'target_date' => 'nullable|date|after:today',
        ]);

        $user->goals()->create($validated);

        return redirect()->back()->with('success', 'Target keuangan baru berhasil dibuat.');
    }

    public function contribute(Request $request, Goal $goal)
    {
        $user = $request->user();

        if ($goal->user_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'contribution_date' => 'required|date',
            'note' => 'nullable|string|max:255',
        ]);

        $goal->contributions()->create([
            'user_id' => $user->id,
            'amount' => $validated['amount'],
            'contribution_date' => $validated['contribution_date'],
            'note' => $validated['note'],
        ]);

        if ($goal->current_amount >= $goal->target_amount) {
            $goal->update(['status' => 'completed']);
        }

        return redirect()->back()->with('success', 'Setoran tabungan berhasil dicatat.');
    }

    public function destroy(Request $request, Goal $goal)
    {
        $user = $request->user();

        if ($goal->user_id !== $user->id) {
            abort(403);
        }

        $goal->delete();

        return redirect()->back()->with('success', 'Target keuangan berhasil dihapus.');
    }
}
