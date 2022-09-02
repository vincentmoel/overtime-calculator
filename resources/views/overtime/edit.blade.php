@extends('template.main')

@section('container')
    <h2 class="mb-4">Create Overtimes</h2>

    @php
    setlocale(LC_ALL, 'IND');
    $currentMonth = strftime('%B', strtotime(date('Y-m-d')));
    @endphp



    <form action="/overtimes/{{ $data[0]['id'] }}" method="POST" id="form-overtime">
        @method('PATCH')
        @csrf
        <div class="d-flex">

            <div class="mb-3 me-3">
                <label for="month" class="form-label">Month</label>
                <select name="month" id="" class="form-control" style="min-width: 150px;" required>
                    @php
                        $monthArr = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                    @endphp

                    @foreach ($monthArr as $month)
                        <option value="{{ $month }}" @if ($month == $data[0]['month']) selected @endif>
                            {{ $month }}</option>
                    @endforeach
                </select>
                {{-- <input type="text" id="month" class="form-control" style="max-width: 250px"> --}}
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" id="year" name="year" class="form-control" value="{{ $data[0]['year'] }}"
                    style="max-width: 150px" required>
            </div>
            <input type="hidden" name="json" value="">
        </div>

        <div class="mb-3">
    
            <button class="btn btn-primary" id="add-event"><i class="bi bi-plus-circle"></i> Add Event</button>
            <button class="btn btn-success" id="btn-submit" type="submit">Submit</button>
        </div>
    </form>


    <div id="events-wrapper">
        @php
            $increment = 1
        @endphp
        @foreach($data as $d)
            <div class="card mb-3" id="event-wrapper-{{ $increment }}" style="background-color: #FAFAFA">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4>Event</h4>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteEvent({{ $increment }})">Delete</button>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" name="nameEvent" value="{{ $d['name'] }}" required>
                    </div>
            
            
                    <div class="mb-3">
                        Config :
                        <div class="d-flex">
            
                            @foreach ($configs as $config)
                                <div class="form-check me-3">
                                    <input class="form-check-input" type="checkbox" value="true" id="{{ $config->slug ."-". $increment }}" name="{{ $config->slug }}" @if($d[$config->slug]) checked @endif>
                                    <label class="form-check-label" for="{{ $config->slug ."-". $increment }}">
                                        {{ $config->alias }}
                                    </label>
                                </div>
                            @endforeach
            
                        </div>
                    </div>
            
                    <button class="btn btn-outline-danger mb-3" id="add-overtime-{{ $increment }}" onclick="deleteOvertime({{ $increment }})">Delete Overtime</button>
                    <button class="btn btn-outline-success mb-3" id="add-overtime-{{ $increment }}" onclick="addOvertime({{ $increment }})">Add Overtime</button>
            
                    <div id="overtime-wrapper-{{ $increment }}">
                        @foreach($d['overtimes'] as $overtime)
                            <div class="time-wrapper mb-2">
                                <div class="separator mx-auto mb-3"></div>
                                <div class="d-flex justify-content-center">
                                    <div class="mb-3 me-3">
                                        <label for="from" class="form-label">From</label>
                                        <input type="text" id="from" name="from[]" class="form-control" value="{{ $overtime['from'] }}" style="max-width: 300px" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="to" class="form-label">To</label>
                                        <input type="text" id="to" class="form-control" name="to[]" value="{{ $overtime['to'] }}" style="max-width: 300px" required>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
            
                </div>
            </div>
            @php
                $increment++;
            @endphp
        @endforeach
    </div>


    <style>
        .separator {
            width: 300px;
            height: 1px;
            background-color: rgba(0, 0, 0, 0.125);
        }
    </style>


    <script>
        var increment = {{ $increment }};

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
            var arrSubmit = [];
            $("*[id^='event-wrapper-']").each(function() {
                arrTemp = {};

                arrTemp['name'] = $(this).find('input[name="nameEvent"]').val();

                @foreach ($configs as $config)
                    arrTemp["{{ $config->slug }}"] = $(this).find('input[name="{{ $config->slug }}"]').is(
                        ':checked');
                @endforeach

                arrTemp['overtimes'] = overtimeParser(this);

                arrSubmit.push(arrTemp);
            });

            $('input[name="json"]').val(JSON.stringify(arrSubmit));
            
            // $("#form-overtime").submit();
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

            for (let i = 0; i < arrFrom.length; i++) {
                arrOvertime.push({
                    "from": arrFrom[i],
                    "to": arrTo[i]
                })
            }

            return arrOvertime;
        }
    </script>
@endsection
