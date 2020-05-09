<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $profileImageUrl;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mobilePhone;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isEmailConfirmed;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookList", mappedBy="user")
     */
    private $bookLists;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BookTag", mappedBy="user")
     */
    private $bookTags;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserBook", mappedBy="user")
     */
    private $userBooks;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->bookLists = new ArrayCollection();
        $this->bookTags = new ArrayCollection();
        $this->userBooks = new ArrayCollection();
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getProfileImageUrl(): ?string
    {
        return $this->profileImageUrl;
    }

    public function setProfileImageUrl(?string $profileImageUrl): self
    {
        $this->profileImageUrl = $profileImageUrl;

        return $this;
    }

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(?string $mobilePhone): self
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getIsEmailConfirmed(): ?bool
    {
        return $this->isEmailConfirmed;
    }

    public function setIsEmailConfirmed(bool $isEmailConfirmed): self
    {
        $this->isEmailConfirmed = $isEmailConfirmed;

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BookList[]
     */
    public function getBookLists(): Collection
    {
        return $this->bookLists;
    }

    public function addBookList(BookList $bookList): self
    {
        if (!$this->bookLists->contains($bookList)) {
            $this->bookLists[] = $bookList;
            $bookList->setUser($this);
        }

        return $this;
    }

    public function removeBookList(BookList $bookList): self
    {
        if ($this->bookLists->contains($bookList)) {
            $this->bookLists->removeElement($bookList);
            // set the owning side to null (unless already changed)
            if ($bookList->getUser() === $this) {
                $bookList->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BookTag[]
     */
    public function getBookTags(): Collection
    {
        return $this->bookTags;
    }

    public function addBookTag(BookTag $bookTag): self
    {
        if (!$this->bookTags->contains($bookTag)) {
            $this->bookTags[] = $bookTag;
            $bookTag->setUser($this);
        }

        return $this;
    }

    public function removeBookTag(BookTag $bookTag): self
    {
        if ($this->bookTags->contains($bookTag)) {
            $this->bookTags->removeElement($bookTag);
            // set the owning side to null (unless already changed)
            if ($bookTag->getUser() === $this) {
                $bookTag->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|UserBook[]
     */
    public function getUserBooks(): Collection
    {
        return $this->userBooks;
    }

    public function addUserBook(UserBook $userBook): self
    {
        if (!$this->userBooks->contains($userBook)) {
            $this->userBooks[] = $userBook;
            $userBook->setUser($this);
        }

        return $this;
    }

    public function removeUserBook(UserBook $userBook): self
    {
        if ($this->userBooks->contains($userBook)) {
            $this->userBooks->removeElement($userBook);
            // set the owning side to null (unless already changed)
            if ($userBook->getUser() === $this) {
                $userBook->setUser(null);
            }
        }

        return $this;
    }
}
