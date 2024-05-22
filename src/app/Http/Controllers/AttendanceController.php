<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $today = Carbon::today()->toDateString();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->latest('id')
            ->first();
        return view('stamp', compact('user', 'attendance'));

        // return view('stamp', compact('users'));
    }

    public function start(Request $request)
    {
        $user = Auth::user();
        // dd($user);
        Attendance::create([
            'user_id' => $user->id,
            'date' => now()->format('Y/m/d'),
            'start_time' => now(),
        ]);
        // $attendance = Attendance::with('user_id');

        // return view('stamp', compact('user', 'attendance'));

        return redirect('/');
    }

    public function stop(Request $request)
    {
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)
            ->latest('id')
            ->first();

        $attendance->update([
            'end_time' => now(),
        ]);
        return redirect('/');
    }

}
