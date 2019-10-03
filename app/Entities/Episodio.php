<?php

namespace App\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Episodio
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
     * @ORM\Column(type="boolean", options={"default":false})
     */
    protected $assistido = false;  // Define o valor default inicial (= false)

    /**
     * @ORM\ManyToOne(targetEntity="Temporada", inversedBy="episodios")
     */
    protected $temporada;

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
    public function setNumero(int $numero) : self
    {
        $this->numero = $numero;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssistido() : bool
    {
        return $this->assistido;
    }

    /**
     * @param mixed $assistido
     */
    public function setAssistido(bool $assistido) : self
    {
        $this->assistido = $assistido;
        return $this;
    }

    /**
     * @return Temporada
     */
    public function getTemporada(): Temporada
    {
        return $this->temporada;
    }

    /**
     * @param Temporada $temporada
     */
    public function setTemporada(Temporada $temporada) : self
    {
        $this->temporada = $temporada;
        return $this;
    }

}
