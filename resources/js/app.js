import "./bootstrap";
import "~resources/scss/app.scss";
import.meta.glob(["../img/**"]);
import * as bootstrap from "bootstrap";

document.addEventListener('DOMContentLoaded', function() {
    const maxSteps = 10;
    const itineraryContainer = document.getElementById('itinerary-container');
    const addStepButton = document.getElementById('add-step-button');
    const dettagliTextarea = document.getElementById('dettagli');
    const maxCharCount = 500; // Limite massimo di caratteri
    let charCountDisplay;

    if (itineraryContainer && addStepButton) {
        let tappaCount = itineraryContainer.querySelectorAll('.form-group').length;

        addStepButton.addEventListener('click', function() {
            if (tappaCount < maxSteps) {
                tappaCount++;
                const newStep = document.createElement('div');
                newStep.classList.add('form-group');
                newStep.innerHTML = `
                    <label for="tappa_${tappaCount}">Tappa ${tappaCount}</label>
                    <input type="text" class="form-control" id="tappa_${tappaCount}" name="tappe[]" placeholder="Descrizione Tappa ${tappaCount}">
                `;
                itineraryContainer.appendChild(newStep);

                // Aggiungere la classe per la scrollbar dopo la quinta tappa
                if (tappaCount > 5) {
                    itineraryContainer.classList.add('itinerary-scroll');
                }
            } else {
                alert('Puoi aggiungere fino a 10 tappe.');
            }
        });
    }

    // Controllo del contatore di caratteri per la textarea dettagli
    if (dettagliTextarea) {
        charCountDisplay = document.createElement('div');
        charCountDisplay.id = 'char-count';
        charCountDisplay.classList.add('text-muted', 'text-right', 'mt-1');
        dettagliTextarea.parentNode.appendChild(charCountDisplay);
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
});