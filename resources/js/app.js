import "./bootstrap";
import "~resources/scss/app.scss";
import.meta.glob(["../img/**"]);
import * as bootstrap from "bootstrap";

document.addEventListener('DOMContentLoaded', function() {
    const maxSteps = 10;
    const itineraryContainer = document.getElementById('itinerary-container');
    const addStepButton = document.getElementById('add-step-button');

    if (addStepButton) {
        addStepButton.addEventListener('click', function() {
            const stepCount = itineraryContainer.querySelectorAll('.form-group').length;
            if (stepCount < maxSteps) {
                const newStep = document.createElement('div');
                newStep.classList.add('form-group');
                newStep.innerHTML = `
                    <label for="tappa_${stepCount + 1}">Tappa ${stepCount + 1}</label>
                    <input type="text" class="form-control" id="tappa_${stepCount + 1}" name="tappe[]" placeholder="Descrizione Tappa ${stepCount + 1}">
                `;
                itineraryContainer.insertBefore(newStep, addStepButton);
            } else {
                alert('Puoi aggiungere fino a 10 tappe.');
            }
        });
    }
});