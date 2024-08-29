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

                if (tappaCount > 5) {
                    itineraryContainer.classList.add('itinerary-scroll');
                }
            } else {
                alert('Puoi aggiungere fino a 10 tappe.');
            }
        });
    }

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

    let currentIndex = 0;
    const images = [
        '/images/a.jpg',
        '/images/b.jpg',
        '/images/c.jpg',
        '/images/d.jpg',
        '/images/e.jpg',
        '/images/f.jpg',
        '/images/g.jpg'
    ];

    function changeBackgroundImage() {
        const body = document.body;
        body.classList.remove('fade-background'); // Rimuovi la classe per resettare la transizione
        setTimeout(() => {
            body.style.backgroundImage = `url(${images[currentIndex]})`;
            body.style.backgroundSize = 'cover';  // Copre l'intera area
            body.style.backgroundRepeat = 'no-repeat';  // Non ripete l'immagine
            body.style.backgroundPosition = 'center';  // Centra l'immagine
            body.style.opacity = '1'; // Imposta l'opacità a 1 per assicurare che non siano opache
            currentIndex = (currentIndex + 1) % images.length;
            body.classList.add('fade-background'); // Aggiungi la classe dopo il cambiamento
        }, 50); // Attendi un breve momento prima di riaggiungere la classe per la transizione
    }

    setInterval(changeBackgroundImage, 5000); // Cambia immagine ogni 5 secondi
    changeBackgroundImage(); // Chiamata iniziale per impostare la prima immagine
});