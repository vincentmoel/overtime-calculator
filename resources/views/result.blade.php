<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title>Document</title>
</head>

<body>
    <div style="min-width: 21cm; max-width: 21cm;">
        <header>
            <h3 class="text-center">Lembur Bulan {{ $informations['period'] }}</h3>
        </header>

        <div class="content mt-4">
            <div id="information-name">
                <span>
                    <strong>Nama: {{ $informations['name'] }}</strong>
                </span>
            </div>

            <div class="mt-3" style="min-width: 21cm">
                <div class="d-flex">
                    <div class="flex-fill p-0 border border-dark p-2 text-center"
                        style="min-width: 210px; max-width:210px">
                        Nama Kegiatan
                    </div>
                    <div class="flex-fill p-0 border border-dark p-2 text-center"
                        style="min-width: 252px; max-width:252px">
                        Date/Time
                    </div>
                    <div class="flex-fill p-0 border border-dark p-2 text-center"
                        style="min-width: 100px; max-width:100px">
                        Lembur
                    </div>
                    <div class="flex-fill p-0 border border-dark p-2 text-center"
                        style="min-width: 80px; max-width:80px">
                        Uang
                    </div>
                    <div class="flex-fill p-0 border border-dark p-2 text-center">
                        Transport/Makan
                    </div>
                </div>
                @foreach ($overtimes as $overtime)
                    <div class="d-flex">
                        <div class="p-2 border border-dark text-center" style="min-width: 210px">
                            {{ $overtime['name'] }}
                        </div>
                        <div class="" style="min-width: 252px">
                            @foreach ($overtime['detail'] as $time)
                                <div class="p-1 border border-dark text-center">
                                    {{ $time['from'] }}
                                </div>
                                <div class="p-1 border border-dark text-center">
                                    {{ $time['to'] }}
                                </div>
                            @endforeach
                        </div>

                        <div class="p-3 border border-dark" style="min-width: 100px">
                            {{ $overtime['overtime'] }}
                        </div>
                        <div class="p-3 border border-dark" style="min-width: 80px">
                            {{ $overtime['money'] }}

                        </div>
                        <div class="w-100">
                            <div class="p-1 h-50 w-100 border border-dark text-center">
                                @if ($overtime['transport'] != 0)
                                    {{ $overtime['transport'] }}
                                @endif
                            </div>
                            <div class="p-1 h-50 w-100 border border-dark text-center">
                                @if ($overtime['meal'] != 0)
                                    {{ $overtime['meal'] }}
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
                
            </div>

            <div>
                Total : {{ $totalOvertimeMoney }} - {{ $totalAdditionalMoney }} - {{ $totalAdditionalMoney+$totalOvertimeMoney }}
            </div>

            {{-- <div>
                <table class="table table-bordered border-dark">
                    <thead>
                        <tr class="text-center" style="background-color:#D9D9D9;">
                            <th>Nama Kegiatan</th>
                            <th>Date/Time</th>
                            <th>Lembur</th>
                            <th>Uang</th>
                            <th>Transport + <br> Uang Makan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($overtimes as $overtime)
                            <tr>
                                <td rowspan="6">{{ $overtime['name'] }}</td>
                                <td>6/12/20222 6:00:00 AM</td>
                                <td rowspan="6">{{ $overtime['overtime'] }}</td>
                                <td rowspan="6">{{ $overtime['money'] }}</td>
                                <td rowspan="1">4000</td>
                            </tr>
                            <tr>
                                <td>6/12/20222 11:00:00 AM</td>
                                <td rowspan="1">6000</td>
                            </tr>
                            <tr>
                                <td>6/12/20222 11:00:00 AM</td>
                                <td rowspan="1">6000</td>
                            </tr>
                            <tr>
                                <td>6/12/20222 11:00:00 AM</td>
                                <td rowspan="1">6000</td>
                            </tr>
                            <tr>
                                <td>6/12/20222 11:00:00 AM</td>
                                <td rowspan="1">6000</td>
                            </tr>
                            <tr>
                                <td>6/12/20222 11:00:00 AM</td>
                                <td rowspan="1">6000</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div> --}}
        </div>

    </div>


</body>

</html>

<style>
    td,
    th {
        text-align: center;
        vertical-align: middle;
    }
</style>