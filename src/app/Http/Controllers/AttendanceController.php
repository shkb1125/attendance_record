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
    }

    public function start(Request $request)
    {
        $user = Auth::user();
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        Attendance::create([
            'user_id' => $user->id,
            'date' => $currentDate,
            'start_time' => $currentTime,
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
            'end_time' => Carbon::now()->format('H:i:s'),
        ]);

        return redirect('/');
    }

    public function show($date = null)
    {
        // 日付遷移
        $date = $date ? Carbon::parse($date) : Carbon::today();
        $yesterdayDate = $date->copy()->subDay()->format('Y-m-d');
        $nextDate = $date->copy()->addDay()->format('Y-m-d');

        // 当日データの取得
        $attendances = Attendance::whereDate('created_at', $date->format('Y-m-d'))->paginate(5);

        // ユーザー情報と総勤務・休憩時間の取得
        foreach ($attendances as $attendance) {
            $rest = new Rest();
            $attendance->total_rest_time = $rest->getTotalRestTime($attendance->id);
            // $attendance->total_rest_time = Rest::getTotalRestTime($attendance->id);
            $attendance->total_work_time = $attendance->getTotalWorkTime();
        }

        return view('attendance', compact('date', 'yesterdayDate', 'nextDate', 'attendances'));

        // $users = User::with([
        //     'attendances' => function ($query) use ($date) {
        //         $query->whereDate('created_at', $date->format('Y-m-d'));
        //     },
        //     'attendances.rests'
        // ])->paginate(5);
        // // 総勤務・休憩時間
        // foreach ($users as $user) {
        //     foreach ($user->attendances as $attendance) {
        //         $attendance->total_rest_time = Rest::getTotalRestTime($attendance->id);
        //         $attendance->total_work_time = $attendance->getTotalWorkTime();
        //     }
        // }
        // return view('attendance', compact('date', 'yesterdayDate', 'nextDate', 'users'));

    }

    public function showUsers()
    {
        $users = User::paginate(5);
        return view('attendance_users', compact('users'));
    }

    public function showUser()
    {
        $user = Auth::user();
        $attendances = Attendance::where('user_id', $user->id)
            ->latest('id')
            ->paginate(5);
        foreach ($attendances as $attendance) {
            $rest = new Rest();
            $attendance->total_rest_time = $rest->getTotalRestTime($attendance->id);
            $attendance->total_work_time = $attendance->getTotalWorkTime();
        }

        return view('user_attendance', compact('user', 'attendances'));
    }
}
