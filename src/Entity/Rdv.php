<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\Creneau;
use App\Entity\Guichet;
use App\Entity\Horaire;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RdvRepository;

/**
 * @ORM\Entity(repositoryClass=RdvRepository::class)
 */
class Rdv
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $jour;

    /**
     * @ORM\ManyToOne(targetEntity=Guichet::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $guichet;

    /**
     * @ORM\ManyToOne(targetEntity=Creneau::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $creneau;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rdvs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=Horaire::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $horaire;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?\DateTimeInterface
    {
        return $this->jour;
    }

    public function setJour(\DateTimeInterface $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getGuichet(): ?Guichet
    {
        return $this->guichet;
    }
        

    public function setGuichet(?Guichet $guichet): self
    {
        $this->guichet = $guichet;

        return $this;
    }

    public function getCreneau(): ?Creneau
    {
        return $this->creneau;
    }

    public function setCreneau(?Creneau $creneau): self
    {
        $this->creneau = $creneau;

        return $this;
    }

    public function getEmail(): ?User
    {
        return $this->email;
    }

    public function setEmail(?User $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getHoraire(): ?Horaire
    {
        return $this->horaire;
    }

    public function setHoraire(?Horaire $horaire): self
    {
        $this->horaire = $horaire;

        return $this;
    }

    
}
