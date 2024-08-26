<!-- Footer -->
<footer class="bg-dark text-white mt-5 p-4 text-center">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5 class="text-uppercase" style="font-family: 'Lato', sans-serif;">Travel App</h5>
                <p>Esplora il mondo con noi.</p>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase" style="font-family: 'Lato', sans-serif;">Navigazione</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('admin.viaggi.index') }}" class="text-white">Viaggi</a></li>
                    
                    <li><a href="{{ route('admin.viaggi.create') }}" class="text-white">Crea Viaggio</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase" style="font-family: 'Lato', sans-serif;">Contatti</h5>
                <ul class="list-unstyled">
                    <li><a href="mailto:info@travelapp.com" class="text-white">info@travelapp.com</a></li>
                    <li><a href="#" class="text-white">LinkedIn</a></li>
                    <li><a href="#" class="text-white">Twitter</a></li>
                </ul>
            </div>
        </div>
        <hr class="bg-light">
        <p class="mb-0">&copy; 2024 Travel App. Tutti i diritti riservati.</p>
    </div>
</footer>