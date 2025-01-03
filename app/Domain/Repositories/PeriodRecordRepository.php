<?php

namespace App\Domain\Repositories;

use App\Domain\Models\PeriodRecord;

interface PeriodRecordRepository
{
    public static function getPeriodRecords(int $userId);

    public static function upsert(PeriodRecord &$periodRecord);
}
