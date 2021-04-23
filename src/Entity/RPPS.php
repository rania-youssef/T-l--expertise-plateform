<?php

namespace App\Entity;

use App\Repository\RPPSRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RPPSRepository::class)
 */
class RPPS
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $CodeMedecin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeMedecin(): ?int
    {
        return $this->CodeMedecin;
    }

    public function setCodeMedecin(int $CodeMedecin): self
    {
        $this->CodeMedecin = $CodeMedecin;

        return $this;
    }
}
