@extends('layouts.app')

@section('content')
<h2 class="mb-5 text-center fw-bold" style="color: #333; font-size: 2rem;">🌤 Estação Meteorológica - Ao Vivo</h2>

<div class="row g-4 justify-content-center">

    <!-- Temperatura -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card sensor-card shadow-lg p-4 text-center border-0" style="border-radius: 1.5rem; background: linear-gradient(145deg, #ffe5e5, #fff0f0); transition: transform 0.3s, box-shadow 0.3s;">
            <div class="sensor-emoji mb-2" id="emojiTemp" style="font-size: 2rem;">🌡</div>
            <div class="sensor-title mb-3 fw-semibold" style="font-size: 1.2rem;">Temperatura</div>
            <div id="gaugeTemp"></div>
        </div>
    </div>

    <!-- Umidade -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card sensor-card shadow-lg p-4 text-center border-0" style="border-radius: 1.5rem; background: linear-gradient(145deg, #e5f0ff, #f0faff); transition: transform 0.3s, box-shadow 0.3s;">
            <div class="sensor-emoji mb-2" id="emojiUmidade" style="font-size: 2rem;">💧</div>
            <div class="sensor-title mb-3 fw-semibold" style="font-size: 1.2rem;">Umidade</div>
            <div id="gaugeUmidade"></div>
        </div>
    </div>

    <!-- Luminosidade -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card sensor-card shadow-lg p-4 text-center border-0" style="border-radius: 1.5rem; background: linear-gradient(145deg, #fffbe6, #fff0c8); transition: transform 0.3s, box-shadow 0.3s;">
            <div class="sensor-emoji mb-2" id="emojiLum" style="font-size: 2rem;">🌞</div>
            <div class="sensor-title mb-3 fw-semibold" style="font-size: 1.2rem;">Luminosidade</div>
            <div id="gaugeLuminosidade"></div>
        </div>
    </div>

    <!-- Chuva -->
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card sensor-card shadow-lg p-4 text-center border-0" style="border-radius: 1.5rem; background: linear-gradient(145deg, #e5f7ff, #d0f0ff); transition: transform 0.3s, box-shadow 0.3s;">
            <div class="sensor-emoji mb-2" id="emojiChuva" style="font-size: 2rem;">☔</div>
            <div class="sensor-title mb-3 fw-semibold" style="font-size: 1.2rem;">Chuva</div>
            <div id="gaugeChuva"></div>
        </div>
    </div>

</div>

<style>
.sensor-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 18px 35px rgba(0,0,0,0.2);
}
.sensor-emoji {
    transition: transform 0.3s;
}
.sensor-emoji:hover {
    transform: scale(1.4);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
// Função para criar gauges
function criarGauge(selector, valor, label, unidade, cor){
    const chart = new ApexCharts(document.querySelector(selector), {
        chart: { type: 'radialBar', height: 200, offsetY: -10 },
        series: [valor],
        labels: [label],
        colors: [cor],
        plotOptions: { 
            radialBar: { 
                hollow: { size: '55%' },
                track: { background: '#e1e1e1', strokeWidth: '100%' },
                dataLabels: { 
                    name: { fontSize: '16px', color: '#555' },
                    value: { fontSize:'22px', formatter: val => Math.round(val) + " " + unidade }
                } 
            } 
        },
        stroke: { lineCap: 'round' },
    });
    chart.render();
    return chart;
}

// Criação dos gauges
const gaugeTemp = criarGauge("#gaugeTemp", 0, "°C", "°C", "#FF4C4C");
const gaugeUmidade = criarGauge("#gaugeUmidade", 0, "%", "%", "#4C8BFF");
const gaugeChuva = criarGauge("#gaugeChuva", 0, "mm", "mm", "#00BFFF");

const gaugeLuminosidade = criarGauge("#gaugeLuminosidade", 0, "Luminosidade", "%", "#FFA500");

// Atualização ao vivo + emojis dinâmicos
function atualizarGauges(){
    $.getJSON("{{ url('/sensor-data-json') }}", function(ultimo){
        if(!ultimo) return;

        let temp = Math.round(ultimo.temperature || 0);
        let hum = Math.round(ultimo.humidity || 0);
        let rain = Math.round(ultimo.rain || 0);
        let lum = Math.round(ultimo.luminosity || 0); // valor real, não invertido

        gaugeTemp.updateSeries([temp]);
        gaugeUmidade.updateSeries([hum]);
        gaugeChuva.updateSeries([rain]);
        gaugeLuminosidade.updateSeries([lum]);

        // Emojis dinâmicos
        $('#emojiTemp').text(temp <= 15 ? '❄️' : temp <= 25 ? '🌡' : '🔥');
        $('#emojiUmidade').text(hum <= 30 ? '💧' : hum <= 70 ? '💦' : '🌊');
        $('#emojiLum').text(lum <= 20 ? '🌙' : lum <= 70 ? '🌤' : '☀️');
        $('#emojiChuva').text(rain === 0 ? '☀️' : rain <= 10 ? '🌦' : '🌧');
    });
}

// Inicializa atualização
atualizarGauges();
setInterval(atualizarGauges, 5000);
</script>
@endsection
