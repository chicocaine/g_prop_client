<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Commission;
use App\Models\Message;
use App\Models\Faq;
use App\Models\Attachment;
use App\Models\Log;

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
        $messages = Message::where('commission_id', $commissionId)
            ->with(['user', 'attachments']) // Load attachments
            ->get();
        $html = view('components.messages', compact('messages', 'commissionId'))->render();
    
        return response()->json(['html' => $html]);
    }

    public function storeMessage(Request $request, $commissionId)
    {
        $request->validate([
            'attachments.*' => 'file|max:10240' // Validate each attachment (max size: 10MB)
        ]);
    
        try {
            $message = new Message();
            $message->content = $request->input('content');
            $message->commission_id = $commissionId;
            $message->user_id = Auth::id();
            $message->save();
    
            // Handle attachments
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $path = $file->store('storage/attachments', 'public');
                    $attachment = new Attachment();
                    $attachment->file_name = $file->getClientOriginalName();
                    $attachment->file_path = $path;
                    $attachment->file_size = $file->getSize(); // Get file size
                    $attachment->file_type = $file->getMimeType(); // Get file type
                    $attachment->uploaded_by = Auth::id();
                    $attachment->save();
    
                    $message->attachments()->attach($attachment->id);
                }
            }
    
            $message->load('user', 'attachments');
    
            return response()->json([
                'success' => true,
                'message' => $message,
                'attachments' => $message->attachments
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function showInbox()
    {
        $user = Auth::user();
        $commissions = Commission::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing','cancelled','completed'])
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
        $faqs = Faq::all();

        return view('orders.dashboard-order', [
            'commissions' => $commissions,
            'view' => 'archive',
            'faqs' => $faqs,
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

        // Log the creation of the commission
        Log::create([
            'description' => "New commission created by user: {$user->first_name} {$user->last_name} ({$user->email})",
            'type' => 'commission',
        ]);

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

    public function markMessagesAsRead($commissionId)
    {
        $userId = Auth::id();

        // Update the is_read status of the messages from the admin
        Message::where('commission_id', $commissionId)
            ->whereHas('user', function ($query) {
                $query->where('is_admin', true);
            })
            ->where('is_read', false)
            ->update(['is_read' => 1]);

        return response()->json(['success' => true]);
    }
}