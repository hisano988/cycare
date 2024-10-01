<?php

namespace App\Domain\Models;

use App\Domain\Repositories\PeriodRecordRepository;
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

    public function record(?Carbon $endDate)
    {
        // 終了日設定
        if (is_null($endDate)) {
            $defaultDuration = 7; // TODO: 個別設定できるようにする
            $endDate = $this->startDate->copy()->addDays($defaultDuration);
        }
        $this->endDate = $endDate;

        app(PeriodRecordRepository::class)::upsert($this);
    }
}
