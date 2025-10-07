<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🌤 Estação Meteorológica</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">

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

                    <li class="nav-item"><a class="nav-link" href="{{ route('compare.index') }}">📋 Comparar Leituras</a></li>
                     <li class="nav-item"><a class="nav-link" href="{{ route('IA.cloudinha') }}">✨Cloudinha Ia</a></li>
             </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo -->
    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Permite que cada view injete scripts -->
    @yield('scripts')

</body>
</html>
