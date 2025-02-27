<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commission;

class CommissionController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->query('status');

        if ($status) {
            $commissions = Commission::where('user_id', $user->id)
                ->where('status', $status)
                ->get();
        } else {
            $commissions = Commission::where('user_id', $user->id)->get();
        }

        return view('components.dashboard.dashboard-view', compact('commissions'));
    }
}