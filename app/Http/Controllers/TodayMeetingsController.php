<?php

namespace App\Http\Controllers;

use App\Models\Rapat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TodayMeetingsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $todayRapats = Rapat::whereDate('tanggal_rapat', $today)
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        return view('meetings.today', compact('todayRapats'));
    }
}