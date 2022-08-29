@extends('template.main')

@section('container')
    <h2 class="mb-4">Create Overtimes</h2>

    @php
    setlocale(LC_ALL, 'IND');
    $currentMonth = strftime('%B', strtotime(date('Y-m-d')));
    @endphp



    <form>

        <div class="d-flex">

            <div class="mb-3 me-3">
                <label for="month" class="form-label">Month</label>
                <select name="" id="" class="form-control" style="min-width: 150px;">
                    @php
                        $monthArr = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    @endphp

                    @foreach ($monthArr as $month)
                        <option value="{{ $month }}" @if ($month == $currentMonth) selected @endif>
                            {{ $month }}</option>
                    @endforeach
                </select>
                {{-- <input type="text" id="month" class="form-control" style="max-width: 250px"> --}}
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="text" id="year" class="form-control" value="{{ date('Y') }}"
                    style="max-width: 150px">
            </div>
        </div>

    </form>

    <div class="mb-3">

        <button class="btn btn-primary" id="add-event"><i class="bi bi-plus-circle"></i> Add Event</button>
        <button class="btn btn-success" id="btn-submit">Submit</button>
    </div>

    <div id="events-wrapper">
        @include('overtime.eventfield')
    </div>


    <style>
        .separator {
            width: 300px;
            height: 1px;
            background-color: rgba(0, 0, 0, 0.125);
        }
    </style>


    <script>
        var increment = 2;

        // Nambah Event
        $("#add-event").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "/overtimes/jquery/add-event/" + increment,
                success: function(result) {
                    increment++;
                    $("#events-wrapper").append(result);
                },
                error: function(result) {
                    alert('Error, try again!');
                }
            });
        });


        function addOvertime(incrementOvertime) {
            // e.preventDefault();
            $.ajax({
                type: "GET",
                url: "/overtimes/jquery/add-overtime",
                success: function(result) {
                    $("#overtime-wrapper-" + incrementOvertime).append(result);
                },
                error: function(result) {
                    alert('Error, try again!');
                }
            });
        }

        function deleteEvent(incrementEvent) {
            $("#event-wrapper-" + incrementEvent).remove();
        }

        function deleteOvertime(incrementOvertime) {
            $('#overtime-wrapper-' + incrementOvertime).children().last().remove();
        }

        $("#btn-submit").click(function(e) {
            var arrSubmit = {};
            $("*[id^='event-wrapper-']").each(function() {
                arrTemp = {};

                arrTemp['name'] = $(this).find('input[name="nameEvent"]').val();

                @foreach ($configs as $config)
                    arrTemp["{{ $config->slug }}"] = $(this).find('input[name="{{ $config->slug }}"]').is(':checked');
                @endforeach

                arrTemp['overtimes'] = overtimeParser(this);

                console.log(arrTemp);
            });
        });

        function overtimeParser(element) {
            arrOvertime = [];

            arrFrom = [];
            $(element).find('input[name="from[]"]').each(function() {
                arrFrom.push(this.value);
            });

            arrTo = [];
            $(element).find('input[name="to[]"]').each(function() {
                arrTo.push(this.value);
            });

            for(let i = 0; i < arrFrom.length; i++)
            {
                arrOvertime.push({"from" : arrFrom[i], "to" : arrTo[i]})
            }

            return arrOvertime;
        }
    </script>
@endsection
