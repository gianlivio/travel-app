# Travel App

## Descrizione Generale
Travel App è un'applicazione web pensata per la pianificazione e la gestione dei viaggi. Consente agli utenti di creare un diario di viaggio per le loro vacanze, suddividere il viaggio in giornate e tappe, e aggiungere dettagli come descrizioni, immagini, cibo, curiosità, e molto altro. Le tappe sono visualizzate su una mappa interattiva, e l'utente può tenere traccia dei progressi del proprio viaggio.

## Obiettivo
L'obiettivo del progetto è di compiere delle scelte progettuali ponderate, saperle motivare e documentare, e presentare il tutto in maniera strutturata. Il progetto prevede anche di affrontare e risolvere eventuali criticità emerse durante lo sviluppo.

## Funzionalità Principali
- **Creazione di Viaggi:** Possibilità di creare e gestire più viaggi.
- **Pianificazione di Giornate:** Suddividere un viaggio in giornate, ciascuna con diverse tappe da visitare.
- **Dettagli delle Tappe:** Aggiungere dettagli come titolo, descrizione, data, immagini, cibo, curiosità, ecc.
- **Visualizzazione su Mappa:** Le tappe del viaggio sono visualizzate su una mappa interattiva.
- **Progressione delle Tappe:** Tenere traccia della progressione delle tappe, anche dopo la chiusura della pagina.
- **Funzionalità Aggiuntive:** Aprire il dettaglio di una tappa o immagine in una modale, aggiungere note durante il viaggio, valutazioni delle tappe.

## Tecnologie Utilizzate
- **Backend:** Laravel per la gestione delle API e della logica server-side.
- **Frontend:** Vite e Vue.js per lo sviluppo dell'interfaccia utente.
- **Database:** MySQL o SQLite per la persistenza dei dati.
- **Mappe:** API di Google Maps, OpenStreetMap, o altro servizio di mappe.
- **Hosting:** Netlify, Vercel, Heroku, o altro servizio di hosting.

## Installazione e Setup

### Requisiti
- PHP >= 8.1
- Composer
- Node.js con npm
- MySQL o SQLite

### Istruzioni
1. Clonare il repository: `git clone https://github.com/username/travel-app.git`
2. Navigare nella directory del progetto: `cd travel-app`
3. Installare le dipendenze di Laravel: `composer install`
4. Creare un file `.env` a partire da `.env.example` e configurare le variabili d'ambiente, incluse quelle per il database.
5. Generare una chiave applicativa: `php artisan key:generate`
6. Eseguire le migrazioni del database: `php artisan migrate`
7. Installare le dipendenze del frontend: `npm install`
8. Avviare l'applicazione Laravel: `php artisan serve`
9. Avviare il server di sviluppo Vite: `npm run dev`
10. Accedere all'applicazione tramite il browser all'indirizzo `http://localhost:3000`

## Milestone
1. **Progettazione e Pianificazione:** Definire i requisiti funzionali e non funzionali dell'app e creare un wireframe dell'interfaccia utente. Progettare una soluzione tecnologica adeguata. Pianificare le attività da svolgere per arrivare alla deadline.
2. **Setup Ambiente e Progetto:** Configurare l’ambiente di sviluppo, definire un setup di progetto (strumenti, build tools, git, ecc.) e inizializzare il progetto.
3. **Definizione di uno Stato (Struttura dei Dati):** Definire la struttura dati idonea a rappresentare un viaggio e tutti i suoi dettagli.
4. **Sviluppo Layout e Componenti UI:** Sviluppare la struttura di layout e dei componenti della pagina.
5. **Logica Applicativa:** Implementare la logica di render dell’interfaccia a partire dal dato strutturato.
6. **Persistenza:** Implementare la funzionalità per salvare la progressione delle tappe e garantire che i dati siano mantenuti anche dopo la chiusura della pagina.
7. **Deployment:** Caricare il codice su un servizio di hosting.
8. **Documentazione:** Scrivere un README completo per documentare requisiti, installazione e funzionalità.


If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
