<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity
 */
class Temporada
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $numero;

    /**
     * @ORM\ManyToOne(targetEntity="Serie", inversedBy="temporadas")
     */
    protected $serie;

    /**
     * @ORM\OneToMany(targetEntity="Episodio", mappedBy="temporada")
     */
    protected $episodios;


    /**
     * Temporada constructor.
     * @param $numero
     */
    public function __construct()
    {
        $this->episodios = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNumero() : int
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero) : self
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return Serie
     */
    public function getSerie(): Serie
    {
        return $this->serie;
    }

    /**
     * @param Serie $serie
     */
    public function setSerie(Serie $serie) : self
    {
        $this->serie = $serie;
        return $this;
    }

    // Adiciona o episódio à lista de episodios desta temporada
    public function addEpisodios(Episodio $episodio) : self
    {
        $this->episodios->add($episodio);
        $episodio->setTemporada($this);

        return $this;
    }
    /**
     * @return Episodio[]|ArrayCollection
     */
    public function getEpisodios() : Collection
    {
        return $this->episodios;
    }

    // Retorna uma lista de episódios assistidos
    public function getEpisodiosAssistidos() : Collection
    {
        return $this->getEpisodios()->filter(function (Episodio $episodio){
            return $episodio->getAssistido();
        });
    }
}
