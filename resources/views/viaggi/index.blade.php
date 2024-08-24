@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Lista delle Avventure</h1>
        
        <!-- Pulsante per creare una nuova avventura -->
        <a href="{{ route('viaggi.create') }}" class="btn btn-success mb-3">Crea Nuova Avventura</a>
        
        <!-- Tabella Bootstrap con classe personalizzata -->
        <table class="table table-striped table-hover table-viaggi">
            <thead>
                <tr>
                    <th>IMMAGINE</th>
                    <th>NOME DELL'AVVENTURA</th>
                    <th>META</th>
                    <th>QUANTI GIORNI?</th>
                    <th>PERIODO</th>
                    <th>DETTAGLI</th>
                    <th>AZIONI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viaggi as $viaggio)
                    <tr>
                        <td>
                            @if($viaggio->image)
                                <img src="{{ asset('storage/' . $viaggio->image) }}" alt="Immagine Viaggio" style="width: 100px; height: auto;">
                            @else
                                Nessuna Immagine
                            @endif
                        </td>
                        <td>{{ $viaggio->titolo }}</td>
                        <td>{{ $viaggio->meta }}</td> <!-- Verifica che 'meta' esista e contenga dati -->
                        <td>{{ $viaggio->durata }} giorni</td> <!-- Verifica che 'durata' esista e contenga dati -->
                        <td>{{ $viaggio->periodo }}</td> <!-- Verifica che 'periodo' esista e contenga dati -->
                        <td>{{ $viaggio->dettagli }}</td> <!-- Verifica che 'dettagli' esista e contenga dati -->
                        <td>
                            <!-- Bottoni di azione per visualizzare, modificare e cancellare -->
                            <a href="{{ route('viaggi.show', $viaggio->id) }}" class="btn btn-primary btn-sm">Visualizza</a>
                            <a href="{{ route('viaggi.edit', $viaggio->id) }}" class="btn btn-warning btn-sm">Modifica</a>
                            <form action="{{ route('viaggi.destroy', $viaggio->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection