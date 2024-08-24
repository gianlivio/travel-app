@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Lista dei Viaggi</h1>
        
        <!-- Tabella Bootstrap -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>NOME VIAGGIO</th>
                    <th>META</th>
                    <th>DURATA</th>
                    <th>PERIODO</th>
                    <th>DETTAGLI</th>
                    <th>AZIONI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($viaggi as $viaggio)
                    <tr>
                        <td>{{ $viaggio->titolo }}</td>
                        <td>{{ $viaggio->meta }}</td> <!-- Supponiamo che 'meta' sia un campo nel database -->
                        <td>{{ $viaggio->durata }}</td> <!-- Supponiamo che 'durata' sia un campo nel database -->
                        <td>{{ $viaggio->periodo }}</td> <!-- Supponiamo che 'periodo' sia un campo nel database -->
                        <td>{{ $viaggio->descrizione }}</td> <!-- Puoi mostrare altre info o aggiungerne altre -->
                        <td>
                            <a href="{{ route('viaggi.show', $viaggio->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('viaggi.edit', $viaggio->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('viaggi.destroy', $viaggio->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo viaggio?');">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Pulsante per Creare un Nuovo Viaggio -->
        <a href="{{ route('viaggi.create') }}" class="btn btn-primary mt-3">Crea un nuovo viaggio</a>
    </div>
@endsection