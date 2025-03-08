<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');
        $type = $request->input('type', 'global');
        $user = Auth::user();
        
        switch ($type) {
            case 'inbox':
                return $this->searchInbox($query, $user);
                
            case 'archive':
                return $this->searchArchive($query, $user);
                
            case 'dashboard':
                return $this->searchDashboard($query, $user);
                
            default:
                return $this->globalSearch($query, $user);
        }
    }
    
    private function searchInbox($query, $user)
    {
        $commissions = Commission::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'processing', 'cancelled'])
            ->where(function ($q) use ($query) {
                $q->where('details', 'like', "%{$query}%")
                  ->orWhereHas('messages', function($q) use ($query) {
                      $q->where('content', 'like', "%{$query}%");
                  });
            })
            ->get();
            
        $html = view('components.inbox-content', compact('commissions'))->render();
        
        return response()->json([
            'commissions' => $commissions,
            'html' => $html
        ]);
    }
    
    private function searchArchive($query, $user)
    {
        $commissions = Commission::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where(function ($q) use ($query) {
                $q->where('details', 'like', "%{$query}%")
                  ->orWhereHas('messages', function($q) use ($query) {
                      $q->where('content', 'like', "%{$query}%");
                  });
            })
            ->get();
            
        $html = view('components.archive-content', compact('commissions'))->render();
        
        return response()->json([
            'commissions' => $commissions,
            'html' => $html
        ]);
    }
    
    private function searchDashboard($query, $user)
    {
        // Implement dashboard search logic
        // Return appropriate data and HTML
    }
    
    private function globalSearch($query, $user)
    {
        // Search across all relevant models
        $commissions = Commission::where('user_id', $user->id)
            ->where(function ($q) use ($query) {
                $q->where('details', 'like', "%{$query}%")
                  ->orWhereHas('messages', function($q) use ($query) {
                      $q->where('content', 'like', "%{$query}%");
                  });
            })
            ->get();
            
        // You can add more models to search as needed
        
        return response()->json([
            'commissions' => $commissions,
            // Add other search results as needed
        ]);
    }
}