<?php

namespace App\Infrastructure\RepositoryImpl;

use App\Domain\Models\PeriodRecord;
use App\Domain\Repository\PeriodRecordRepository;
use Illuminate\Support\Facades\Log;

class PeriodRecordRepositoryImpl implements PeriodRecordRepository
{
    public static function upsert(PeriodRecord $periodRecord)
    {
        // TODO: DB接続
        Log::debug(json_encode($periodRecord));
        return;
    }
}
