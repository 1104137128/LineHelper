<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockScheduleModel extends Model
{
    use HasFactory;

    protected $table = 'stock_schedule';
    protected $fillable = ['id', 'name'];

    public $timestamps = false;
}
