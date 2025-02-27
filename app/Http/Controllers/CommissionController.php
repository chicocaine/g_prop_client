<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commission;
use App\Models\Message;

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

    public function showPendingAndCancelled()
    {
        $user = Auth::user();
        $commissions = Commission::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'cancelled'])
            ->get();

        return view('orders.dashboard-order', compact('commissions'));
    }

    public function getMessages($commissionId)
    {
        $messages = Message::where('commission_id', $commissionId)->with('user')->get();
        $html = view('components.messages', compact('messages'))->render();

        return response()->json(['html' => $html]);
    }
}