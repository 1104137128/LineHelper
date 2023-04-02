<?php

namespace App\Repository;

use App\Models\StockScheduleModel;
use Illuminate\Support\Facades\DB;

class StockScheduleRepository
{
    private $stock_schedule;

    public function __construct(StockScheduleModel $stock_schedule)
    {
        $this->stock_schedule = $stock_schedule;
    }

    /**
     * 取得 PTT排程表
     *
     * @param integer $stock_schedule_id
     *
     * @return collection
     */
    public function getPttSchedule($stock_schedule_id = null)
    {
        $db = $this->stock_schedule->select('*', DB::raw(
            'UNIX_TIMESTAMP(created_at) * 1000 AS created_at'
        ));

        if ($stock_schedule_id != null) {
            $db->where('id', $stock_schedule_id);
        }

        return $db->get();
    }

    /**
     * 設置 Stock排程
     *
     * @param integer $id
     * @param array $data
     */
    public function setPttSchedule($id, $data)
    {
        $this->stock_schedule->updateOrCreate(['id' => $id], $data);
    }
}
