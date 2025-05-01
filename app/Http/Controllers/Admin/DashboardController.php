<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function index()
    {
        return view('admin.dashboard.index');
    }

    public function themeUpdate(Request $request)
    {
        $theme = $request->input('theme');

        if (in_array($theme, ['light', 'dark'])) {
            session(['theme' => $theme]);
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 400);
    }
}
