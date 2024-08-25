@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h1 class="mb-4 text-center">Diario di Viaggio</h1>
        

        <!-- Griglia di Card -->
        <div class="row">
            @foreach($viaggi as $viaggio)
                <div class="col-md-4">
                    <div class="card mb-3 shadow-sm"> <!-- Le dimensioni possono essere gestite tramite SCSS -->
                        @if($viaggio->image)
                            <img src="{{ asset('storage/' . $viaggio->image) }}" class="card-img-top" alt="Immagine Viaggio">
                        @else
                            <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="Nessuna Immagine">
                        @endif
                        <div class="card-body card-content"> <!-- Maggiore altezza disponibile -->
                            <h5 class="card-title">
                                <i class="fas fa-map-signs"></i> <!-- Icona del titolo -->
                                {{ $viaggio->titolo }}
                            </h5>
                            <p class="card-text">
                                <i class="fas fa-map-marker-alt"></i> <!-- Icona per Meta -->
                                <strong> Itinerario:</strong> {{ $viaggio->meta }}
                            </p>
                            <p class="card-text">
                                <i class="fas fa-clock"></i> <!-- Icona per Durata -->
                                <strong> Durata:</strong> {{ $viaggio->durata }} giorni
                            </p>
                            <p class="card-text">
                                <i class="fas fa-calendar-alt"></i> <!-- Icona per Periodo -->
                                <strong> Periodo:</strong> {{ $viaggio->periodo }}
                            </p>
                            <p class="card-text">
                                <i class="fas fa-align-left"></i> <!-- Icona per Dettagli -->
                                <strong> Dettagli:</strong> {{ $viaggio->dettagli }}
                            </p>
                        </div>
                        <div class="card-footer"> <!-- Sezione per il footer -->
                            <div class="d-flex align-items-center justify-content-start"> <!-- Cambiato a justify-content-start -->
                                <span class="crud-icon me-2" title="Visualizza">
                                    <a href="{{ route('viaggi.show', $viaggio->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </span>
                                <span class="crud-icon me-2" title="Modifica">
                                    <a href="{{ route('viaggi.edit', $viaggio->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </span>
                                <span class="crud-icon" title="Elimina">
                                    <form action="{{ route('viaggi.destroy', $viaggio->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: none; border: none; padding: 0; color: inherit; cursor: pointer;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

                <!-- Pulsante per creare una nuova avventura -->
                <div class="text-center mb-4">
                    <a href="{{ route('viaggi.create') }}" class="btn btn-success">Pianifica il prossimo viaggio</a>
                </div>
        
    </div>
@endsection