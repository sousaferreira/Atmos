<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>🌤 Mapa Meteorológico - Nordeste</title>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jQuery -->
    
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            color: #3983ce;
            margin-bottom: 20px;
        }

        #weatherMap {
            width: 100%;
            height: 600px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#3983ce; box-shadow:0 2px 6px rgba(0,0,0,0.2);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('sensor.dashboard') }}">🌤 Atmostech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                     <li class="nav-item"><a class="nav-link" href="{{ route('sensor.sobre') }}">💡Sobre Nós</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sensor.gauges') }}">📊 Gauges</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sensor.historico') }}">📈 Histórico</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('sensor.tabela') }}">🗂 Tabela</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('weather.news') }}">📰 Notícias do Clima</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('weather.map') }}">🗺️ Mapa Interativo</a></li>
                     <li class="nav-item"><a class="nav-link" href="{{ route('IA.cloudinha') }}">✨Cloudinha Ia</a></li>

             </ul>
            </div>
        </div>
    </nav>


<div id="weatherMap"></div>

<!-- JS Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // --- CONFIGURAÇÃO ---
    var lat = -8.0;  // centro aproximado do Nordeste
    var lon = -37.0;
    var zoom = 5;

    var apiKey = 'SUA_API_KEY_AQUI'; // Substitua pela sua API Key do OpenWeatherMap

    // Inicializa o mapa
    var map = L.map('weatherMap').setView([lat, lon], zoom);

    // Camada base OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // --- CAMADAS OPENWEATHERMAP ---
    var tempLayer = L.tileLayer(`https://tile.openweathermap.org/map/temp_new/{z}/{x}/{y}.png?appid=${apiKey}`, {
        attribution: 'Map data © OpenWeatherMap',
        opacity: 0.6
    }).addTo(map);

    var windLayer = L.tileLayer(`https://tile.openweathermap.org/map/wind_new/{z}/{x}/{y}.png?appid=${apiKey}`, {
        attribution: 'Map data © OpenWeatherMap',
        opacity: 0.6
    });

    var cloudsLayer = L.tileLayer(`https://tile.openweathermap.org/map/clouds_new/{z}/{x}/{y}.png?appid=${apiKey}`, {
        attribution: 'Map data © OpenWeatherMap',
        opacity: 0.6
    });

    // Controle de camadas
    var overlays = {
        "Temperatura": tempLayer,
        "Vento": windLayer,
        "Nuvens": cloudsLayer
    };
    L.control.layers(null, overlays).addTo(map);

    // --- PEGAR CLIMA AO CLICAR ---
    map.on('click', function(e) {
        var clickLat = e.latlng.lat;
        var clickLon = e.latlng.lng;

        // Limitar ao Brasil
        if (clickLat < -34 || clickLat > 5 || clickLon < -75 || clickLon > -34) {
            alert("Clique dentro do Brasil.");
            return;
        }

        fetch(`/api/weather-click?lat=${clickLat}&lon=${clickLon}`)
        .then(res => res.json())
        .then(data => {
            var info = `
                <b>${data.name || 'Local'}</b><br>
                Temperatura: ${data.main.temp} °C<br>
                Humidade: ${data.main.humidity} %<br>
                Condição: ${data.weather[0].description}<br>
                Vento: ${data.wind.speed} m/s
            `;
            L.popup()
              .setLatLng([clickLat, clickLon])
              .setContent(info)
              .openOn(map);
        })
        .catch(err => {
            L.popup()
              .setLatLng([clickLat, clickLon])
              .setContent("Não foi possível obter os dados do clima")
              .openOn(map);
            console.error(err);
        });
        
    });
</script>

</body>
</html>
