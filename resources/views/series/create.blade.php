
@extends('layout') <!-- Estende o tamplate padrão 'layout' -->

@section('cabecalho')   <!-- Define o conteúdo da sessão 'cabecalho' -->
Adicionar Série!
@endsection

@section('conteudo')  <!-- Define o conteúdo da sessão 'conteudo' -->

<!-- Exibe os erros de validação (padrão do Laravel) -->
@include('erro', ['errors'=>$errors])    <!-- Inclui a página 'erro' passando os $errors que vieram do controller -->

<form method="post">               <!-- A action deste form será para esta mesma rota ('/series/criar'), porém com o método POST -->
{{ csrf_field() }}                         <!-- Diretiva do blade que evita ataques 'Cross-site Request Forgery' -->
    <div class="row">
        <div class="col col-8">
            <label for="name" >Nome</label>
            <input type="text" class="form-control mb-2" name="name" id="nome">
        </div>
        <div class="col col-2">
            <label for="qtd_temporadas" >Nº de Temporadas</label>
            <input type="number" class="form-control mb-2" name="qtd_temporadas" id="qtd_temporadas">
        </div>
        <div class="col col-2">
            <label for="ep_por_temporada" >Ep. por Temporada </label>
            <input type="number" class="form-control mb-2" name="ep_por_temporada" id="ep_por_temporada">
        </div>
    </div>
    <button class="btn btn-primary mt-2">Adicionar</button>
</form>
@endsection
