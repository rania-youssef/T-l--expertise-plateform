<?php

namespace App\Entity;

use App\Repository\SpecialisteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SpecialisteRepository::class)
 */
class Specialiste
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbanneExperience;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $specialite;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $User;

    /**
     * @ORM\ManyToMany(targetEntity=Demande::class, inversedBy="SpecialisteAtt")
     */
    private $DemandeAtt;

    

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Etat;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $experiences;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=ReponseD::class, mappedBy="Specialiste", orphanRemoval=true)
     */
    private $reponseDs;

    /**
     * @ORM\Column(type="array")
     */
    private $dossier = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $rpps;

    

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->DemandeAtt = new ArrayCollection();
        $this->reponseDs = new ArrayCollection();
    }

 
    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getNbanneExperience(): ?int
    {
        return $this->nbanneExperience;
    }

    public function setNbanneExperience(int $nbanneExperience): self
    {
        $this->nbanneExperience = $nbanneExperience;

        return $this;
    }

    public function getSpecialite(): ?string
    {
        return $this->specialite;
    }

    public function setSpecialite(string $specialite): self
    {
        $this->specialite = $specialite;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return Collection|Demande[]
     */
    public function getDemandeAtt(): Collection
    {
        return $this->DemandeAtt;
    }

    public function addDemandeAtt(Demande $demandeAtt): self
    {
        if (!$this->DemandeAtt->contains($demandeAtt)) {
            $this->DemandeAtt[] = $demandeAtt;
        }

        return $this;
    }

    public function removeDemandeAtt(Demande $demandeAtt): self
    {
        $this->DemandeAtt->removeElement($demandeAtt);

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

    

    public function getExperiences(): ?string
    {
        return $this->experiences;
    }

    public function setExperiences(string $experiences): self
    {
        $this->experiences = $experiences;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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
            $reponseD->setSpecialiste($this);
        }

        return $this;
    }

    public function removeReponseD(ReponseD $reponseD): self
    {
        if ($this->reponseDs->removeElement($reponseD)) {
            // set the owning side to null (unless already changed)
            if ($reponseD->getSpecialiste() === $this) {
                $reponseD->setSpecialiste(null);
            }
        }

        return $this;
    }

    public function getDossier(): ?array
    {
        return $this->dossier;
    }

    public function setDossier(array $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getRpps(): ?int
    {
        return $this->rpps;
    }

    public function setRpps(int $rpps): self
    {
        $this->rpps = $rpps;

        return $this;
    }

   
  


}
