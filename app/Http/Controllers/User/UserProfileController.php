<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserProfileController extends Controller
{
    /**
     * Display the user's financial profile & ML recommendation settings.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        
        $profile = $user->profile ?: $user->profile()->create([
            'monthly_income' => 0,
            'payday_date' => 25,
            'payday_frequency' => 'monthly',
            'financial_goal_type' => 'balanced',
            'dependents_count' => 0,
            'risk_profile' => 'moderate',
            'recommendation_frequency' => 'month_start',
            'auto_apply_recommendation' => false,
        ]);

        return view('user.profile', compact('user', 'profile'));
    }

    /**
     * Update the user's financial profile & recommendation schedule.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'monthly_income' => 'required|numeric|min:0',
            'payday_date' => 'required|integer|between:1,31',
            'payday_frequency' => 'required|string|in:monthly,biweekly,weekly',
            'financial_goal_type' => 'required|string|in:saving_focused,balanced,debt_reduction,frugal',
            'dependents_count' => 'required|integer|min:0|max:20',
            'risk_profile' => 'required|string|in:conservative,moderate,aggressive',
            'recommendation_frequency' => 'required|string|in:month_start,payday,weekly,manual',
            'auto_apply_recommendation' => 'nullable|boolean',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'monthly_income' => $validated['monthly_income'],
                'payday_date' => $validated['payday_date'],
                'payday_frequency' => $validated['payday_frequency'],
                'financial_goal_type' => $validated['financial_goal_type'],
                'dependents_count' => $validated['dependents_count'],
                'risk_profile' => $validated['risk_profile'],
                'recommendation_frequency' => $validated['recommendation_frequency'],
                'auto_apply_recommendation' => $request->has('auto_apply_recommendation'),
            ]
        );

        return redirect()->back()->with('success', 'Profil finansial & jadwal rekomendasi ML anggaran berhasil diperbarui.');
    }
}
