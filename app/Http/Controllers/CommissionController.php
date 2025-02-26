<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commission;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::all();
        return view('components.dashboard.dashboard-view', compact('commissions'));
    }
}