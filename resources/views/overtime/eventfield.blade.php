<div class="card mb-3" style="background-color: #FAFAFA">
    <div class="card-body">
        <h4>Event</h4>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Name</label>
            <input type="text" class="form-control">
        </div>


        <div class="mb-3">
            Config :
            <div class="d-flex">

                @foreach ($configs as $config)
                    <div class="form-check me-3">
                        <input class="form-check-input" type="checkbox" value="" id="{{ $config->slug }}">
                        <label class="form-check-label" for="{{ $config->slug }}">
                            {{ $config->alias }}
                        </label>
                    </div>
                @endforeach

            </div>
        </div>

        <button class="btn btn-secondary mb-3" id="add-overtime">Add Overtime</button>

        <div class="" id="overtime-field">
            @include('overtime.timefield')
        </div>
    </div>
</div>
