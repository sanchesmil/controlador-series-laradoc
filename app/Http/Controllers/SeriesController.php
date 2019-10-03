<?php

namespace App\Http\Controllers;

use App\Entities\Serie;
use App\Http\Requests\SeriesFormRequest;
use App\Services\CriadorDeSeries;
use App\Services\RemovedorDeSeries;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * @var EntityManager
     */
    private $em;

    // Pega um $entityManager por Injeção de Dependência
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    // Busca todas as séries
    public function index(Request $request)
    {
        $seriesRepository = $this->em->getRepository(Serie::class);

        $series = $seriesRepository->findBy([],['name'=>'asc']);   // Busca todas as séries por ordem alfabética dos seus nomes

        $mensagem = $request->session()->get('mensagem');   // Pega a mensagem da sessao, se houver recebido.

        return view ('series.index', compact('series','mensagem')); //compact — Cria um array associativo com nomes e valores iguais aos das variáveis

    }

    // Redireciona p/ a view 'create' que exibe um formulário p/ usuário
    public function create()
    {
        return view('series.create');
    }

    // Armazena no banco a nova série, suas temporadas e episodios
    public function store(SeriesFormRequest $request, CriadorDeSeries $criadorDeSerie)   // A classe SeriesFormRequest faz a validacao dos dados vindos da view/form
    {
        // Chama a classe criadora de Serie passando os dados que vieram da view
        /** @var Serie $serie */
        $serie = $criadorDeSerie->criarSerie($request->name, $request->qtd_temporadas, $request->ep_por_temporada);

        $request->session()->flash(        // Define uma msg de sucesso na sessao HTTP que dura somente uma requisição (flash)
            'mensagem',
            "Série " . $serie->getName() . " e suas temporadas e epsódios criados com sucesso!"
        );

        return redirect()->route('listar_series'); // Redireciona p/ a rota 'listar_series' definida em routes
    }

    public function editaNome(int $serieId, Request $request)
    {
        $novoNome = $request->nome;      // Pega o novo nome da série

        /** @var Serie $serie */
        $serie = $this->em->find(Serie::class,$serieId);   // Busca uma referência à série no banco pelo Id

        $serie->setName($novoNome);     // Altera o nome da série

        $this->em->flush();             // Salva no banco a alteração

        return redirect()->route('listar_series');  // Redireciona p/ a página de Séries
    }

    public function destroy(Request $request, RemovedorDeSeries $removedorDeSeries)
    {
        $nomeSerie = $removedorDeSeries->removerSerie($request->serieId);

        $request->session()->flash(        // Define uma msg de sucesso na sessao HTTP que dura somente uma requisição (flash)
            'mensagem',
            "Série " . $nomeSerie . " e suas temporadas excluídas com sucesso!"
        );

        return redirect()->route('listar_series');

    }
}
