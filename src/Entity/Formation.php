<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Validator\Constraints as Assert;
// use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @ORM\Column(type="string", length=91, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=46, nullable=true)
     */
    private $miniature;

    /**
     * @ORM\Column(type="string", length=48, nullable=true)
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=11, nullable=true)
     */
    private $videoId;
    
    
    
    /**
     * @ORM\Column(type="integer")
     */
//    private $id_niveau;


    /**
     * @ORM\ManyToOne(targetEntity=Niveaux::class)
     */
    private $niveau;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function getPublishedAtString(): string {
        return $this->publishedAt->format('d/m/Y');     
    }    
        
    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMiniature(): ?string
    {
        return $this->miniature;
    }

    public function setMiniature(?string $miniature): self
    {
        $this->miniature = $miniature;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    public function setVideoId(?string $videoId): self
    {
        $this->videoId = $videoId;

        return $this;
    }
    
//    public function getIdNiveau(): ?int
//    {
//        return $this->id_niveau;
//    }

//    public function setIdNiveau(int $id_niveau): self
//    {
//        $this->id_niveau = $id_niveau;

//        return $this;
//    }
    
//    public function getNomNiveau(): ?string
//    {
//        $niveaux = $this->repository->findByContainValue("id", $this->id_niveau);
        
        
//        return $niveaux.getNom;

//    }

    public function getNiveau(): ?Niveaux
    {
        return $this->niveau;
    }

    public function setNiveau(?Niveaux $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }
    
    
    
    /**
     * Vérifie que les images sont conformes
     * @Assert\Callback
     */
//    public function validateImages(ExecutionContextInterface $context)
//    {  
        // Miniature
//        if (strlen($this->getMiniature()) > 0) {
            // vérifie l'existence de la miniature à l'url indiquée
//            $miniatureSize = @getimagesize($this->getMiniature());
//            if (!is_array($miniatureSize) && strlen($this->getMiniature()) > 0) {
//                $context->buildViolation("L'URL de la miniature est invalide")
//                        ->atPath('miniature')
//                        ->addViolation();
//            }
        
            // vérifie que la miniature a la bonne taille
//            elseif ($miniatureSize[0] !== 120 || $miniatureSize[1] !== 90) {
//                $context->buildViolation("La miniature doit être de taille 120x90")
//                        ->atPath('miniature')
//                        ->addViolation();
//            }
//        }
        
        // Image
//        if (strlen($this->getPicture()) > 0) {
            // vérifie l'existence de l'image à l'url indiquée, si une url est fournie
//            $imageSize = @getimagesize($this->getPicture());
//            if (!is_array($imageSize)) {
//                $context->buildViolation("L'URL de l'image est invalide")
//                        ->atPath('picture')
//                        ->addViolation();
//            }
//            elseif ($imageSize[0] > 640 || $imageSize[1] > 480) {
//                $context->buildViolation("L'image doit être de taille 640x480 maximum")
//                        ->atPath('picture')
//                        ->addViolation();   
//            }
//        }
//    }
}
