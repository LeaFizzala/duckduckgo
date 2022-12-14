<?php

namespace App\Entity;

use App\Repository\AnnonceRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Annonce
{

    //constantes pour définir le statut d'une annonce
    const STATUS_VERY_BAD  = 0;
    const STATUS_BAD       = 1;
    const STATUS_GOOD      = 2;
    const STATUS_VERY_GOOD = 3;
    const STATUS_PERFECT   = 4;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: false)]
    #[Assert\Length(
        min: 30,
        minMessage: 'The description must be at least {{ limit }} characters long',

    )]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $price = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private $createdAt;

    #[ORM\Column (options: ['default' => false])]
    private ?bool $sold = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private $modifiedAt;

    #[ORM\Column(length: 255)]
    private ?string $slug;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Url(
    protocols: [ 'https'],
    )]
    private ?string $imageUrl = null;

   /* //constructeur
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }*/


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function isSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param mixed $modifiedAt
     */
    public function setModifiedAt($modifiedAt): void
    {
        $this->modifiedAt = $modifiedAt;
    }



    #[ORM\PrePersist]
    public function prePersist()
    {

        $this->createdAt = new \DateTime();
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($this->title);
    }

    #[ORM\PreUpdate]
    public function preUpdate()
    {
        $this->modifiedAt = new \DateTime();
    }


    /**
     * @return \DateTimeInterface|null
     */
    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modifiededAt;
    }

    public function getSlug(): ?string
    {
        if (!$this->slug) {
            $this->setSlug($this->title);
        }
        return $this->slug;

    }

    public function setSlug(string $slug): self
    {
        $slugify = new Slugify();
        $this->slug = $slugify->slugify($slug);

        return $this;

    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }




}
