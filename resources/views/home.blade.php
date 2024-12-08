@php
use Illuminate\Support\Carbon;
@endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('ホーム') }}
        </h2>
    </x-slot>

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
        <div id="app">
            <Calender
                default-year-month="{{ Carbon::today()->format('Y-m') }}"
                :records='@json($records->toArray())'
                interval="{{ $cycle->avgInterval() }}"
            ></Calender>
        </div>
    </div>
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

        <div class="d-flex justify-content-center">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#recordModal">
                記録する
            </button>
        </div>
        <button>設定</button>
    </div>
</x-app-layout>
<style>
    .modal-dialog{
        display: flex;
        align-items: center;
        min-height: 100%;
    }
</style>
