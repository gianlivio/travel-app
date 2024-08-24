@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crea un Nuovo Viaggio</h1>

        <!-- Pulsante "Indietro" -->
        <a href="{{ route('viaggi.index') }}" class="btn btn-secondary mb-3">Indietro</a>

        <form action="{{ route('viaggi.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="titolo" class="form-label">Titolo</label>
                <input type="text" class="form-control" id="titolo" name="titolo" placeholder="Inserisci il titolo del viaggio" required>
            </div>

            <div class="mb-4">
                <label for="descrizione" class="form-label">Descrizione</label>
                <textarea class="form-control" id="descrizione" name="descrizione" rows="3" placeholder="Descrivi brevemente il viaggio"></textarea>
            </div>

            <!-- Sezione Tappe -->
            <div class="mb-4" id="tappe-container">
                <h3 class="mb-3">Tappe</h3>
                <div class="input-group mb-3">
                    <input type="text" id="localita-search" class="form-control" placeholder="Inserisci una località">
                    <button type="button" class="btn btn-outline-secondary" onclick="addTappa()">Aggiungi Tappa</button>
                </div>
                <ul id="tappe-list" class="list-group">
                    <!-- Le tappe aggiunte dinamicamente saranno mostrate qui -->
                </ul>
            </div>

            <!-- Pulsanti di Azione -->
            <button type="submit" class="btn btn-primary">Salva Viaggio</button>
            <a href="{{ route('viaggi.index') }}" class="btn btn-secondary">Annulla</a>
        </form>
    </div>

    <script>
        const tappeList = document.getElementById('tappe-list');

        function addTappa() {
            const searchInput = document.getElementById('localita-search');
            const localita = searchInput.value.trim();
            if (localita === '') {
                alert('Inserisci una località per aggiungere una tappa.');
                return;
            }

            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.textContent = localita;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'tappe[]';
            hiddenInput.value = localita;
            li.appendChild(hiddenInput);

            const removeBtn = document.createElement('button');
            removeBtn.className = 'btn btn-danger btn-sm';
            removeBtn.textContent = 'Rimuovi';
            removeBtn.onclick = function () {
                tappeList.removeChild(li);
            };
            li.appendChild(removeBtn);

            tappeList.appendChild(li);
            searchInput.value = '';
        }
    </script>
@endsection