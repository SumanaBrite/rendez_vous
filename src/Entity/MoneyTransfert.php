<?php

namespace App\Entity;

use App\Repository\MoneyTransfertRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoneyTransfertRepository::class)
 */
class MoneyTransfert
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $ria;

    /**
     * @ORM\Column(type="float")
     */
    private $moneyGram;

    /**
     * @ORM\Column(type="float")
     */
    private $westernUnion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $pays;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRia(): ?float
    {
        return $this->ria;
    }

    public function setRia(float $ria): self
    {
        $this->ria = $ria;

        return $this;
    }

    public function getMoneyGram(): ?float
    {
        return $this->moneyGram;
    }

    public function setMoneyGram(float $moneyGram): self
    {
        $this->moneyGram = $moneyGram;

        return $this;
    }

    public function getWesternUnion(): ?float
    {
        return $this->westernUnion;
    }

    public function setWesternUnion(float $westernUnion): self
    {
        $this->westernUnion = $westernUnion;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }
}
