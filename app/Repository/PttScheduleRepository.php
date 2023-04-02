<?php

namespace App\Repository;

use App\Models\PttScheduleModel;
use Illuminate\Support\Facades\DB;

class PttScheduleRepository
{
    private $ptt_schedule;

    public function __construct(PttScheduleModel $ptt_schedule)
    {
        $this->ptt_schedule = $ptt_schedule;
    }

    /**
     * 取得 PTT排程表
     *
     * @param integer $ptt_schedule_id
     *
     * @return collection
     */
    public function getPttSchedule($ptt_schedule_id = null)
    {
        $db = $this->ptt_schedule->select('*', DB::raw(
            'UNIX_TIMESTAMP(created_at) * 1000 AS created_at'
        ));

        if ($ptt_schedule_id != null) {
            $db->where('id', $ptt_schedule_id);
        }

        return $db->get();
    }

    /**
     * 設置 PTT排程
     *
     * @param integer $id
     * @param array $data
     */
    public function setPttSchedule($id, $data)
    {
        $this->ptt_schedule->updateOrCreate(['id' => $id], $data);
    }
}
