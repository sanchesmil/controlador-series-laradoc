<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity
 */
class Serie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Temporada", mappedBy ="serie")
     */
    protected $temporadas;

    /**
     * Serie constructor.
     * @param $name
     */
    public function __construct()
    {
        $this->temporadas = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    public function addTemporadas(Temporada $temporada) : self
    {
        $this->temporadas->add($temporada);  // Adiciono a temporada à lista de temporadas da série
        $temporada->setSerie($this);         // Relaciona esta serie à temporada
        return $this;
    }

    /**
     * @return Temporada[]|ArrayCollection
     */
    public function getTemporadas() : Collection
    {
        return $this->temporadas;
    }

}
