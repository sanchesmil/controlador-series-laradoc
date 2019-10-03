
<!-- Esta página é uma SUBVIEW = pequena parte de código -->

<!-- Se a variável 'mensagem' não estiver vazia = imprime-a -->
@if(!empty($mensagem))     <!-- $mensagem = variável de sessao definida nos controllers -->
<div class="alert alert-success">{{$mensagem}}</div>
@endif