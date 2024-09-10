import "./bootstrap";
import "~resources/scss/app.scss";
import.meta.glob(["../img/**"]);
import * as bootstrap from "bootstrap";

document.addEventListener('DOMContentLoaded', function() {
    
    const maxSteps = 10;
    const maxDays = 10;
    const giornateContainer = document.getElementById('giornate-container');
    const addGiornataButton = document.getElementById('add-giornata-button');
    const dettagliTextarea = document.getElementById('dettagli');
    const maxCharCount = 500;
    let charCountDisplay;

    if (giornateContainer && addGiornataButton) {
        let giornataCount = giornateContainer.querySelectorAll('.giornata').length;

        // Aggiungi evento per tappe esistenti al caricamento della pagina
        giornateContainer.querySelectorAll('.add-tappa-button').forEach(button => {
            button.addEventListener('click', function() {
                const giornataIndex = button.dataset.giornataIndex;
                addTappa(giornataIndex, button.closest('.giornata').querySelector('.tappe-container'));
            });
        });

        // Rimuovi tappa
        giornateContainer.querySelectorAll('.remove-tappa-button').forEach(button => {
            button.addEventListener('click', function() {
                const giornataElement = button.closest('.giornata');
                button.closest('.form-group').remove();
                reorderTappe(giornataElement); // Aggiorna gli indici delle tappe
            });
        });

        // Aggiungi nuova giornata
        addGiornataButton.addEventListener('click', function() {
            if (giornataCount < maxDays) {
                const giornataIndex = giornataCount;
                giornataCount++;
                const newGiornata = document.createElement('div');
                newGiornata.classList.add('giornata', 'mb-3');
                newGiornata.innerHTML = `
                    <div class="form-group">
                        <label for="giornate[${giornataIndex}][data]">Data Giornata</label>
                        <input type="date" class="form-control mb-2" name="giornate[${giornataIndex}][data]" required>
                    </div>
                    <div class="tappe-container">
                        <div class="form-group">
                            <label for="giornate[${giornataIndex}][tappe][0][titolo]">Tappa 1</label>
                            <input type="text" class="form-control mb-2" name="giornate[${giornataIndex}][tappe][0][titolo]" placeholder="Titolo Tappa">
                            <input type="hidden" name="giornate[${giornataIndex}][tappe][0][meta]" class="meta-input">
                            <div class="autocomplete-results"></div>
                            <!-- Campo per Dettagli -->
                            <textarea class="form-control mb-2" name="giornate[${giornataIndex}][tappe][0][descrizione]" placeholder="Descrizione Tappa"></textarea>
                            <button type="button" class="btn btn-primary remove-tappa-button">Rimuovi Tappa</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary add-tappa-button" data-giornata-index="${giornataIndex}">Aggiungi Tappa</button>
                `;
                giornateContainer.appendChild(newGiornata);
        
                // Aggiungi evento per aggiungere tappe
                const addTappaButton = newGiornata.querySelector('.add-tappa-button');
                addTappaButton.addEventListener('click', function() {
                    addTappa(giornataIndex, newGiornata.querySelector('.tappe-container'));
                });
        
                // Aggiungi evento per rimuovere tappa
                newGiornata.querySelectorAll('.remove-tappa-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const giornataElement = button.closest('.giornata');
                        button.closest('.form-group').remove();
                        reorderTappe(giornataElement); // Aggiorna gli indici delle tappe
                    });
                });

                // Aggiungi autocompletamento alla prima tappa
                const tappaInput = newGiornata.querySelector('input[name$="[titolo]"]');
                const hiddenField = newGiornata.querySelector('input[name$="[meta]"]');
                enableAutocompleteForTappa(tappaInput, hiddenField);
            } else {
                alert('Puoi aggiungere fino a 10 giornate per viaggio.');
            }
        });
    }

    // Contatore caratteri per i dettagli
    if (dettagliTextarea) {
        charCountDisplay = document.createElement('div');
        charCountDisplay.className = 'char-count';
        dettagliTextarea.parentNode.insertBefore(charCountDisplay, dettagliTextarea.nextSibling);

        charCountDisplay.textContent = `0 / ${maxCharCount} caratteri`;

        dettagliTextarea.addEventListener('input', function() {
            const currentLength = dettagliTextarea.value.length;
            charCountDisplay.textContent = `${currentLength} / ${maxCharCount} caratteri`;

            if (currentLength > maxCharCount) {
                dettagliTextarea.value = dettagliTextarea.value.substring(0, maxCharCount);
                charCountDisplay.textContent = `${maxCharCount} / ${maxCharCount} caratteri`;
            }
        });
    }

    // Funzione per l'autocompletamento
    function enableAutocompleteForTappa(inputElement, hiddenField) {
        inputElement.addEventListener('input', function() {
            const query = this.value;
            const resultsDiv = document.createElement('div');
            resultsDiv.classList.add('list-group', 'autocomplete-results');
    
            const existingResultsDiv = inputElement.parentNode.querySelector('.autocomplete-results');
            if (existingResultsDiv) {
                existingResultsDiv.remove();
            }
    
            if (query.length > 2) {
                const url = `https://api.tomtom.com/search/2/search/${query}.json?key=${TOMTOM_API_KEY}`;
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        resultsDiv.innerHTML = '';
    
                        data.results.forEach(result => {
                            const resultItem = document.createElement('a');
                            resultItem.href = '#';
                            resultItem.classList.add('list-group-item', 'list-group-item-action');
                            resultItem.innerText = result.address.freeformAddress;
    
                            resultItem.addEventListener('click', function(e) {
                                e.preventDefault();
                                inputElement.value = result.address.freeformAddress;
                                hiddenField.value = result.address.freeformAddress; // Popola il campo meta
    
                                resultsDiv.remove();
                                e.stopPropagation();
                            });
    
                            resultsDiv.appendChild(resultItem);
                        });
    
                        inputElement.parentNode.appendChild(resultsDiv);
    
                        document.addEventListener('click', function handleClickOutside(event) {
                            if (!resultsDiv.contains(event.target) && !inputElement.contains(event.target)) {
                                resultsDiv.remove();
                                document.removeEventListener('click', handleClickOutside);
                            }
                        });
                    })
                    .catch(error => console.error('Errore nella ricerca della posizione:', error));
            }
        });
    }

    // Aggiungi autocompletamento per tutte le tappe esistenti
    function addAutocompleteToAllTappe() {
        document.querySelectorAll('.tappe-container .form-group').forEach(tappa => {
            const tappaInput = tappa.querySelector('input[name$="[titolo]"]');
            const hiddenField = tappa.querySelector('input[name$="[meta]"]');
            enableAutocompleteForTappa(tappaInput, hiddenField);
        });
    }

    addAutocompleteToAllTappe();  // Aggiungi autocompletamento alle tappe già presenti

    // Funzione per aggiungere una nuova tappa
    function addTappa(giornataIndex, tappaContainer) {
        let tappaCount = tappaContainer.querySelectorAll('.form-group').length;
        if (tappaCount < maxSteps) {
            const newTappa = document.createElement('div');
            newTappa.classList.add('form-group');
            newTappa.innerHTML = `
                <label for="giornate[${giornataIndex}][tappe][${tappaCount}][titolo]">Tappa ${tappaCount + 1}</label>
                <input type="text" class="form-control mb-2" name="giornate[${giornataIndex}][tappe][${tappaCount}][titolo]" placeholder="Titolo Tappa">
                <input type="hidden" name="giornate[${giornataIndex}][tappe][${tappaCount}][meta]" class="meta-input">
                <div class="autocomplete-results"></div>
                <!-- Campo per Dettagli -->
                <textarea class="form-control mb-2" name="giornate[${giornataIndex}][tappe][${tappaCount}][descrizione]" placeholder="Descrizione Tappa"></textarea>
                <button type="button" class="btn btn-primary remove-tappa-button">Rimuovi Tappa</button>
            `;
            tappaContainer.appendChild(newTappa);
    
            // Applica autocompletamento alla nuova tappa
            const tappaInput = newTappa.querySelector('input[name$="[titolo]"]');
            const hiddenField = newTappa.querySelector('input[name$="[meta]"]');
            enableAutocompleteForTappa(tappaInput, hiddenField);
    
            // Aggiungi evento per rimuovere la tappa
            newTappa.querySelector('.remove-tappa-button').addEventListener('click', function() {
                newTappa.remove();
                reorderTappe(tappaContainer.closest('.giornata'));
            });
        } else {
            alert('Puoi aggiungere fino a 10 tappe per giornata.');
        }
    }

    // Funzione per riordinare le tappe
    function reorderTappe(giornataElement) {
        const tappe = giornataElement.querySelectorAll('.tappe-container .form-group');
        tappe.forEach((tappa, index) => {
            const labels = tappa.querySelectorAll('label');
            labels.forEach(label => {
                label.innerText = `Tappa ${index + 1}`;
            });

            const inputs = tappa.querySelectorAll('input, textarea');
            inputs.forEach(input => {
                if (input.name.includes('[titolo]')) {
                    input.name = `giornate[${giornataElement.dataset.giornataIndex}][tappe][${index}][titolo]`;
                } else if (input.name.includes('[descrizione]')) {
                    input.name = `giornate[${giornataElement.dataset.giornataIndex}][tappe][${index}][descrizione]`;
                }
            });
        });
    }

    // --- CODICE PER LA MAPPA ---

    const mapContainer = document.getElementById('map');

    if (mapContainer) {
        const tappeData = JSON.parse(mapContainer.dataset.tappe);

        if (TOMTOM_API_KEY) {
            var map = tt.map({
                key: TOMTOM_API_KEY,
                container: 'map',
                center: [12.4964, 41.9028], // Centro iniziale su Roma
                zoom: 5
            });

            const bounds = new tt.LngLatBounds();
            const coordinates = [];

            tappeData.forEach(tappa => {
                if (tappa.latitude && tappa.longitude) {
                    new tt.Marker()
                        .setLngLat([tappa.longitude, tappa.latitude])
                        .addTo(map);

                    coordinates.push([tappa.longitude, tappa.latitude]);
                    bounds.extend([tappa.longitude, tappa.latitude]);
                }
            });

            if (tappeData.length > 0) {
                map.fitBounds(bounds, { padding: 50 });
            }

            if (coordinates.length > 1) {
                map.addLayer({
                    id: 'route-line',
                    type: 'line',
                    source: {
                        type: 'geojson',
                        data: {
                            type: 'Feature',
                            geometry: {
                                type: 'LineString',
                                coordinates: coordinates
                            }
                        }
                    },
                    layout: {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    paint: {
                        'line-color': '#FF0000',
                        'line-width': 3
                    }
                });
            }
        } else {
            console.error('TomTom API Key non è stata trovata.');
        }
    }
});


