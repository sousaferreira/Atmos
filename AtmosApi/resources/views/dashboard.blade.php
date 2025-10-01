@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-center">Estação Meteorológica - AtmosTech</h1>

    <div class="row mb-4">
        <!-- Gauges -->
        <div class="col-md-3">
            <div class="card p-3">
                <h5 class="card-title">🌡️ Temperatura</h5>
                <div class="position-relative">
                    <canvas id="tempGauge" width="200" height="200"></canvas>
                    <div id="tempValue" class="position-absolute" style="left:0;right:0;top:70px;text-align:center;font-weight:700;font-size:24px;">-- °C</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <h5 class="card-title">💧 Umidade</h5>
                <div class="position-relative">
                    <canvas id="humGauge" width="200" height="200"></canvas>
                    <div id="humValue" class="position-absolute" style="left:0;right:0;top:70px;text-align:center;font-weight:700;font-size:24px;">-- %</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <h5 class="card-title">🌞 Luminosidade</h5>
                <div class="position-relative">
                    <canvas id="lumGauge" width="200" height="200"></canvas>
                    <div id="lumValue" class="position-absolute" style="left:0;right:0;top:70px;text-align:center;font-weight:700;font-size:24px;">--</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3">
                <h5 class="card-title">☔ Chuva</h5>
                <div class="position-relative">
                    <canvas id="rainGauge" width="200" height="200"></canvas>
                    <div id="rainValue" class="position-absolute" style="left:0;right:0;top:70px;text-align:center;font-weight:700;font-size:24px;">-- mm</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left: Histórico gráfico + tabela -->
        <div class="col-lg-8">
            <div class="card mb-4 p-3">
                <h5>📈 Histórico de Temperatura (hoje)</h5>
                <canvas id="historyChart" height="150"></canvas>
            </div>

            <div class="card p-3">
                <h5>📝 Últimos Dados</h5>
                <div class="table-responsive">
                    <table class="table table-striped" id="latestTable">
                        <thead>
                            <tr>
                                <th>Data/Hora</th>
                                <th>Temp (°C)</th>
                                <th>Umidade (%)</th>
                                <th>Luminosidade</th>
                                <th>Chuva (mm)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- preenchido pelo JS -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Previsão + Alertas -->
        <div class="col-lg-4">
            <div class="card mb-4 p-3" id="forecastCard">
                <h5>⛅ Previsão (7 dias)</h5>
                <div id="forecastContent">
                    <p class="text-muted">Digite uma cidade e clique em Buscar:</p>
                    <div class="input-group mb-2">
                        <input type="text" id="cityInput" class="form-control" placeholder="Ex: Pato Branco">
                        <button id="btnFetchWeather" class="btn btn-primary">Buscar</button>
                    </div>
                    <div id="forecastResult"></div>
                </div>
            </div>

            <div class="card p-3" id="alertsCard">
                <h5>⚠️ Alertas</h5>
                <div id="alertsArea">
                    <p class="text-muted">Nenhum alerta por enquanto.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function createGauge(ctx, color) {
        return new Chart(ctx, {
            type: 'doughnut',
            data: { labels: ['value','rest'], datasets: [{ data: [0,100], backgroundColor:[color,'#e9ecef'], borderWidth:0, cutout:'75%' }] },
            options: { responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false }, tooltip:{ enabled:false } } }
        });
    }

    const tempGauge = createGauge(document.getElementById('tempGauge').getContext('2d'), '#ff6b6b');
    const humGauge  = createGauge(document.getElementById('humGauge').getContext('2d'), '#4da6ff');
    const lumGauge  = createGauge(document.getElementById('lumGauge').getContext('2d'), '#ff9f43');
    const rainGauge = createGauge(document.getElementById('rainGauge').getContext('2d'), '#6f42c1');

    const historyCtx = document.getElementById('historyChart').getContext('2d');
    const historyChart = new Chart(historyCtx, {
        type: 'line',
        data: { labels:[], datasets:[{label:'Temperatura (°C)', data:[], fill:true, tension:0.3}] },
        options: { responsive:true, plugins:{ legend:{ display:false } }, scales:{ x:{ display:true }, y:{ display:true, beginAtZero:false } } }
    });

    function updateGauges(data) {
        if(!data) return;

        const temp = Number(data.temperature ?? data.temp ?? 0);
        const hum  = Number(data.humidity ?? 0);
        let lum   = Number(data.luminosity ?? 0);
        const rain = Number(data.rain ?? 0);

        // Normaliza luminosidade para 0-100 se estiver em outra escala
        if(lum > 100) lum = Math.round((lum / 1023) * 100);
        const normalizedLum = Math.min(Math.max(lum, 0), 100);

        // Temperatura
        const tempVal = Math.min(Math.max(temp, 0), 100);
        tempGauge.data.datasets[0].data = [tempVal, 100 - tempVal];
        tempGauge.update();
        document.getElementById('tempValue').innerText = `${temp} °C`;

        // Umidade
        const humVal = Math.min(Math.max(hum, 0), 100);
        humGauge.data.datasets[0].data = [humVal, 100 - humVal];
        humGauge.update();
        document.getElementById('humValue').innerText = `${hum} %`;

        // Luminosidade (agora correto: pouco luz = pouco preenchido)
        lumGauge.data.datasets[0].data = [normalizedLum, 100 - normalizedLum];
        lumGauge.update();
        document.getElementById('lumValue').innerText = `${Math.round(normalizedLum)}`;

        // Chuva
        const rainPercent = Math.min((rain / 20) * 100, 100);
        rainGauge.data.datasets[0].data = [rainPercent, 100 - rainPercent];
        rainGauge.update();
        document.getElementById('rainValue').innerText = `${rain} mm`;

        checkAlerts({ temp, hum, lum: normalizedLum, rain });
    }

    async function loadLatest() {
        try {
            const res = await axios.get('/sensor-data-json');
            updateGauges(res.data);
        } catch(err) { console.error(err); }
    }

    async function loadHistory(date) {
        const q = date ? `?date=${date}` : '';
        try {
            const res = await axios.get(`/sensor-historico-json${q}`);
            const dados = res.data;
            historyChart.data.labels = dados.map(d=>d.hora);
            historyChart.data.datasets[0].data = dados.map(d=>d.temperature);
            historyChart.update();

            const tbody = document.querySelector('#latestTable tbody');
            tbody.innerHTML='';
            dados.slice(-10).reverse().forEach(item=>{
                const tr=document.createElement('tr');
                tr.innerHTML=`<td>${item.hora}</td><td>${item.temperature}</td><td>${item.humidity}</td><td>${item.luminosity}</td><td>${item.rain}</td>`;
                tbody.appendChild(tr);
            });
        } catch(err){ console.error(err); }
    }

    function checkAlerts({temp, hum, rain}) {
        const area = document.getElementById('alertsArea');
        const alerts = [];
        if(temp >= 35) alerts.push({level:'danger', text:`Temperatura alta: ${temp} °C`});
        if(hum <= 30) alerts.push({level:'warning', text:`Umidade baixa: ${hum}% — risco de incêndio`});
        if(rain > 0) alerts.push({level:'info', text:`Chuva detectada: ${rain} mm`});

        if(alerts.length===0){ area.innerHTML='<p class="text-muted">Nenhum alerta por enquanto.</p>'; return; }
        area.innerHTML='';
        alerts.forEach(a=>{
            const div = document.createElement('div');
            div.className = `alert alert-${a.level}`;
            div.innerText = a.text;
            area.appendChild(div);
        });
    }

    async function fetchForecast(city) {
        if(!city) return;
        const container = document.getElementById('forecastResult');
        container.innerHTML='Carregando...';
        try {
            const res = await axios.get(`/api/weather?city=${encodeURIComponent(city)}`);
            const data = res.data;

            if(!data.daily){ container.innerHTML='<div class="text-danger">Previsão indisponível.</div>'; return; }

            let html='<div class="row">';
            data.daily.slice(0,7).forEach(d=>{
                const date=new Date(d.dt*1000);
                html+=`
                <div class="col-12 mb-2">
                    <div class="card p-2 shadow-sm" style="border-radius:0.8rem;background:#fff;">
                        <p class="mb-1 text-center"><b>${date.toLocaleDateString('pt-BR')}</b></p>
                        <p class="mb-1 text-center text-capitalize">${d.weather[0].description}</p>
                        <p class="mb-0 text-center">🌡️ ${Math.round(d.temp.day)}° (min: ${Math.round(d.temp.min)}° / max: ${Math.round(d.temp.max)}°)</p>
                        <p class="mb-0 text-center">💧 ${d.humidity}%</p>
                        <p class="mb-0 text-center">🌬️ ${d.wind_speed} m/s</p>
                    </div>
                </div>`;
            });
            html+='</div>';
            container.innerHTML=html;
        } catch(err){
            container.innerHTML='<div class="text-danger">Erro ao buscar previsão.</div>';
            console.error(err);
        }
    }

    document.getElementById('btnFetchWeather').addEventListener('click',function(){
        const city=document.getElementById('cityInput').value.trim() || 'Pato Branco';
        fetchForecast(city);
    });

    const today = new Date().toISOString().slice(0,10);
    loadHistory(today);
    loadLatest();
    fetchForecast('Pato Branco');

    setInterval(loadLatest,15000);

});
</script>
@endsection
