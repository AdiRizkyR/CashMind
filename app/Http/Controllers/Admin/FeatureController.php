<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureFlag;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = FeatureFlag::all();

        return view('admin.features', compact('features'));
    }

    public function toggle(Request $request, FeatureFlag $feature)
    {
        $feature->update([
            'enabled' => ! $feature->enabled,
        ]);

        return redirect()->back()->with('success', "Status fitur {$feature->name} berhasil diubah.");
    }
}