$(function() {
    // Inizializzazione delle date di inizio e fine con valori di default
    let startDate = moment(); // Default: oggi
    let endDate = moment().add(1, 'days'); // Default: domani

    // Controlla se ci sono valori nei campi nascosti
    if ($('#data_inizio').val()) {
        startDate = moment($('#data_inizio').val(), 'YYYY-MM-DD');
    }
    if ($('#data_fine').val()) {
        endDate = moment($('#data_fine').val(), 'YYYY-MM-DD');
    }

    // Inizializza il daterangepicker
    $('#date_range').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD',
            applyLabel: 'Applica',
            cancelLabel: 'Annulla',
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
            monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno',
                         'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
            firstDay: 1
        },
        startDate: startDate,
        endDate: endDate,
        autoUpdateInput: false, // Imposta su false per gestire manualmente l'aggiornamento dell'input
    }, function(start, end) {
        // Aggiorna i valori dei campi nascosti
        $('#data_inizio').val(start.format('YYYY-MM-DD'));
        $('#data_fine').val(end.format('YYYY-MM-DD'));
        // Mostra le date nel formato leggibile nell'input visibile
        $('#date_range').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
    });

    // Evento per l'applicazione delle date selezionate
    $('#date_range').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        $('#data_inizio').val(picker.startDate.format('YYYY-MM-DD'));
        $('#data_fine').val(picker.endDate.format('YYYY-MM-DD'));
    });

    // Evento per il reset dei campi in caso di annullamento
    $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        $('#data_inizio').val('');
        $('#data_fine').val('');
    });

    // Imposta l'input al caricamento della pagina se i campi nascosti hanno valori
    if ($('#data_inizio').val() && $('#data_fine').val()) {
        $('#date_range').val(
            moment($('#data_inizio').val()).format('YYYY-MM-DD') + ' - ' +
            moment($('#data_fine').val()).format('YYYY-MM-DD')
        );
    } else {
        // Se i campi sono vuoti, imposta i valori di default nell'input
        $('#date_range').val(startDate.format('YYYY-MM-DD') + ' - ' + endDate.format('YYYY-MM-DD'));
    }
});




