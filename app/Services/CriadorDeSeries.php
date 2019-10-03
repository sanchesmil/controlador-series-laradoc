<?php


namespace App\Services;

use App\Entities\Episodio;
use App\Entities\Serie;
use App\Entities\Temporada;
use Doctrine\ORM\EntityManagerInterface;
use Exception;


/*
 * Classe de 'ajuda' ou 'helper' que cria uma Serie, suas temporadas e episódios
 */
class CriadorDeSeries
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

    // Cria a serie, suas temporadas e seus episodios

    /**
     * @param string $nomeSerie
     * @param int $qtdTemporadas
     * @param int $epPorTemporada
     * @return Serie
     */
    public function criarSerie(string $nomeSerie, int $qtdTemporadas, int $epPorTemporada) : Serie
    {
        //EntityManager::beginTransaction();

        $this->em->getConnection()->beginTransaction();    // Inicia a transação

        try{
            // Cria a série
            $serie = new Serie();
            $serie->setName($nomeSerie);

            //Torna a entidade #serie gerenciada e persistente p/ o EntityManager
            $this->em->persist($serie);

            // Cria as temporadas
            $this->criarTemporadas($serie, $qtdTemporadas, $epPorTemporada);

            $this->em->flush();  // Executa no banco as alterações

            $this->em->commit();   // Finaliza a transação com sucesso

        }catch (Exception $e){
            $this->em->rollback();  // Erro na transação: Desfaz o que foi feito
            throw $e;
        }

        return $serie;
    }

    //Cria as temporadas e seus episódios
    private function criarTemporadas(Serie $serie, int $qtdTemporadas, int $epPorTemporada)
    {

        for ($i = 1; $i <= $qtdTemporadas; $i++){

            $temporada = new Temporada();
            $temporada->setNumero($i);

            //Torna a entidade $temporada gerenciada e persistente p/ o EntityManager
            $this->em->persist($temporada);

            // Adiciona esta temporada à lista de temporadas da série e já faz o mapeamento inverso
            $serie->addTemporadas($temporada);

            // Cria os episódios da temporada
            $this->criarEpisodios($temporada, $epPorTemporada);            // Chama método que cria episódios
        }
    }

    private function criarEpisodios(Temporada $temporada, int $epPorTemporada)
    {
        // Para cada número de episódio, cria o episodio
        for ($j= 1; $j <= $epPorTemporada; $j++) {

            $episodio = new Episodio();
            $episodio->setNumero($j);

            $this->em->persist($episodio);

            // Adiciona o episódio à lista de episodios da temporadas e já faz o mapeamento inverso
            $temporada->addEpisodios($episodio);
        }
    }


}