@auth
@extends('layouts.app')

@section('content')

<div class="video-background">
    <video autoplay loop muted playsinline>
        <source src="{{ asset('videos/loop.mp4') }}" type="video/mp4">
    </video>
</div>

<div class="container my-4">
    

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
                            <i class="fas fa-calendar-alt"></i> <strong>Periodo:</strong> {{ \Carbon\Carbon::parse($viaggio->data_inizio)->format('d F Y') }} - {{ \Carbon\Carbon::parse($viaggio->data_fine)->format('d F Y') }}
                        </p>
                        <p class="card-text">
                            <i class="fas fa-align-left"></i> <strong>Dettagli:</strong> {{ $viaggio->dettagli }}
                        </p>

                        <!-- Aggiunta della visualizzazione dell'itinerario -->
                        <!-- Inizio della sezione itinerario -->
                        <div class="card info-box"> <!-- Usa la classe info-box per mantenere lo stile -->
                            <div class="card-header">
                                <h4><i class="fas fa-route"></i> Itinerario</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-group itinerary-list">
                                    @if($viaggio->giornate && $viaggio->giornate->isNotEmpty())
                                        @foreach($viaggio->giornate as $giornata)
                                            <li class="list-group-item">
                                                <div class="giornata-details">
                                                    <span class="giornata-date"><i class="fas fa-calendar-day"></i> {{ $giornata->data }}</span>
                                                    <ul class="list-group tappe-list">
                                                        @if($giornata->tappe && $giornata->tappe->isNotEmpty())
                                                            @foreach($giornata->tappe as $tappa)
                                                                <li class="list-group-item tappa-item">{{ $tappa->titolo }}: {{ $tappa->descrizione }}</li>
                                                            @endforeach
                                                        @else
                                                            <li class="list-group-item">Nessuna tappa disponibile</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                    @else
                                        <li class="list-group-item">Nessuna giornata disponibile</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!-- Fine della sezione itinerario -->
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
        <div class="text-center mb-4">
            <a href="{{ route('admin.viaggi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Crea Nuovo Viaggio
            </a>
        </div>
    </div>
</div>

@endsection
@else
<script>window.location.href = '{{ route('login') }}';</script>
@endauth