@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">🌦️ Previsão do Tempo - Brasil</h2>

    <div class="row">
        <!-- Mapa imagem -->
        <div class="col-md-7 mb-4 position-relative">
            <img src="{{ asset('images/Brazil_Blank_Map.svg') }}" 
                 alt="Mapa do Brasil" usemap="#brasil-map" 
                 class="img-fluid shadow-lg" style="border-radius:1rem;">
            <map name="brasil-map">
                <!-- Exemplo de áreas clicáveis (coordenadas aproximadas) -->
                <area shape="circle" coords="470,150,20" href="#" alt="Ceará" data-estado="ceara">
                <area shape="circle" coords="510,300,20" href="#" alt="São Paulo" data-estado="sp">
                <area shape="circle" coords="520,260,20" href="#" alt="Rio de Janeiro" data-estado="rj">
                <area shape="circle" coords="480,240,20" href="#" alt="Minas Gerais" data-estado="mg">
                <area shape="circle" coords="430,230,20" href="#" alt="Bahia" data-estado="ba">
                <area shape="circle" coords="370,450,20" href="#" alt="Rio Grande do Sul" data-estado="rs">
            </map>
        </div>

        <!-- Painel de dados climáticos -->
        <div class="col-md-5">
            <div id="previsao" class="p-4 shadow-lg border-0" style="border-radius: 1rem; background: #f5f5f5; min-height: 500px;">
                <h4 class="text-center text-muted mt-5">Clique em um estado para ver a previsão</h4>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const areas = document.querySelectorAll('area');
    const previsaoDiv = document.getElementById('previsao');

    areas.forEach(area => {
        area.addEventListener('click', function(e) {
            e.preventDefault();
            const estado = this.dataset.estado;

            previsaoDiv.innerHTML = '<h5 class="text-center text-muted mt-5">Carregando dados...</h5>';

            fetch(`/previsao/${estado}`)
            .then(res => res.json())
            .then(data => {
                if(data.erro){
                    previsaoDiv.innerHTML = `<p class="text-center text-danger">${data.erro}</p>`;
                    return;
                }

                let html = `<h4 class="fw-bold text-center mb-3">${estado.toUpperCase()}</h4>`;
                html += '<div class="row g-3 justify-content-center">';
                data.daily.slice(0,7).forEach(dia => {
                    const date = new Date(dia.dt * 1000);
                    html += `
                        <div class="col-md-12 mb-3">
                            <div class="card p-3 shadow-sm text-center" style="border-radius: 0.8rem; background:#fff;">
                                <p class="mb-1"><b>${date.toLocaleDateString('pt-BR')}</b></p>
                                <p class="mb-1 text-capitalize">${dia.weather[0].description}</p>
                                <p class="mb-0">🌡️ ${dia.temp.day} °C</p>
                                <p class="mb-0">💧 ${dia.humidity} %</p>
                                <p class="mb-0">🌬️ ${dia.wind_speed} m/s</p>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                previsaoDiv.innerHTML = html;
            })
            .catch(err => {
                previsaoDiv.innerHTML = `<p class="text-center text-danger">Erro ao carregar dados.</p>`;
                console.error(err);
            });
        });
    });
});
</script>

<style>
#previsao .card {
    transition: transform 0.3s, box-shadow 0.3s;
}
#previsao .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}
area:hover {
    cursor: pointer;
}
</style>
@endpush
