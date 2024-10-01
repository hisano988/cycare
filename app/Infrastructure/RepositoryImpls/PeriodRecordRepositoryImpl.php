<?php

namespace App\Infrastructure\RepositoryImpls;

use App\Domain\Models\PeriodRecord;
use App\Domain\Repositories\PeriodRecordRepository;
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
