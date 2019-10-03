<!--
     Arquivo que serve de Template para os demais
     Armazena em 1 único arquivo o código compartilhado pelas demais páginas.
 -->

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <!-- Define que a aplicação será adptavel ao tamanho do dispositivo -->
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Importa as configuracoes do bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Importa as fontes do fontawesome -->
    <script src="https://kit.fontawesome.com/7a6d102c54.js"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light mb-2">
    <a class="navbar-brand" href="{{route('listar_series')}}">Home</a>

    <!-- Se o usuário estiver logado mostra o link p/ Sair -->
    @auth
        <a  class="navbar-brand text-danger" href="/sair">Sair</a>
    @endauth

<!-- Se for um 'visitante' mostra link p/ Entrar -->
    @guest
        <a href="/entrar">Entrar</a>
    @endguest
</nav>

<div class="container">
    <div class="jumbotron">
        <h1>@yield('cabecalho')</h1>   <!-- Recebe e mostra o conteúdo da sessao cabecalho  -->
    </div>

@yield('conteudo') <!-- Recebe e mostra o conteúdo da sessao 'conteudo' -->
</div>
</body>
</html>