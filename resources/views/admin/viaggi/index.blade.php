@auth
@extends('layouts.app')

@section('content')

<div class="video-background">
    <video autoplay loop muted playsinline>
        <source src="{{ asset('videos/loop.mp4') }}" type="video/mp4">
    </video>
</div>

<div class="container my-4">
    <!-- Contenuto esistente non modificato -->
    <div class="text-right mb-4">
        <a href="{{ route('admin.viaggi.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle"></i> Crea Nuovo Viaggio
        </a>
    </div>

    <!-- Griglia di Card -->
    <div class="row">
        @foreach($viaggi as $viaggio)
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    @if($viaggio->immagine)
                        <img src="{{ asset('storage/' . $viaggio->immagine) }}" class="card-img-top" alt="Immagine Viaggio">
                    @else
                        <img src="{{ asset('images/default.png') }}" class="card-img-top" alt="Nessuna Immagine">
                    @endif
                    <div class="card-body card-content">
                        <h5 class="card-title">
                            <i class="fas fa-plane"></i> {{ $viaggio->titolo }}
                        </h5>
                        <p class="card-text">
                            <i class="fas fa-map-marker-alt"></i> <strong>Meta:</strong> {{ $viaggio->meta }}
                        </p>
                        <p class="card-text">
                            <i class="fas fa-clock"></i> <strong>Durata:</strong> {{ $viaggio->durata }} giorni
                        </p>
                        <p class="card-text">
                            <i class="fas fa-calendar-alt"></i> <strong>Periodo:</strong> {{ $viaggio->periodo }}
                        </p>
                        <p class="card-text">
                            <i class="fas fa-align-left"></i> <strong>Dettagli:</strong> {{ $viaggio->dettagli }}
                        </p>

                        <!-- Aggiunta della visualizzazione dell'itinerario -->
                        <p><strong>Itinerario:</strong>
                            <ul>
                                @foreach($viaggio->tappe as $tappa)
                                    <li>{{ $tappa->descrizione }}</li>
                                @endforeach
                            </ul>
                        </p>
                        <!-- Fine della visualizzazione dell'itinerario -->
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center justify-content-start">
                            <!-- Icona Visualizza con stile -->
                            <span class="crud-icon me-2" title="Visualizza">
                                <a href="{{ route('admin.viaggi.show', $viaggio->id) }}" class="btn btn-link p-0 m-0 border-0">
                                    <i class="fas fa-eye text-primary rounded-circle border border-primary p-2"></i>
                                </a>
                            </span>
                            <!-- Icona Modifica con stile -->
                            <span class="crud-icon me-2" title="Modifica">
                                <a href="{{ route('admin.viaggi.edit', $viaggio->id) }}" class="btn btn-link p-0 m-0 border-0">
                                    <i class="fas fa-edit text-warning rounded-circle border border-warning p-2"></i>
                                </a>
                            </span>
                            <!-- Icona Elimina con stile -->
                            <form action="{{ route('admin.viaggi.destroy', $viaggio->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 m-0 border-0" title="Elimina">
                                    <i class="fas fa-trash-alt text-danger rounded-circle border border-danger p-2"></i>
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
@else
<script>window.location.href = '{{ route('login') }}';</script>
@endauth