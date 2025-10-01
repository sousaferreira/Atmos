@extends('layouts.app')

@section('content')
<h2 class="mb-4 text-center">📋 Tabela de Leituras da Estação Meteorológica</h2>

<div class="card p-3">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Data/Hora</th>
                <th>Temperatura (°C)</th>
                <th>Umidade (%)</th>
                <th>Luminosidade</th>
                <th>Chuva (mm)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sensorData as $d)
            <tr>
                <td>{{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i:s') }}</td>
                <td>{{ $d->temperature }}</td>
                <td>{{ $d->humidity }}</td>
                <td>{{ $d->luminosity }}</td>
                <td>{{ $d->rain }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
