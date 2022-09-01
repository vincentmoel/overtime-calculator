@extends('template.main')

@section('container')
    <h2 class="mb-4">Configs</h2>

    @foreach ($configs as $config)
      <form action="/configs/{{ $config->id }}" method="POST" class="mb-4">
        @csrf
        <label for="exampleInputEmail1" class="form-label">{{ $config->name }}</label>
        <div class="input-group">
          <input type="text" name="value" class="form-control" value="{{ $config->value }}">
          <button class="btn btn-outline-secondary" type="submit">Save</button>
        </div>
        <div id="emailHelp" class="form-text">Description: {{ $config->description }}</div>

      </form>

      
    @endforeach
@endsection
