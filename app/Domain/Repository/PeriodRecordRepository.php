<?php

namespace App\Domain\Repository;

use App\Domain\Models\PeriodRecord;

interface PeriodRecordRepository
{
    public static function upsert(PeriodRecord $periodRecord);
}
