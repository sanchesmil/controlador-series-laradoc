<?php

namespace App\Http\Controllers;

use App\Entities\Episodio;
use App\Entities\Temporada;
use App\Services\AtualizadorDeEpisodios;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class EpisodiosController extends Controller
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em=$entityManager;
    }

    public function index(int $temporadaId, Request $request)
    {
        /** @var Temporada $temporada */
        $temporada = $this->em->find(Temporada::class, $temporadaId);

        $nomeTemporada = $temporada->getNumero();

        $episodios = $temporada->getEpisodios();

        $mensagem = $request->session()->get('mensagem');   // Pega a mensagem da sessao se existir

        return view('episodios.index', compact('episodios','nomeTemporada', 'temporadaId','mensagem'));

    }

    public function assistir(int $temporadaId, Request $request)
    {
        $episodiosAssistidos = $request->episodios;   // Pega o array de episódios marcados como assistidos da view

        /** @var Temporada $temporada */
        $temporada = $this->em->find(Temporada::class, $temporadaId);    // Busca a temporada no banco pelo Id

        $episodiosDaTemporada = $temporada->getEpisodios();    // Pega todos os episódios da temporada

        // Percorre todos os episódios da temporada e atualiza aqueles que estão no array de $episodiosAssistidos
        foreach ($episodiosDaTemporada as $episodio){

            // Atualiza o campo 'assistido' dos episódios (aqueles que foram marcados)
            $episodio->setAssistido(in_array($episodio->getId(),$episodiosAssistidos));
        }

        $this->em->flush();  // Atualiza no banco

        //$atualizador->atualizaEpisodios($temporadaId, $episodiosAssistidos);

        $request->session()->flash(     // Define msg sucesso na sessao HTTP que dura somente uma requisição (flash)
            'mensagem',
            "Episódios marcados como assistidos!"
        );

        return redirect()->back();      // Redireciona o usuário p/ a última rota visitada (= view 'index' de episodios)
    }
}
