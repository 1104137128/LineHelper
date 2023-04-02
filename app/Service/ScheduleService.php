<?php

namespace App\Service;

use App\Repository\PttScheduleRepository;
use App\Repository\StockScheduleRepository;

class ScheduleService
{
    private $ptt_schedule;
    private $stock_schedule;

    public function __construct(PttScheduleRepository $ptt_schedule, StockScheduleRepository $stock_schedule)
    {
        $this->ptt_schedule = $ptt_schedule;
        $this->stock_schedule = $stock_schedule;
    }

    /**
     * 取得 PTT排程
     *
     * @param integer $id
     */
    public function getPttSchedule($id = null)
    {
        return $this->ptt_schedule->getPttSchedule($id);
    }

    /**
     * 新增 PTT排程
     *
     * @param array $data
     */
    public function createPttSchedule($data)
    {
        $this->ptt_schedule->setPttSchedule(0, [
            'name' => $data['name'],
            'schedule_time' => $data['schedule_time']
        ]);
    }

    /**
     * 更新 PTT排程
     *
     * @param integer $id
     * @param array $data
     */
    public function updatePttSchedule($id, $data)
    {
        $this->ptt_schedule->setPttSchedule($id, [
            'name' => $data['name'],
            'schedule_time' => $data['schedule_time']
        ]);
    }

    /**
     * 取得 Stock排程
     *
     * @param integer $id
     */
    public function getStockSchedule($id = null)
    {
        return $this->stock_schedule->getPttSchedule($id);
    }

    /**
     * 新增 Stock排程
     *
     * @param array $data
     */
    public function createStockSchedule($data)
    {
        $this->stock_schedule->setPttSchedule(0, ['name' => $data['name']]);
    }

    /**
     * 更新 Stock排程
     *
     * @param integer $id
     * @param array $data
     */
    public function updateStockSchedule($id, $data)
    {
        $this->stock_schedule->setPttSchedule($id, ['name' => $data['name']]);
    }
}
