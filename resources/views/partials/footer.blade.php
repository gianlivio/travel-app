<footer class="text-white mt-5 p-4 text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Travel App</h5>
                <p>Organizza con noi le tue avventure per il mondo</p>
            </div>
            <div class="col-md-4">
                <h5>Navigazione</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('admin.viaggi.index') }}">Viaggi</a></li>
                    <li><a href="{{ route('admin.viaggi.create') }}">Crea Viaggio</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Contatti</h5>
                <ul class="list-unstyled">
                    <li><a href="mailto:info@travelapp.com">info@travelapp.com</a></li>
                    <li><a href="#">LinkedIn</a></li>
                    <li><a href="#">Twitter</a></li>
                </ul>
            </div>
        </div>
        <hr class="bg-light">
        <p class="mb-0">&copy; 2024 Travel App. Tutti i diritti riservati.</p>
    </div>
</footer>