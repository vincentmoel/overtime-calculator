@extends('template.main')

@section('container')
    <h2 class="mb-4">Profile</h2>

    <form action="/users/{{ auth()->user()->id }}" method="POST">
        @method("PATCH")
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="text" name="name" class="form-control" value="{{ $user->name }}" id="name">
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" class="form-control" value="{{ $user->username }}" id="username">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="password">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
      </form>
@endsection
