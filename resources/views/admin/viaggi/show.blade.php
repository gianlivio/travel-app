@auth
@extends('layouts.app')

@section('content')

<div class="video-background">
    <video autoplay loop muted playsinline>
        <source src="{{ asset('videos/loop1.mp4') }}" type="video/mp4">
    </video>
</div>

<div class="header-section">
    <h3>{{ $viaggio->titolo }}</h3>
</div>

<div class="container my-4">

    <!-- Sezione per l'immagine -->
    @if($viaggio->immagine)
        <div class="text-center mb-4">
            <img src="{{ asset('storage/' . $viaggio->immagine) }}" alt="Immagine Viaggio" class="img-fluid rounded" style="max-width: 80%;">
        </div>
    @else
        <p class="text-center text-muted">Nessuna Immagine disponibile</p>
    @endif

    
    <!-- Contenitore Flex per le informazioni e l'itinerario con dimensioni limitate -->
    <div class="d-flex flex-column flex-lg-row gap-4 mt-4">
        
        <!-- Inizio della sezione informazioni -->
        <div class="card flex-fill" style="max-width: 500px;">
            <div class="card-header">
                <h4><i class="fas fa-info-circle"></i> Informazioni sul Viaggio</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-2">
                        <p><i class="fas fa-map-marker-alt"></i> <strong>Meta:</strong> {{ $viaggio->meta }}</p>
                    </div>
                    <div class="col-12 mb-2">
                        <p><i class="fas fa-clock"></i> <strong>Durata:</strong> {{ $viaggio->durata }} giorni</p>
                    </div>
                    <div class="col-12 mb-2">
                        <p class="card-text">
                            <i class="fas fa-calendar-alt"></i> <strong>Periodo:</strong> {{ \Carbon\Carbon::parse($viaggio->data_inizio)->format('d F Y') }} - {{ \Carbon\Carbon::parse($viaggio->data_fine)->format('d F Y') }}
                        </p>
                    </div>
                    <div class="col-12 mb-2">
                        <p><i class="fas fa-info-circle"></i> <strong>Dettagli:</strong> {{ $viaggio->dettagli ?? 'Nessun dettaglio disponibile' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fine della sezione informazioni -->

        <!-- Inizio della sezione itinerario -->
            <div class="card flex-fill info-box">
                <div class="card-header">
                    <h4><i class="fas fa-route"></i> Itinerario</h4>
                </div>
                <div class="card-body">
                    @if($viaggio->giornate && $viaggio->giornate->isNotEmpty())
                        <ul class="list-group itinerary-list">
                            @foreach($viaggio->giornate as $giornata)
                                <li class="list-group-item">
                                    <div class="giornata-details mb-2">
                                        <strong><i class="fas fa-calendar-day"></i> Giornata:</strong> {{ \Carbon\Carbon::parse($giornata->data)->format('d F Y') }}
                                    </div>
                                    @if($giornata->tappe && $giornata->tappe->isNotEmpty())
                                        <ul class="list-group tappe-list">
                                            @foreach($giornata->tappe as $tappa)
                                                <li class="list-group-item">
                                                    <strong>{{ $tappa->titolo }}</strong>
                                                    <p>{{ $tappa->descrizione ?? 'Nessuna descrizione disponibile' }}</p> <!-- Aggiungi la descrizione qui -->
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Nessuna tappa disponibile per questa giornata</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Nessun itinerario disponibile</p>
                    @endif
                </div>
            </div>
            <!-- Fine della sezione itinerario -->

    </div>

    <!-- Sezione per la Mappa -->
    <div id="map" data-tappe='@json($tappe)' style="width: 100%; height: 400px;" class="mb-4"></div>

    <!-- Pulsanti di Azione -->
    <div class="mt-4 text-center">
        <a href="{{ route('admin.viaggi.edit', $viaggio->id) }}" class="btn btn-primary"><i class="fas fa-edit"></i> Modifica</a>
        <a href="{{ route('admin.viaggi.index') }}" class="btn btn-secondary"><i class="fas fa-list"></i> Torna alla lista</a>
    </div>
</div>
<script>
    
    const TOMTOM_API_KEY = "{{ env('TOMTOM_API_KEY') }}";
</script>


@endsection
@endauth