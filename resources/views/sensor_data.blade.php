@extends('layouts.app')

@section('content')
<h2 class="mb-5 text-center fw-bold" style="color: #333; font-size: 2rem;">🌤 Estação Meteorológica - Atmostech</h2>

<!-- ======================== -->
<!-- Descrição do Projeto -->
<!-- ======================== -->
<div class="project-description mt-5 p-5" style="background: linear-gradient(135deg, #fefefe, #f5f5f5); border-radius: 1rem; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
    <h3 class="fw-bold mb-4 text-center" style="color: #333; font-size: 2rem;">✨ Projeto Atmostech</h3>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #fff8e7;">
                <h5 class="fw-bold mb-3">👩‍💻 Integrantes</h5>
                <ul class="list-unstyled mb-0" style="color: #555; line-height: 1.6;">
                    <li>Priscila Sousa Ferreira</li>
                    <li>Maria Raissa Pereira de Alexandria</li>
                    <li>Kivia Pereira da Cruz</li>
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #e7f8ff;">
                <h5 class="fw-bold mb-3">👩‍🏫 Orientadora</h5>
                <p style="color: #555; line-height: 1.6;">Ana Verônica</p>
            </div>
        </div>
    </div>

    <div class="mt-4 card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #f5fff0;">
        <h5 class="fw-bold mb-3">🌱 Propósito</h5>
        <p style="color: #555; line-height: 1.7; font-size: 1.1rem;">
            O <strong>Atmostech</strong> combina tecnologia, design e sustentabilidade, entregando informações meteorológicas em tempo real para agricultores, jardineiros e comunidades que dependem do clima.  
            🌦 Cada sensor fornece dados precisos de temperatura, umidade, luminosidade e chuva, permitindo decisões inteligentes sobre irrigação, plantio e manutenção de jardins.  
            Além disso, serve como ferramenta educativa, ambiental e de planejamento urbano, promovendo ações conscientes e um futuro sustentável. 🌿
        </p>
    </div>
</div>

<!-- ======================== -->
<!-- Dicas e Ações Individuais e Coletivas -->
<!-- ======================== -->
<div class="actions-tips mt-5 p-5" style="background: linear-gradient(135deg, #f0fff5, #e8f7f0); border-radius: 1rem; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
    <h3 class="fw-bold mb-4 text-center" style="color: #333; font-size: 2rem;">💡 Dicas e Ações Sustentáveis</h3>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #fffdf0;">
                <h5 class="fw-bold mb-3">👤 Ações Individuais</h5>
                <ul style="color: #555; line-height: 1.6;">
                    <li>Regar plantas nos horários de menor evaporação para economizar água.</li>
                    <li>Reduzir o uso de eletrônicos durante picos de calor para economizar energia.</li>
                    <li>Separar corretamente o lixo e incentivar a compostagem caseira.</li>
                    <li>Observar o clima com o Atmostech para ajustar hábitos de jardinagem e irrigação.</li>
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #f0f8ff;">
                <h5 class="fw-bold mb-3">🌱 Ações Coletivas</h5>
                <ul style="color: #555; line-height: 1.6;">
                    <li>Organizar mutirões de limpeza e plantio em áreas urbanas ou rurais.</li>
                    <li>Promover campanhas de conscientização sobre economia de água e energia.</li>
                    <li>Compartilhar dados do Atmostech com escolas e comunidades para educação ambiental.</li>
                    <li>Participar de projetos de monitoramento climático e sustentabilidade local.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ======================== -->
<!-- Vídeo do Projeto -->
<!-- ======================== -->
<div class="project-video mt-5 text-center p-5" style="background: linear-gradient(135deg, #fff8f0, #f0fff8); border-radius: 1rem; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
    <h3 class="fw-bold mb-4" style="color: #333; font-size: 2rem;">🎥 Coletando Dados com Atmostech</h3>
    <video controls width="80%" style="border-radius: 1rem; box-shadow: 0 8px 20px rgba(0,0,0,0.15);">
        <source src="{{ asset('videos/atmostech-demo.mp4') }}" type="video/mp4">
        Seu navegador não suporta vídeo.
    </video>
    <p class="mt-3" style="color: #555;">Veja como nosso projeto coleta dados meteorológicos em tempo real utilizando sensores conectados à estação.</p>
