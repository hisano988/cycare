<?php

namespace App\Infrastructure\RepositoryImpls;

use App\Domain\Models\PeriodRecord;
use App\Domain\Repositories\PeriodRecordRepository;
use App\Infrastructure\Eloquents\EloquentPeriodRecord;

class PeriodRecordRepositoryImpl implements PeriodRecordRepository
{
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
}
