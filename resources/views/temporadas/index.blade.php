
<!-- Extende o tamplate padrão 'layout' = Recurso do Blade -->
@extends('layout')

@section('cabecalho')   <!-- Define as sessoes / áreas de conteúdo -->
Temporadas da série {{$nomeSerie}}:
@endsection

@section('conteudo')

    <ul class="list-group">
        <!-- Sintaxe do blade p/ tratar com PHP -->
        @foreach ($temporadas as $temporada)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="/temporada/{{$temporada->getId()}}/episodios">Temporada {{ $temporada->getNumero() }}</a>

                <!-- Define uma espécie de selo para mostrar o número de episódios assistidos do total de episódios de cada temporada -->
                <span class="badge badge-secondary">
                    {{$temporada->getEpisodiosAssistidos()->count()}}/{{$temporada->getEpisodios()->count()}}
                </span>
            </li>
        @endforeach
    </ul>
@endsection