</div>


<!-- ======================== -->
<!-- Clima e Conceitos - Chapada do Araripe -->
<!-- ======================== -->
<div class="climate-concepts mt-5 p-5" style="background: linear-gradient(135deg, #fffaf0, #f0fff5); border-radius: 1rem; box-shadow: 0 6px 20px rgba(0,0,0,0.08);">
    <h3 class="fw-bold mb-4 text-center" style="color: #333; font-size: 2rem;">🌄 Clima e Conceitos - Chapada do Araripe</h3>

    <div class="row g-4">
        <!-- Temperatura -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #fff8e7;">
                <h5 class="fw-bold mb-3">🌡 Temperatura</h5>
                <p style="color: #555; line-height: 1.6;">
                    Representa o grau de calor ou frio do ar. Na Chapada do Araripe, as temperaturas médias variam de <strong>22°C a 28°C</strong> durante o dia e <strong>16°C a 20°C</strong> à noite.  
                    É influenciada por altitude, vegetação e radiação solar, sendo essencial para agricultura e conforto térmico.
                </p>
            </div>
        </div>

        <!-- Precipitação -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #e7f8ff;">
                <h5 class="fw-bold mb-3">☔ Precipitação</h5>
                <p style="color: #555; line-height: 1.6;">
                    É a quantidade de água que cai do céu, incluindo chuva e orvalho. Na região, há concentração de chuvas entre <strong>dezembro e maio</strong>, com estação seca de junho a novembro.  
                    Fundamental para irrigação, manutenção de rios e prevenção de erosão.
                </p>
            </div>
        </div>

        <!-- Umidade do Ar -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #f5fff0;">
                <h5 class="fw-bold mb-3">💧 Umidade do Ar</h5>
                <p style="color: #555; line-height: 1.6;">
                    Representa o vapor de água presente no ar. Na Chapada do Araripe, varia entre <strong>70% e 85%</strong>.  
                    A alta umidade favorece o crescimento de plantas e influencia o conforto térmico e a previsão de chuvas.
                </p>
            </div>
        </div>

        <!-- Ventos -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #fff0f5;">
                <h5 class="fw-bold mb-3">💨 Ventos</h5>
                <p style="color: #555; line-height: 1.6;">
                    Movimentação do ar de áreas de alta pressão para baixa pressão. Na região, predominam ventos do <strong>sudeste</strong>, principalmente no inverno.  
                    Importantes para energia eólica, evaporação de água, polinização e planejamento urbano.
                </p>
            </div>
        </div>

        <!-- Insolação -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #f0fff8;">
                <h5 class="fw-bold mb-3">☀️ Insolação</h5>
                <p style="color: #555; line-height: 1.6;">
                    Quantidade de radiação solar recebida. A Chapada do Araripe recebe até <strong>6 horas de sol pleno</strong> por dia.  
                    Impacta o crescimento de plantas, evaporação de água e potencial para energia solar.
                </p>
            </div>
        </div>

        <!-- Clima -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #fff8f0;">
                <h5 class="fw-bold mb-3">🌦 Clima</h5>
                <p style="color: #555; line-height: 1.6;">
                    É o conjunto de condições atmosféricas observadas ao longo de anos, incluindo temperatura, chuva, vento e umidade.  
                    A Chapada do Araripe apresenta clima <strong>tropical semiárido</strong>, com chuvas concentradas no verão e longos períodos de seca.
                </p>
            </div>
        </div>

        <!-- Impacto Ambiental -->
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0" style="border-radius: 1rem; background: #f5fff0;">
                <h5 class="fw-bold mb-3">🌱 Impacto no Meio Ambiente</h5>
                <p style="color: #555; line-height: 1.6;">
                    Monitorar o clima ajuda a planejar plantios, preservar rios, prevenir erosão e desastres naturais.  
                    É útil para educação ambiental, sustentabilidade e ações conscientes na região.
                </p>
            </div>
        </div>
    </div>
</div>


@endsection
