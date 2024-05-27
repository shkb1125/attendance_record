<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rest;
use App\Models\Attendance;
use Carbon\Carbon;

class RestController extends Controller
{
    public function start(Request $request)
    {
        $user = Auth::user();

        $attendance = Attendance::where('user_id', $user->id)
            ->latest()
            ->first();

        if ($attendance) {
            $restCount = Rest::where('attendance_id', $attendance->id)->count();
            Rest::create([
                'attendance_id' => $attendance->id,
                'rest_number' => $restCount + 1,
                'rest_start_time' => Carbon::now()->format('H:i:s'),
            ]);
        }

        return redirect('/');
    }

    public function stop(Request $request)
    {
        $user = Auth::user();

        $attendance = Attendance::where('user_id', $user->id)
            ->latest('id')
            ->first();

        $attendance->rests->last()->update([
            'rest_end_time' => Carbon::now()->format('H:i:s'),
        ]);

        return redirect('/');
    }

}
