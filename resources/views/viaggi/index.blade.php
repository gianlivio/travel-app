@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h1 class="mb-4 text-center">Diario di Viaggio</h1>
        
        <!-- Pulsante per creare una nuova avventura -->
        <div class="text-center mb-4">
            <a href="{{ route('viaggi.create') }}" class="btn btn-success">Crea Nuova Avventura</a>
        </div>

        <!-- Griglia di Card -->
        <div class="row">
            @foreach($viaggi as $viaggio)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        @if($viaggio->image)
                            <img src="{{ asset('storage/' . $viaggio->image) }}" class="card-img-top" alt="Immagine Viaggio">
                        @else
                            <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="Nessuna Immagine">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-map-signs"></i> <!-- Icona del titolo -->
                                {{ $viaggio->titolo }}
                            </h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt"></i> <!-- Icona per Meta -->
                                <strong> Meta:</strong> {{ $viaggio->meta }}
                            </p>
                            <p class="card-text">
                                <i class="fas fa-clock"></i> <!-- Icona per Durata -->
                                <strong> Durata:</strong> {{ $viaggio->durata }} giorni
                            </p>
                            <p class="card-text">
                                <i class="fas fa-calendar-alt"></i> <!-- Icona per Periodo -->
                                <strong> Periodo:</strong> {{ $viaggio->periodo }}
                            </p>
                            <p class="card-text">{{ Str::limit($viaggio->dettagli, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('viaggi.show', $viaggio->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Visualizza
                                </a>
                                <a href="{{ route('viaggi.edit', $viaggio->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Modifica
                                </a>
                                <form action="{{ route('viaggi.destroy', $viaggio->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Elimina
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection