<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserBookHistoryRepository")
 */
class UserBookHistory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserBook")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userBook;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $editionNumber = [];

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $bookActionStatus = [];

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserBook(): ?UserBook
    {
        return $this->userBook;
    }

    public function setUserBook(?UserBook $userBook): self
    {
        $this->userBook = $userBook;

        return $this;
    }

    public function getEditionNumber(): ?array
    {
        return $this->editionNumber;
    }

    public function setEditionNumber(?array $editionNumber): self
    {
        $this->editionNumber = $editionNumber;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getBookActionStatus(): ?array
    {
        return $this->bookActionStatus;
    }

    public function setBookActionStatus(?array $bookActionStatus): self
    {
        $this->bookActionStatus = $bookActionStatus;

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
}
