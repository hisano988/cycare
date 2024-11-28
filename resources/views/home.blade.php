@php
use Illuminate\Support\Carbon;

$today = Carbon::today();
$startOfMonth = $today->copy()->startOfMonth();
$endOfMonth = $today->copy()->endOfMonth();

// カレンダー表示の初日
$subCntToSunday = $startOfMonth->format('N') % 7;
$startDate = $startOfMonth->copy()->subDays($subCntToSunday);

// カレンダー表示の終日
$addCntToSaturday =  6 - ($endOfMonth->format('N') % 7);
$endDate = $endOfMonth->copy()->addDays($addCntToSaturday);
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ホーム') }}
        </h2>
    </x-slot>

    <div class="modal" tabindex="-1" id="recordModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <form action="{{ route('web.home.record') }}" method="post">
                <div class="modal-header">
                  <h5 class="modal-title">周期を記録する</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                @csrf
                <input class="form-control" type="date" name="start_date" value={{ \Carbon\Carbon::now()->format('Y-m-d') }} />
                <label class="form-check-label" for="isCalcTarget">
                    周期予測の計算対象に含める
                </label>
                <input class="form-check-input" id="isCalcTarget" type="checkbox" name="is_calc_target" checked />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    <div>

    <div class="py-12">
        <div class="d-flex justify-content-center">
            @if ($cycle->isPredictable())
                @php
                    $nextDay = $cycle->predictNextStartDate();
                    $remainingDays = Carbon::today()->diffInDays($nextDay);
                @endphp
                <div>
                @if($remainingDays >= 0)
                    あと<span>{{ $remainingDays }}</span>日
                @else
                    <span>{{ -1 * $remainingDays }}</span>日超過
                @endif
                </div>
            @else
                -
            @endif
        </div>
        <div>
            <table class="table table-bordered">
                <tr>
                    <td class="col-sun">日</td>
                    <td>月</td>
                    <td>火</td>
                    <td>水</td>
                    <td>木</td>
                    <td>金</td>
                    <td class="col-sat">土</td>
                </tr>
                @for($date=$startDate; $date->lte($endDate); $date->addDay())
                    @if($date->isSunday())
                        <tr>
                    @endif
                        <td>
                            <div class="d-flex flex-column">
                                <div class="
                                @if($date->month !== $today->month) col-outed
                                @elseif($date->isToday()) font-weight-bold col-today
                                @elseif($date->isSunday()) col-sun
                                @elseif($date->isSaturday()) col-sat
                                @endif
                                ">{{ $date->day }}</div>
                                <div>@if($date->isSameDay($nextDay)) ● @endif</div>
                            </div>
                        </td>
                    @if($date->isSaturday())
                        </tr>
                    @endif
                @endfor
            </table>
        </div>
        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recordModal">
                記録する
            </button>
        </div>
        <button>設定</button>
    </div>
</x-app-layout>
<style>
    /* TODO: 移動 */
    .modal-dialog{
        display: flex;
        align-items: center;
        min-height: 100%;
    }

    .col-today {
        color:green !important;
    }
    .col-sun {
        color:red !important;
    }
    .col-sat {
        color:blue !important;
    }
    .col-outed {
        color:gray !important;
    }
</style>
