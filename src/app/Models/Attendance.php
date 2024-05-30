<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rest;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rests()
    {
        return $this->hasMany(Rest::class);
    }

    public function getTotalWorkTime()
    {
        // 勤務開始時間と勤務終了時間を取得
        $startTime = Carbon::parse($this->start_time);
        $endTime = $this->end_time ? Carbon::parse($this->end_time) : Carbon::now();
        $totalWorkTimeInSeconds = $endTime->diffInSeconds($startTime);

        // 休憩時間を計算
        $totalRestTimeInSeconds = $this->rests->reduce(function ($carry, $rest) {
            if ($rest->rest_start_time && $rest->rest_end_time) {
                $startTime = Carbon::parse($rest->rest_start_time);
                $endTime = Carbon::parse($rest->rest_end_time);
                return $carry + $endTime->diffInSeconds($startTime);
            }
            return $carry;
        }, 0);

        // 実際の勤務時間(総勤務時間 - 総休憩時間)
        $actualWorkTimeInSeconds = $totalWorkTimeInSeconds - $totalRestTimeInSeconds;

        return gmdate('H:i:s', $actualWorkTimeInSeconds);
    }

}
