<?php

namespace App\Domain\Models;

use App\Domain\Repository\PeriodRecordRepository;
use Carbon\Carbon;

class PeriodRecord
{
    public int $userId;

    public Carbon $startDate;

    public ?Carbon $endDate;

    public bool $isCalcTarget;

    public function __construct(int $userId, Carbon $startDate, bool $isCalcTarget = true)
    {
        $this->userId = $userId;
        $this->startDate = $startDate;
        $this->isCalcTarget = $isCalcTarget;
    }

    public function recordStart()
    {
        app(PeriodRecordRepository::class)::upsert($this);
    }
}
