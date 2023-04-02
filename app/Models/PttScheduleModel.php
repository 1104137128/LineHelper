<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PttScheduleModel extends Model
{
    use HasFactory;

    protected $table = 'ptt_schedule';
    protected $fillable = ['id', 'name', 'schedule_time'];

    public $timestamps = false;
}
