<?php

namespace App\Http\Controllers;

use App\Entities\Serie;
use App\Entities\Temporada;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Persisters\Collection\OneToManyPersister;
use Illuminate\Http\Request;

class TemporadasController extends Controller
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;

    }

    // Chama a view que mostra as temporadas de uma série
    public function index(int $serieId)
    {
        /** @var Serie $serie */
        $serie = $this->em->find(Serie::class,$serieId);

        $nomeSerie = $serie->getName();

        // Duas formas para recuperar as Temporadas de uma Série:

        // 1ª Forma: Através da própria Série, chamando o 'getTemporadas()'
        $temporadas = $serie->getTemporadas();

        // 2ª Forma: Via DQL, obtendo as temporadas que possuam um determiado 'id' de série

        /*
        $dql = 'SELECT t from App\\Entities\\Temporada t where t.serie = :id';
        $query = $this->em->createQuery($dql);
        $query->setParameter('id',$serieId);
        $temporadas = $query->getResult();
        */

        return view('temporadas.index', compact('temporadas', 'nomeSerie'));
    }
}
