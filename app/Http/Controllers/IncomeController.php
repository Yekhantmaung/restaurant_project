<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    // Show page
    public function index()
    {
        $today = date('Y-m-d');
        $total = DB::table('incomes')
            ->whereDate('date', $today)
            ->sum('amount');

        return view('admin.income', compact('total'));
    }

    // Save new income record
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        DB::table('incomes')->insert([
            'amount' => $request->amount,
            'date' => now()->toDateString(),
        ]);

        return response()->json(['success' => true]);
    }

    // Get today's total only
    public function getDailyTotal()
    {
        $today = date('Y-m-d');
        $total = DB::table('incomes')
            ->whereDate('date', $today)
            ->sum('amount');

        return response()->json(['total' => $total]);
    }
}
