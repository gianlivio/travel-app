
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista dei Viaggi</h1>
        <ul class="list-group">
            @foreach($viaggi as $viaggio)
                <li class="list-group-item">
                    <a href="{{ route('viaggi.show', $viaggio->id) }}">{{ $viaggio->titolo }}</a>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('viaggi.create') }}" class="btn btn-primary mt-3">Crea un nuovo viaggio</a>
    </div>
@endsection