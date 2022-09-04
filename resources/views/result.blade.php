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
    <title>Lembur Bulan {{ $informations['period'] }}</title>
</head>

<body class="p-3">
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
                    <div class="flex-fill border border-dark p-2 text-center"
                        style="min-width: 210px; max-width:210px">
                        Nama Kegiatan
                    </div>
                    <div class="flex-fill border border-dark p-2 text-center"
                        style="min-width: 231px; max-width:252px">
                        Date/Time
                    </div>
                    <div class="flex-fill border border-dark p-2 text-center"
                        style="min-width: 100px; max-width:100px">
                        Lembur
                    </div>
                    <div class="flex-fill border border-dark p-2 text-center"
                        style="min-width: 135px; max-width:135px">
                        Transport/Makan
                    </div>
                    <div class="flex-fill border border-dark p-2 text-center">
                        Uang
                    </div>
                </div>
                @foreach ($overtimes as $overtime)
                    <div class="d-flex">
                        <div class="p-2 border border-dark text-center" style="min-width: 210px">
                            {{ $overtime['name'] }}
                        </div>
                        <div class="" style="min-width: 231px">
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
                        <div class="" style="min-width: 135px">
                            <div class="p-1 h-50 w-100 border border-dark text-center">
                                @if ($overtime['transport'] != 0)
                                    {{ "Rp " . number_format($overtime['transport'],0,',','.'); }}

                                @endif
                            </div>
                            <div class="p-1 h-50 w-100 border border-dark text-center">
                                @if ($overtime['meal'] != 0)
                                    {{ "Rp " . number_format($overtime['meal'],0,',','.'); }}

                                @endif
                            </div>

                        </div>
                        <div class="w-100">
                            
                            <div class="p-3 h-100 border border-dark">
                                {{ "Rp " . number_format($overtime['money'],0,',','.'); }}
                                
    
                            </div>
                        </div>

                    </div>
                @endforeach
                
            </div>

            <div class="d-flex justify-content-end mt-2">
                <div class="me-3 fw-bolder">
                    Total : {{ "Rp " . number_format($totalMoney,0,',','.'); }}
                </div>
                {{-- <div>
                    <div class="d-flex ">
                        <div class="text-center">
                            {{ "Rp " . number_format($totalOvertimeMoney,0,',','.'); }}
                        </div>
                        <div>
                            +
                        </div>
                        <div class="text-center">
                            {{ "Rp " . number_format($totalAdditionalMoney,0,',','.'); }}
                        </div>
                    </div>
                    <div class="fw-bolder">
                        = {{ "Rp " . number_format($totalAdditionalMoney+$totalOvertimeMoney,0,',','.'); }}
                    </div>
                </div> --}}
            </div>
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
