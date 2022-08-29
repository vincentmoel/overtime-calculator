@php
    $increment = isset($increment) ? $increment : 1
@endphp

<div class="card mb-3" id="event-wrapper-{{ $increment }}" style="background-color: #FAFAFA">
    <div class="card-body">
        <div class="d-flex justify-content-between">
            <h4>Event</h4>
            <button class="btn btn-sm btn-outline-danger" onclick="deleteEvent({{ $increment }})">Delete</button>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control" name="nameEvent">
        </div>


        <div class="mb-3">
            Config :
            <div class="d-flex">

                @foreach ($configs as $config)
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="true" id="{{ $config->slug ."-". $increment }}" name="{{ $config->slug }}">
                        <label class="form-check-label" for="{{ $config->slug ."-". $increment }}">
                            {{ $config->alias }}
                        </label>
                    </div>
                @endforeach

            </div>
        </div>

        <button class="btn btn-outline-dark mb-3" id="add-overtime-{{ $increment }}" onclick="deleteOvertime({{ $increment }})">Delete Overtime</button>
        <button class="btn btn-outline-success mb-3" id="add-overtime-{{ $increment }}" onclick="addOvertime({{ $increment }})">Add Overtime</button>

        <div id="overtime-wrapper-{{ $increment }}">
            @include('overtime.timefield')
        </div>

    </div>
</div>
