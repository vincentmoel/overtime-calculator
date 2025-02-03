@extends('template.main')

@section('container')
    <h2 class="mb-4">Overtimes</h2>

    <a href="/overtimes/create" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Create Data
    </a>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Month</th>
                <th scope="col">Year</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;    
            @endphp

            @foreach ($overtimeGroups as $overtimeGroup)
            <tr>
                <th scope="row">{{ $no++ }}</th>
                <td>{{ $overtimeGroup->month }}</td>
                <td>{{ $overtimeGroup->year }}</td>
                <td>
                    <a href="/result/{{ $overtimeGroup->id }}" target="_blank" class="btn btn-secondary mb-xxl-0"><i class="bi bi-file-earmark-arrow-down"></i></a>
                    <a href="/overtimes/{{ $overtimeGroup->id }}/edit" class="btn btn-dark mb-xxl-0"><i class="bi bi-pencil-square"></i></a>
                    <form action="/overtimes/{{ $overtimeGroup->id }}" method="POST" class="d-inline" id="form-delete">
                        @method('DELETE')
                        @csrf
                        <button class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete Data?')"><i class="bi bi-trash3-fill"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection
