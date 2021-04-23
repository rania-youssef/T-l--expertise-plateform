<?php

namespace App\Entity;

use App\Repository\DemandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeRepository::class)
 */
class Demande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $initialePatient;

    

    /**
     * @ORM\Column(type="text")
     */
    private $explicatif;

   

    /**
     * @ORM\Column(type="integer")
     */
    private $niveauUrganece;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Etat;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demandes")
     */
    private $MedecinEmitteur;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="demande", orphanRemoval=true)
     */
    private $commentaires;

    /**
     * @ORM\ManyToMany(targetEntity=Specialiste::class, mappedBy="DemandeAtt")
     */
    private $SpecialisteAtt;

    /**
     * @ORM\OneToMany(targetEntity=ReponseD::class, mappedBy="demande")
     */
    private $reponseDs;

    /**
     * @ORM\OneToMany(targetEntity=DemandeRens::class, mappedBy="demande")
     */
    private $demandeRens;

    /**
     * @ORM\OneToOne(targetEntity=ExamenATCD::class, mappedBy="demande", cascade={"persist", "remove"})
     */
    private $examenATCD;

    /**
     * @ORM\OneToOne(targetEntity=ExamenRadio::class, mappedBy="demande", cascade={"persist", "remove"})
     */
    private $examenRadio;

    /**
     * @ORM\OneToOne(targetEntity=ExamenBio::class, mappedBy="demande", cascade={"persist", "remove"})
     */
    private $examenBio;

    /**
     * @ORM\OneToOne(targetEntity=ExamenClinique::class, mappedBy="demande", cascade={"persist", "remove"})
     */
    private $examenClinique;

   

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

  

    /**
     * @ORM\Column(type="date")
     */
    private $datenaiss;

   

   

    
    public function __construct()
    {
       
        $this->commentaires = new ArrayCollection();
        $this->DrSpecialiste = new ArrayCollection();
        $this->SpecialisteAtt = new ArrayCollection();
        $this->reponseDs = new ArrayCollection();
        $this->demandeRens = new ArrayCollection();
       
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitialePatient(): ?string
    {
        return $this->initialePatient;
    }

    public function setInitialePatient(string $initialePatient): self
    {
        $this->initialePatient = $initialePatient;

        return $this;
    }


    public function getExplicatif(): ?string
    {
        return $this->explicatif;
    }

    public function setExplicatif(string $explicatif): self
    {
        $this->explicatif = $explicatif;

        return $this;
    }

  
    public function getNiveauUrganece(): ?int
    {
        return $this->niveauUrganece;
    }

    public function setNiveauUrganece(int $niveauUrganece): self
    {
        $this->niveauUrganece = $niveauUrganece;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(string $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }

    public function getMedecinEmitteur(): ?User
    {
        return $this->MedecinEmitteur;
    }

    public function setMedecinEmitteur(?User $MedecinEmitteur): self
    {
        $this->MedecinEmitteur = $MedecinEmitteur;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setDemande($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getDemande() === $this) {
                $commentaire->setDemande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Specialiste[]
     */
    public function getSpecialisteAtt(): Collection
    {
        return $this->SpecialisteAtt;
    }

    public function addSpecialisteAtt(Specialiste $specialisteAtt): self
    {
        if (!$this->SpecialisteAtt->contains($specialisteAtt)) {
            $this->SpecialisteAtt[] = $specialisteAtt;
            $specialisteAtt->addDemandeAtt($this);
        }

        return $this;
    }

    public function removeSpecialisteAtt(Specialiste $specialisteAtt): self
    {
        if ($this->SpecialisteAtt->removeElement($specialisteAtt)) {
            $specialisteAtt->removeDemandeAtt($this);
        }

        return $this;
    }

    /**
     * @return Collection|ReponseD[]
     */
    public function getReponseDs(): Collection
    {
        return $this->reponseDs;
    }

    public function addReponseD(ReponseD $reponseD): self
    {
        if (!$this->reponseDs->contains($reponseD)) {
            $this->reponseDs[] = $reponseD;
            $reponseD->setDemande($this);
        }

        return $this;
    }

    public function removeReponseD(ReponseD $reponseD): self
    {
        if ($this->reponseDs->removeElement($reponseD)) {
            // set the owning side to null (unless already changed)
            if ($reponseD->getDemande() === $this) {
                $reponseD->setDemande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DemandeRens[]
     */
    public function getDemandeRens(): Collection
    {
        return $this->demandeRens;
    }

    public function addDemandeRen(DemandeRens $demandeRen): self
    {
        if (!$this->demandeRens->contains($demandeRen)) {
            $this->demandeRens[] = $demandeRen;
            $demandeRen->setDemande($this);
        }

        return $this;
    }

    public function removeDemandeRen(DemandeRens $demandeRen): self
    {
        if ($this->demandeRens->removeElement($demandeRen)) {
            // set the owning side to null (unless already changed)
            if ($demandeRen->getDemande() === $this) {
                $demandeRen->setDemande(null);
            }
        }

        return $this;
    }

    public function getExamenATCD(): ?ExamenATCD
    {
        return $this->examenATCD;
    }

    public function setExamenATCD(?ExamenATCD $examenATCD): self
    {
        // unset the owning side of the relation if necessary
        if ($examenATCD === null && $this->examenATCD !== null) {
            $this->examenATCD->setDemande(null);
        }

        // set the owning side of the relation if necessary
        if ($examenATCD !== null && $examenATCD->getDemande() !== $this) {
            $examenATCD->setDemande($this);
        }

        $this->examenATCD = $examenATCD;

        return $this;
    }

    public function getExamenRadio(): ?ExamenRadio
    {
        return $this->examenRadio;
    }

    public function setExamenRadio(?ExamenRadio $examenRadio): self
    {
        // unset the owning side of the relation if necessary
        if ($examenRadio === null && $this->examenRadio !== null) {
            $this->examenRadio->setDemande(null);
        }

        // set the owning side of the relation if necessary
        if ($examenRadio !== null && $examenRadio->getDemande() !== $this) {
            $examenRadio->setDemande($this);
        }

        $this->examenRadio = $examenRadio;

        return $this;
    }

    public function getExamenBio(): ?ExamenBio
    {
        return $this->examenBio;
    }

    public function setExamenBio(?ExamenBio $examenBio): self
    {
        // unset the owning side of the relation if necessary
        if ($examenBio === null && $this->examenBio !== null) {
            $this->examenBio->setDemande(null);
        }

        // set the owning side of the relation if necessary
        if ($examenBio !== null && $examenBio->getDemande() !== $this) {
            $examenBio->setDemande($this);
        }

        $this->examenBio = $examenBio;

        return $this;
    }

    public function getExamenClinique(): ?ExamenClinique
    {
        return $this->examenClinique;
    }

    public function setExamenClinique(?ExamenClinique $examenClinique): self
    {
        // unset the owning side of the relation if necessary
        if ($examenClinique === null && $this->examenClinique !== null) {
            $this->examenClinique->setDemande(null);
        }

        // set the owning side of the relation if necessary
        if ($examenClinique !== null && $examenClinique->getDemande() !== $this) {
            $examenClinique->setDemande($this);
        }

        $this->examenClinique = $examenClinique;

        return $this;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

       

    
}

