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

        // Aggiungi l'evento click per il primo bottone "Aggiungi Tappa"
        giornateContainer.querySelectorAll('.add-tappa-button').forEach(button => {
            button.addEventListener('click', function() {
                const giornataIndex = button.dataset.giornataIndex;
                addTappa(giornataIndex, button.closest('.giornata').querySelector('.tappe-container'));
            });
        });

        // Aggiungi l'evento click per il primo bottone "Rimuovi Tappa"
        giornateContainer.querySelectorAll('.remove-tappa-button').forEach(button => {
            button.addEventListener('click', function() {
                const giornataElement = button.closest('.giornata');
                button.closest('.form-group').remove();
                reorderTappe(giornataElement); // Aggiorna gli indici delle tappe
            });
        });

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
                            <textarea class="form-control mb-2" name="giornate[${giornataIndex}][tappe][0][descrizione]" placeholder="Descrizione Tappa"></textarea>
                            <button type="button" class="btn btn-primary remove-tappa-button">Rimuovi Tappa</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary add-tappa-button" data-giornata-index="${giornataIndex}">Aggiungi Tappa</button>
                `;
                giornateContainer.appendChild(newGiornata);

                const addTappaButton = newGiornata.querySelector('.add-tappa-button');
                addTappaButton.addEventListener('click', function() {
                    addTappa(giornataIndex, newGiornata.querySelector('.tappe-container'));
                });

                // Aggiungi l'evento click per i nuovi bottoni "Rimuovi Tappa"
                newGiornata.querySelectorAll('.remove-tappa-button').forEach(button => {
                    button.addEventListener('click', function() {
                        const giornataElement = button.closest('.giornata');
                        button.closest('.form-group').remove();
                        reorderTappe(giornataElement); // Aggiorna gli indici delle tappe
                    });
                });
            } else {
                alert('Puoi aggiungere fino a 10 giornate per viaggio.');
            }
        });
    }

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

    // Funzione per aggiungere una nuova tappa
    function addTappa(giornataIndex, tappaContainer) {
        let tappaCount = tappaContainer.querySelectorAll('.form-group').length;
        if (tappaCount < maxSteps) {
            const newTappa = document.createElement('div');
            newTappa.classList.add('form-group');
            newTappa.innerHTML = `
                <label for="giornate[${giornataIndex}][tappe][${tappaCount}][titolo]">Tappa ${tappaCount + 1}</label>
                <input type="text" class="form-control mb-2" name="giornate[${giornataIndex}][tappe][${tappaCount}][titolo]" placeholder="Titolo Tappa">
                <textarea class="form-control mb-2" name="giornate[${giornataIndex}][tappe][${tappaCount}][descrizione]" placeholder="Descrizione Tappa"></textarea>
                <button type="button" class="btn btn-primary remove-tappa-button">Rimuovi Tappa</button>
            `;
            tappaContainer.appendChild(newTappa);

            // Aggiungi l'evento click per il nuovo bottone "Rimuovi Tappa"
            newTappa.querySelector('.remove-tappa-button').addEventListener('click', function() {
                newTappa.remove();
                reorderTappe(tappaContainer.closest('.giornata')); // Aggiorna gli indici delle tappe
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