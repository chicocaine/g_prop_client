<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commission;
use App\Models\Message;
use App\Models\Faq;


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


    public function getMessages($commissionId)
    {
        $messages = Message::where('commission_id', $commissionId)->with('user')->get();
        $html = view('components.messages', compact('messages','commissionId'))->render();

        return response()->json(['html' => $html]);
    }
    
    public function storeMessage(Request $request, $commissionId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);
    
        $message = new Message();
        $message->commission_id = $commissionId;
        $message->user_id = Auth::id();
        $message->content = nl2br(e($request->content)); 
        $message->save();
    
        $message->load('user'); 
    
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
public function showInbox()
{
    $user = Auth::user();
    $commissions = Commission::where('user_id', $user->id)
        ->whereIn('status', ['pending', 'processing','cancelled'])
        ->get();

    $faqs = Faq::all();


    return view('orders.dashboard-order', [
        'commissions' => $commissions,
        'view' => 'inbox',
        'faqs' => $faqs,

    ]);
}

public function showArchived()
{
    $user = Auth::user();
    $commissions = Commission::where('user_id', $user->id)
        ->where('status', 'completed')
        ->get();

    return view('orders.dashboard-order', [
        'commissions' => $commissions,
        'view' => 'archive'
    ]);
}

public function store(Request $request)
{
    $user = Auth::user();
    $commission = Commission::create([
        'user_id' => $user->id,
        'set_price' => 0,
        'details' => $request->input('question'),
        'delivery_address' => '',
        'status' => 'pending',
        'deadline' => now()->addWeek(),
        'completed_at' => null
    ]);

    // Create the first message
    $message = new Message();
    $message->commission_id = $commission->id;
    $message->user_id = $user->id;
    $message->content = $request->input('question');
    $message->save();

    return response()->json([
        'success' => true,
        'commission' => $commission
    ]);
}



public function showDashboard(Request $request)
{
    $user = Auth::user();
    $commissions = Commission::where('user_id', $user->id)->get();
    $faqs = Faq::all();

    if ($request->ajax()) {
        return view('components.inbox', compact('commissions'))->render();
    }

    return view('orders.dashboard-order', [
        'commissions' => $commissions,
        'faqs' => $faqs,
        'view' => 'inbox'
    ]);
}
public function getInboxContent()
{
    $user = Auth::user();
    $commissions = Commission::where('user_id', $user->id)->whereIn('status', ['pending', 'processing', 'cancelled'])->get();

    return view('components.inbox-content', compact('commissions'))->render();
}

}