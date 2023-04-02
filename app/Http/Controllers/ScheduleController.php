<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Service\ScheduleService;

class ScheduleController extends Controller
{
    private $schedule;

    public function __construct(ScheduleService $schedule)
    {
        $this->schedule = $schedule;
    }

    /**
     * 取得 Ptt排程
     *
     * @param integer $id
     *
     * @param json
     */
    public function getPttSchedule($id = null)
    {
        return $this->schedule->getPttSchedule($id);
    }

    /**
     * 新增 PTT排程
     */
    public function createPttSchedule()
    {
        $this->schedule->createPttSchedule(request()->all());
    }

    /**
     * 更新 Ptt排程
     *
     * @param integer $id
     */
    public function updatePttSchedule($id)
    {
        $this->schedule->updatePttSchedule($id, request()->all());
    }

    /**
     * 取得 Stock排程
     *
     * @param integer $id
     *
     * @param json
     */
    public function getStockSchedule($id = null)
    {
        return $this->schedule->getStockSchedule($id);
    }

    /**
     * 新增 Stock排程
     */
    public function createStockSchedule()
    {
        $this->schedule->createStockSchedule(request()->all());
    }

    /**
     * 更新 Stock排程
     *
     * @param integer $id
     */
    public function updateStockSchedule($id)
    {
        $this->schedule->updateStockSchedule($id, request()->all());
    }
}
