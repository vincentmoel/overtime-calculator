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
        <button class="btn btn-success">Submit</button>
    </div>

    <div id="event-field">
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
        $("#add-event").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "/overtimes/jquery/add-event",
                success: function(result) {
                    $("#event-field").append(result);
                },
                error: function(result) {
                    alert('Error, try again!');
                }
            });
        });
        
        $("#add-overtime").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "GET",
                url: "/overtimes/jquery/add-overtime",
                success: function(result) {
                    $("#overtime-field").append(result);
                },
                error: function(result) {
                    alert('Error, try again!');
                }
            });
        });
    </script>
@endsection
