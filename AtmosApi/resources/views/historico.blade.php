@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-5 text-center fw-bold text-primary">📈 Histórico de Sensores - Atmostech</h2>

    <!-- Filtro simplificado apenas por dia -->
    <div class="row justify-content-center mb-5 g-2">
        <div class="col-md-4">
            <input type="date" id="dateInput" class="form-control text-center fw-bold shadow-sm" placeholder="Dia">
        </div>
        <div class="col-md-2">
            <button id="filterBtn" class="btn btn-primary w-100 shadow-sm">🔍 Filtrar</button>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row g-4">
        @foreach ([
            'temperature' => ['🌡 Temperatura', '#FF4C4C'],
            'humidity' => ['💧 Umidade', '#4C8BFF'],
            'luminosity' => ['🌞 Luminosidade', '#FFA500'],
            'rain' => ['🌧 Chuva', '#00BFFF']
        ] as $id => $info)
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm p-3 h-100">
                <h5 class="fw-bold mb-3" style="color: {{ $info[1] }};">{{ $info[0] }}</h5>
                <canvas id="chart{{ $id }}" height="200"></canvas>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
const sensores = {
    'temperature': { label: 'Temperatura', color: '#FF4C4C', invert: false },
    'humidity': { label: 'Umidade', color: '#4C8BFF', invert: false },
    'luminosity': { label: 'Luminosidade', color: '#FFA500', invert: true },
    'rain': { label: 'Chuva', color: '#00BFFF', invert: false }
};

let charts = {};

// Função para criar ou atualizar gráficos
function atualizarGraficos(filtroDia = ''){
    $.getJSON("{{ url('/sensor-historico-json') }}", { date: filtroDia }, function(data){
        const labels = data.map(item => item.hora || '');
        
        Object.keys(sensores).forEach(id => {
            const valores = data.map(item => sensores[id].invert ? 100 - (item[id] ?? 0) : (item[id] ?? 0));

            if(charts[id]){
                charts[id].data.labels = labels;
                charts[id].data.datasets[0].data = valores;
                charts[id].update();
            } else {
                charts[id] = new Chart(document.getElementById('chart' + id).getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: sensores[id].label,
                            data: valores,
                            borderColor: sensores[id].color,
                            backgroundColor: sensores[id].color + '33',
                            fill: true,
                            tension: 0.3,
                            pointRadius: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
                        scales: {
                            x: { display: true, title: { display: true, text: 'Hora / Dia' } },
                            y: { display: true, beginAtZero: true }
                        }
                    }
                });
            }
        });
    });
}

// Inicializa com data atual
atualizarGraficos($('#dateInput').val());

// Atualiza ao clicar no botão
$('#filterBtn').click(function(){ atualizarGraficos($('#dateInput').val()); });
</script>
@endsection
