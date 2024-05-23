<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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

        // foreachでカウントの数だけ繰り返す
        foreach ($rests as $rest) {
            if ($rest->rest_start_time && $rest->rest_end_time) {
                // Carbonインスタンスを作成して時間の差を計算
                $startTime = Carbon::parse($rest->rest_start_time);
                $endTime = Carbon::parse($rest->rest_end_time);
                // 差分を秒単位で取得し、合計休憩時間に追加
                $totalRestTime += $endTime->diffInSeconds($startTime);
            }
        }
        // 合計休憩時間を "H:i:s" の形式に変換して返す
        return gmdate('H:i:s', $totalRestTime);

        // return DB::table('rests')
        //     ->selectRaw('DATE_FORMAT(rest_start_time, "%H%i%s") AS date')
        //     ->selectRaw('SUM(rest_start_time) AS total')
        //     ->groupBy('date')
        //     ->get();

        // return Rest::selectRaw('SEC_TO_TIME(SUM(TIME_TO_SEC(rest_start_time))) as total_time')
        //     ->where('training_name', 'ベンチプレス')
        //     ->first();
    }

}
