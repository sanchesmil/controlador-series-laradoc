
@extends('layout') <!-- Estende o tamplate padrão 'layout' -->

@section('cabecalho')   <!-- Define o conteúdo da sessão 'cabecalho' -->
Séries!
@endsection

@section('conteudo')  <!-- Define o conteúdo da sessão 'conteudo' -->

@include('mensagem', ['mensagem'=> $mensagem])   <!-- Chama a view 'mensagem' passando uma mensagem p/ ser exibida -->


@auth <!-- Mostra o botão de adicionar séries somente p/ usuários logados -->

<!-- Usa o alias 'form_criar_serie' para chamar a rota -->
<a href="{{ route('form_criar_serie') }}" class="btn btn-dark mb-2">Adicionar</a>
@endauth

<ul class="list-group">

@foreach ($series as $serie) <!-- Sintaxe do blade p/ tratar com dados PHP sem usar comandos PHP  -->

    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span id="nome-serie-{{ $serie->getId() }}">{{ $serie->getName() }}</span>   <!-- '{{'....'}}' = Sintaxe do blade  -->

        @auth
        <!-- Cria uma div oculta(hidden) que abre p/ edição ao clicar no botão de edição -->
        <div class="input-group w-50" hidden id="input-nome-serie-{{ $serie->getId() }}">
            <input type="text" class="form-control" value="{{ $serie->getName() }}">
            <div class="input-group-append">
                <button class="btn btn-primary" onclick="editarSerie({{ $serie->getId() }})">
                    <i class="fas fa-check"></i>  <!-- Adiciona um icone de validacao de Font Awesome -->
                </button>
                <!-- Sempre que for fazer requisição HTTP é necessário informar o TOKEN -->
            {{ csrf_field() }}    <!-- Converte-se em um input 'hidden' com o valor do TOKEN necessário ao Laravel p/ ele processar a requisição -->
            </div>
        </div>
        @endauth

        <span class="d-flex">
             @auth    <!-- Mostra o botão de edição somente p/ usuários logados -->

                 <!-- Botão de editar -->
                 <button class="btn btn-info btn-sm mr-1" title="Editar" onclick="toggleInput({{$serie->getId()}})">
                    <i class="fas fa-edit"></i>  <!-- Adiciona um icone de edicao de Font Awesome -->
                </button>
             @endauth

             <!-- Link para 'temporadas' -->
            <a href="/series/{{$serie->getId()}}/temporadas" class="btn btn-info btn-sm mr-1" title="Temporadas">
                <i class="fas fa-external-link-alt"></i>  <!-- Adiciona um icone de redirecionamento de Font Awesome -->
            </a>

            @auth    <!-- Mostra o botão de exclusão somente p/ usuários logados -->

                <!-- Botão de excluir -->
                <!-- Usa um form p/ excluir uma série. Isso evita que mecanismos de busca, como google, excluam dados via GET automaticamente ao percorrer a pagina-->
                <form action="/series/{{$serie->getId()}}" method="post" onsubmit="return confirm('Tem certeza que deseja remover {{addslashes($serie->getName())}}?')">

                    <!--addslashes() evita conflitos com palavras que possuam o caractere ' (aspas) -->

                    {{ csrf_field() }}   <!-- Adicionar o @crsf para não ter problemas de segurança com o token -->

                    {{method_field('DELETE')}}    <!-- Diretiva do blade que sobrescreve o método do form, tendo em vista que o HTML não suporta métodos diferentes de get ou post. Na prática, ele cria um campo hidden e a cada requisicao verifica sua existencia -->

                    <button class="btn btn-danger btn-sm" title="Excluir">
                        <i class="far fa-trash-alt"></i> <!-- Adiciona um icone de exclusao de Font Awesome -->
                    </button>
                </form>
            @endauth
        </span>
    </li>
    @endforeach
</ul>

<script>

    function toggleInput(serieId){
        const nomeSerieElem = document.getElementById(`nome-serie-${serieId}`);
        const inputSerieElem = document.getElementById(`input-nome-serie-${serieId}`);

        // Trata os dois clicks sobre o ícone de edição
        if(nomeSerieElem.hasAttribute('hidden')){       // 1° Mostra a div nome se estiver escondida (= hidden)

            nomeSerieElem.removeAttribute('hidden');    // Mostra a span nome removendo o atributo hidden
            inputSerieElem.hidden = true;               // Esconde o input de edição add o atrib hidden = true

        }else {                                         // 2º Esconde a span nome se estiver visivel

            inputSerieElem.removeAttribute('hidden');   // Mostra o input p/ edição removendo o atrib hidden
            nomeSerieElem.hidden = true;                // Esconde a div nome
        }
    }

    //Simula um formulário HTML com javascript
    function editarSerie(serieId) {

        let formData = new FormData();                // Cria um formulário em Javascript

        // Recupera o valor digitado no input 'filho' do elemento com nome 'input-nome-serie-${serieId]' (div)
        const nome = document.querySelector(`#input-nome-serie-${serieId} > input`).value;

        // Recupera o TOKEN da diretiva '@csrf' cujo nome é '_token' (necessário ao Laravel)
        const token = document.querySelector(`input[name='_token']`).value;

        //alert(token);

        formData.append('nome', nome);                // Adiciona o campo 'nome' e o seu valor ao FormData

        formData.append('_token', token);             // Adiciona o campo '_token' e o seu valor ao FormData

        const url = `/series/${serieId}/editaNome`;   // Define a rota (action) do form

        // Faz uma requisição em Javascript ao servidor passando a URL, o corpo e o método da requisição
        fetch(url, {
            body: formData,                           // Monta o corpo da requisição
            method: 'POST'
        }).then(function(){
            toggleInput(serieId);                     // Após executar a requisição esconde o input de edição (simula um click) e

            document.getElementById(`nome-serie-${serieId}`).textContent = nome;  // Atualiza o nome da serie na tela
        });


    }
</script>
@endsection