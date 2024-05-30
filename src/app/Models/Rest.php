<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Rest extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

    public function getTotalRestTime($attendanceId)
    {
        // 指定された勤怠IDに関連する休憩データを取得
        $rests = self::where('attendance_id', $attendanceId)->get();
        $totalRestTime = 0;

        foreach ($rests as $rest) {
            if ($rest->rest_start_time && $rest->rest_end_time) {

                $startTime = Carbon::parse($rest->rest_start_time);
                $endTime = Carbon::parse($rest->rest_end_time);

                $totalRestTime += $endTime->diffInSeconds($startTime);
            }
        }

        return gmdate('H:i:s', $totalRestTime);

    }

}
