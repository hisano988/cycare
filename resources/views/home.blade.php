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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <div>
                    @if ($cycle->isPredictable())
                        @php
                            $nextDay = $cycle->predictNextStartDate();
                            $remainingDays = Carbon::today()->diffInDays($nextDay);
                        @endphp
                        @if($remainingDays >= 0)
                            あと{{ $remainingDays }}日
                        @else
                            {{ -1 * $remainingDays }}日超過
                        @endif
                    @else
                        -
                    @endif
                </div>
                <div>
                    <form action="{{ route('web.home.record') }}" method="post">
                        @csrf
                        <input type="text" name="start_date" value={{ \Carbon\Carbon::now()->format('Y-m-d') }} />
                        <input type="checkbox" name="is_calc_target" checked />
                        <button type="submit">記録する</button>
                    </form>
                </div>
                <button>設定</button>
                    </div>
            </div>
        </div>
    </div>
</x-app-layout>
