<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $barcode;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $pageNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $volumeType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Language")
     * @ORM\JoinColumn(nullable=false)
     */
    private $language;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $editionNumber;

    /**
     * @ORM\Column(type="json")
     */
    private $authors = [];

    /**
     * @ORM\Column(type="json")
     */
    private $categories = [];

    /**
     * @ORM\Column(type="json")
     */
    private $publishers = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $translators = [];

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rate", mappedBy="Book")
     */
    private $rates;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="book")
     */
    private $comments;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $document = [];

    public function __construct()
    {
        $this->rates = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getPageNumber(): ?int
    {
        return $this->pageNumber;
    }

    public function setPageNumber(?int $pageNumber): self
    {
        $this->pageNumber = $pageNumber;

        return $this;
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

    public function getVolumeType(): ?int
    {
        return $this->volumeType;
    }

    public function setVolumeType(?int $volumeType): self
    {
        $this->volumeType = $volumeType;

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getEditionNumber(): ?int
    {
        return $this->editionNumber;
    }

    public function setEditionNumber(?int $editionNumber): self
    {
        $this->editionNumber = $editionNumber;

        return $this;
    }

    public function getAuthors(): ? ArrayCollection
    {
        return $this->authors;
    }

    public function setAuthors(array $authors): self
    {
        $this->authors = $authors;

        return $this;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getPublishers(): ?array
    {
        return $this->publishers;
    }

    public function setPublishers(array $publishers): self
    {
        $this->publishers = $publishers;

        return $this;
    }

    public function getTranslators(): ?array
    {
        return $this->translators;
    }

    public function setTranslators(?array $translators): self
    {
        $this->translators = $translators;

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

    /**
     * @return Collection|Rate[]
     */
    public function getRates(): Collection
    {
        return $this->rates;
    }

    public function addRate(Rate $rate): self
    {
        if (!$this->rates->contains($rate)) {
            $this->rates[] = $rate;
            $rate->setBook($this);
        }

        return $this;
    }

    public function removeRate(Rate $rate): self
    {
        if ($this->rates->contains($rate)) {
            $this->rates->removeElement($rate);
            // set the owning side to null (unless already changed)
            if ($rate->getBook() === $this) {
                $rate->setBook(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setBook($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getBook() === $this) {
                $comment->setBook(null);
            }
        }

        return $this;
    }

    public function getDocument(): ?array
    {
        return $this->document;
    }

    public function setDocument(?array $document): self
    {
        $this->document = $document;

        return $this;
    }
}
