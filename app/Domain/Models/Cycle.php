<?php

namespace App\Domain\Models;

use App\Exception\PredictException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class Cycle
{
    private Collection $periodRecords;

    private Collection $intervals;

    /**
     * 過去何回を予測に使用するか
     */
    const PREDICTION_RANGE = 10;

    public function __construct(Collection $periodRecords)
    {
        $this->periodRecords = $periodRecords->sortByDesc('startDate')->values();
        $this->setIntervals();
    }

    private function setIntervals()
    {
        // 予測に使用する周期を抽出
        $basePeriod = $this->periodRecords->take(self::PREDICTION_RANGE);

        $this->intervals = $basePeriod->sliding(2)
        // 予測対象外の周期記録を除外する
            ->reject(fn ($periodRecords) => ! $periodRecords->get(1)->isCalcTarget)
        // 間隔計算（日）
            ->map(function ($periodRecords) {
                $beforeRecord = $periodRecords->first();
                $nextRecord = $periodRecords->last();

                return $nextRecord->startDate->diffInDays($beforeRecord->startDate);
            });
    }

    public function avgInterval(): ?int
    {
        if (! $this->isPredictable()) {
            return null;
        }

        return (int) $this->intervals->avg();
    }

    public function isPredictable(): bool
    {
        return $this->periodRecords->count() >= 2;
    }

    public function predictNextStartDate(): ?Carbon
    {
        if (! $this->isPredictable()) {
            throw new PredictException;
        }

        $avgInterval = $this->avgInterval();
        $latestPeriodRecord = $this->periodRecords->first();

        return $latestPeriodRecord->startDate->copy()->addDays($avgInterval);
    }
}
