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

@endsection
