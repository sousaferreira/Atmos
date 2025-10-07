@extends('layouts.app')

@section('content')
<h2 class="mb-5 text-center fw-bold text-primary">📰 Notícias do Clima - Atmostech</h2>

<div class="row">
    @forelse($news as $article)
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                @if(!empty($article['urlToImage']))
                    <img src="{{ $article['urlToImage'] }}" class="card-img-top" alt="Imagem da notícia">
                @endif
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $article['title'] }}</h5>
                    <p class="card-text">{{ $article['description'] }}</p>
                    <a href="{{ $article['url'] }}" target="_blank" class="btn btn-primary">Leia mais</a>
                    <p class="mt-2 text-muted">
                        Publicado em: {{ date('d/m/Y H:i', strtotime($article['publishedAt'])) }}
                    </p>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-danger">Nenhuma notícia encontrada no momento.</p>
    @endforelse
</div>
@endsection
