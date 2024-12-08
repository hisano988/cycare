<?php

namespace App\Http\Controllers;

use App\Domain\Models\Cycle;
use App\Domain\Models\PeriodRecord;
use App\Domain\Repositories\PeriodRecordRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function showHome(PeriodRecordRepository $periodRecordRepository)
    {
        $userId = \Auth::id();

        $userPeriodRecords = $periodRecordRepository::getPeriodRecords($userId);
        $cycle = new Cycle($userPeriodRecords);

        return view('home')->with([
            'cycle' => $cycle,
            'records' => $userPeriodRecords,
        ]);
    }

    public function record(Request $requst) // TODO: バリデーション
    {
        $userId = \Auth::id();

        $periodRecord = new PeriodRecord(
            userId: $userId,
            startDate: Carbon::parse($requst->input('start_date')),
            isCalcTarget: (bool) $requst->input('is_calc_target'),
        );
        $periodRecord->record($requst->has('end_date') ? Carbon::parse($requst->input('end_date')) : null);

        return redirect()->route('web.home');
    }
}
