<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Home</title>
    </head>
    <body>
        <div>ホーム画面</div>
        <div>
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
     </body>
</html>
