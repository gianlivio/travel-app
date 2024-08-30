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
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary add-tappa-button" data-giornata-index="${giornataIndex}">Aggiungi Tappa</button>
                `;
                giornateContainer.appendChild(newGiornata);

                const addTappaButton = newGiornata.querySelector('.add-tappa-button');
                addTappaButton.addEventListener('click', function() {
                    const tappaContainer = newGiornata.querySelector('.tappe-container');
                    let tappaCount = tappaContainer.querySelectorAll('.form-group').length;
                    if (tappaCount < maxSteps) {
                        const newTappa = document.createElement('div');
                        newTappa.classList.add('form-group');
                        newTappa.innerHTML = `
                            <label for="giornate[${giornataIndex}][tappe][${tappaCount}][titolo]">Tappa ${tappaCount + 1}</label>
                            <input type="text" class="form-control mb-2" name="giornate[${giornataIndex}][tappe][${tappaCount}][titolo]" placeholder="Titolo Tappa">
                            <textarea class="form-control mb-2" name="giornate[${giornataIndex}][tappe][${tappaCount}][descrizione]" placeholder="Descrizione Tappa"></textarea>
                        `;
                        tappaContainer.appendChild(newTappa);
                    } else {
                        alert('Puoi aggiungere fino a 10 tappe per giornata.');
                    }
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
});