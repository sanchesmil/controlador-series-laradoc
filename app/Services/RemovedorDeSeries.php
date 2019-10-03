<?php


namespace App\Services;


use App\Entities\Episodio;
use App\Entities\Serie;
use App\Entities\Temporada;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

class RemovedorDeSeries
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function removerSerie(int $serieId) : string
    {
        $nomeSerie = '';

        $this->em->getConnection()->beginTransaction();

        try{
            /** @var Serie $serie */
            $serie = $this->em->find(Serie::class, $serieId);

            $this->nomeSerie = $serie->getName();

            $this->removerTemporadas($serie->getTemporadas());

            $this->em->remove($serie);

            $this->em->flush();

            $this->em->commit();

        }catch (Exception $e){
            $this->em->rollback();
            throw $e->getMessage();
        }
        return $this->nomeSerie;
    }


    public function removerTemporadas(Collection $temporadas)
    {

        foreach ($temporadas as $temporada){

            /** @var Temporada $temporada */
            $temporada = $this->em->find(Temporada::class, $temporada->getId());

            $this->removerEpisodios($temporada->getEpisodios());

            $this->em->remove($temporada);
        }
    }

    public function removerEpisodios(Collection $episodios) : void
    {
        /** @var Episodio $episodio */
        foreach ($episodios as $episodio) {
            $episodio = $this->em->find(Episodio::class, $episodio->getId());

            $this->em->remove($episodio);
        }
    }

}