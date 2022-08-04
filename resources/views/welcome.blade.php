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
    <div class="container p-5">
        <header>
            <h3 class="text-center">Lembur Bulan {{ $informations['period'] }}</h3>
        </header>

        <div class="content mt-4">
            <div id="information-name">
                <span>
                    <strong>Nama: {{ $informations['name'] }}</strong>
                </span>
            </div>

            <div>
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
                        <tr>
                            <td rowspan="2">Ibadah HUT</td>
                            <td>6/12/20222 5:00:00 AM</td>
                            <td rowspan="2">5:20:01</td>
                            <td rowspan="2">Rp41.000</td>
                            <td>4000</td>
                        </tr>
                        <tr>
                            <td>6/12/20222 11:00:00 AM</td>
                            <td>6000</td>
                        </tr>


                        {{-- <tr>
                            <td rowspan="4">Ibadah Minggu</td>
                            <td>6/12/20222 5:00:00 AM</td>
                            <td rowspan="4">5:20:01</td>
                            <td rowspan="4">Rp41.000</td>
                            <td>4000</td>
                        </tr>
                        <tr>
                            <td>6/12/20222 11:00:00 AM</td>
                            <td>6000</td>
                        </tr>
                        <tr>
                            <td>6/12/20222 11:00:00 AM</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>6/12/20222 11:00:00 AM</td>
                            <td></td>
                            
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>

    </div>


</body>

</html>

<style>
    td,th {
        text-align: center;
        vertical-align: middle;
    }
</style>
