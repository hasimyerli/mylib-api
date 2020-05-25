<?php

namespace App\Entity;

use App\Enum\Status;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserBookRepository")
 */
class UserBook
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userBooks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Book")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

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
     * @ORM\Column(type="integer")
     */
    private $status = Status::ACTIVE;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\UserBookList", inversedBy="userBooks")
     */
    private $userBookLists;

    public function __construct()
    {
        $this->userBookLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

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

    /**
     * @return \Doctrine\Common\Collections\Collection|UserBookList[]
     */
    public function getUserBookLists(): \Doctrine\Common\Collections\Collection
    {
        return $this->userBookLists;
    }

    public function addUserBookList(UserBookList $userBookList): self
    {
        if (!$this->userBookLists->contains($userBookList)) {
            $this->userBookLists[] = $userBookList;
        }

        return $this;
    }

    public function removeUserBookList(UserBookList $userBookList): self
    {
        if ($this->userBookLists->contains($userBookList)) {
            $this->userBookLists->removeElement($userBookList);
        }

        return $this;
    }

}
