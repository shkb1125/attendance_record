<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use Illuminate\Support\Carbon;
use App\Models\Rest;
use App\Models\User;

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

    public function show()
    {
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)
            ->latest('id')
            ->first();

        // 勤怠データが存在する場合は休憩時間を計算
        if ($attendance) {
            $rest = Rest::getTotalRestTime($attendance->id);
            $totalWorkTime = $attendance->getTotalWorkTime();
        } else {
            // 勤怠データが存在しない場合の時間を設定
            $rest = '00:00:00';
            $totalWorkTime = '00:00:00';
        }
        // 今日の日付を取得
        $date = Carbon::today()->format('Y-m-d');

        $users = User::all();

        return view('attendance', compact('user', 'attendance', 'date', 'rest', 'totalWorkTime', 'users'));
    }
}
