@extends('layouts.app')

@section('content')
    <h1>Lista dei Viaggi</h1>
    <ul>
        @foreach($viaggi as $viaggio)
            <li>
                <a href="{{ route('viaggi.show', $viaggio->id) }}">{{ $viaggio->titolo }}</a>
            </li>
        @endforeach
    </ul>
    <a href="{{ route('viaggi.create') }}">Crea un nuovo viaggio</a>
@endsection