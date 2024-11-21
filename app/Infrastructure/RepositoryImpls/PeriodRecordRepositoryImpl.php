<?php

namespace App\Infrastructure\RepositoryImpls;

use App\Domain\Models\PeriodRecord;
use App\Domain\Repositories\PeriodRecordRepository;
use App\Infrastructure\Eloquents\EloquentPeriodRecord;
use Illuminate\Support\Carbon;

class PeriodRecordRepositoryImpl implements PeriodRecordRepository
{
    public static function getPeriodRecords(int $userId)
    {
        return EloquentPeriodRecord::where('user_id', $userId)
            ->get()
            ->map(fn (EloquentPeriodRecord $eloquent) => self::newPeriodRecordModel($eloquent));
    }

    public static function upsert(PeriodRecord &$periodRecord)
    {
        if (isset($periodRecord->periodRecordId)) {
            $eloquent = EloquentPeriodRecord::find($periodRecord->periodRecordId);
        } else {
            $eloquent = new EloquentPeriodRecord;
        }
        $eloquent->user_id = $periodRecord->userId;
        $eloquent->start_date = $periodRecord->startDate;
        $eloquent->end_date = $periodRecord->endDate;
        $eloquent->is_calc_target = $periodRecord->isCalcTarget;
        $eloquent->save();

        $periodRecord->periodRecordId = $eloquent->period_record_id;
    }

    private static function newPeriodRecordModel(EloquentPeriodRecord $eloquent)
    {
        $model = new PeriodRecord(
            userId: $eloquent->user_id,
            startDate: Carbon::parse($eloquent->start_date),
            isCalcTarget: (bool) $eloquent->is_calc_target,
        );
        $model->periodRecordId = $eloquent->period_record_id;
        $model->endDate = is_null($eloquent->end_date) ? null : Carbon::parse($eloquent->end_date);

        return $model;
    }
}
