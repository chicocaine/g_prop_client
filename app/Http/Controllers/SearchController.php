<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
            ->whereIn('status', ['pending', 'processing', 'active'])
            ->where(function ($q) use ($query) {
                $q->where('details', 'like', "%{$query}%")
                  ->orWhere('subject', 'like', "%{$query}%")
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
                  ->orWhere('subject', 'like', "%{$query}%")
                  ->orWhereHas('messages', function($q) use ($query) {
                      $q->where('content', 'like', "%{$query}%");
                  });
            })
            ->get();
            
        return response()->json([
            'commissions' => $commissions
        ]);
    }
    
    private function searchDashboard($query, $user)
    {
        $commissions = Commission::where(function ($q) use ($query) {
                $q->where('details', 'like', "%{$query}%")
                  ->orWhere('subject', 'like', "%{$query}%")
                  ->orWhere('id', 'like', "%{$query}%")
                  ->orWhere('status', 'like', "%{$query}%");
            })
            ->get();
            
        $html = View::make('components.dashboard._search_results', compact('commissions'))->render();
        
        return response()->json([
            'commissions' => $commissions,
            'html' => $html
        ]);
    }
    
    private function globalSearch($query, $user)
    {
        $commissions = Commission::where('user_id', $user->id)
            ->where(function ($q) use ($query) {
                $q->where('details', 'like', "%{$query}%")
                  ->orWhere('subject', 'like', "%{$query}%")
                  ->orWhereHas('messages', function($q) use ($query) {
                      $q->where('content', 'like', "%{$query}%");
                  });
            })
            ->get();
            
        return response()->json([
            'commissions' => $commissions
        ]);
    }
}