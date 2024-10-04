<?php

namespace App\Infrastructure\Eloquents;

use Illuminate\Database\Eloquent\Model;

class EloquentPeriodRecord extends Model
{
    protected $table = 'period_records';
    protected $primaryKey = 'period_record_id';
}
