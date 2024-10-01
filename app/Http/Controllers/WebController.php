<?php

namespace App\Http\Controllers;

use App\Domain\Models\PeriodRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function showHome()
    {
        return view('home');
    }

    public function record(Request $requst) // TODO: バリデーション
    {
        $periodRecord = new PeriodRecord(
            userId: 1, // TODO: モックを外す
            startDate: Carbon::parse($requst->input('start_date')),
            isCalcTarget: (bool) $requst->input('is_calc_target'),
        );
        $periodRecord->record($requst->has('end_date') ? Carbon::parse($requst->input('end_date')) : null);

        return redirect()->route('web.home');
    }
}