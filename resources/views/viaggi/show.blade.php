@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ $viaggio->titolo }}</h1>

        <!-- Dettagli del Viaggio -->
        <div class="card mb-4">
            <div class="card-header">
                Dettagli del Viaggio
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $viaggio->titolo }}</h5>
                <p class="card-text">{{ $viaggio->descrizione }}</p>
                
                <!-- Visualizzazione dell'immagine del viaggio -->
                @if($viaggio->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $viaggio->image) }}" alt="Immagine Viaggio" style="width: 200px; height: auto;">
                    </div>
                @endif

               
            </div>
        </div>

        <!-- Sezione Giornate -->
        <div class="card mb-4">
            <div class="card-header">
                Giornate
            </div>
            <ul class="list-group list-group-flush">
                @foreach($viaggio->giornate as $giornata)
                    <li class="list-group-item">
                        <strong>{{ $giornata->data }}</strong>: {{ $giornata->descrizione }}
                        <div class="float-end">
                            <a href="{{ route('giornate.edit', $giornata->id) }}" class="btn btn-warning btn-sm">Modifica</a>
                            <form action="{{ route('giornate.destroy', $giornata->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Sezione Tappe -->
        <div class="card mb-4">
            <div class="card-header">
                Tappe
            </div>
            <ul class="list-group list-group-flush">
                @foreach($viaggio->tappe as $tappa)
                    <li class="list-group-item">
                        <strong>Località:</strong> {{ $tappa->localita }} 
                        <span class="badge bg-secondary">{{ $tappa->ordine }}</span>
                        <div class="float-end">
                            <a href="{{ route('tappe.edit', $tappa->id) }}" class="btn btn-warning btn-sm">Modifica</a>
                            <form action="{{ route('tappe.destroy', $tappa->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Elimina</button>
                            </form>
                        </div>
                        <!-- L'immagine della tappa potrebbe essere diversa o la stessa del viaggio -->
                        <!-- Se si vuole mostrare un'immagine specifica della tappa, bisognerebbe cambiare la logica qui -->
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Pulsanti di Navigazione -->
        <a href="{{ route('viaggi.index') }}" class="btn btn-secondary">Torna alla lista dei viaggi</a>
        <a href="{{ route('viaggi.edit', $viaggio->id) }}" class="btn btn-primary">Modifica Viaggio</a>
    </div>
@endsection