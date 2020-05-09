<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookActionStatusRepository")
 */
class BookActionStatus
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SystemLanguage")
     * @ORM\JoinColumn(nullable=false)
     */
    private $systemLanguage;

    /**
     * @ORM\Column(type="string", columnDefinition="ENUM('purchase', 'read', 'gift', 'lend')")
     */
    private $groupName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSystemLanguage(): ?SystemLanguage
    {
        return $this->systemLanguage;
    }

    public function setSystemLanguage(?SystemLanguage $systemLanguage): self
    {
        $this->systemLanguage = $systemLanguage;

        return $this;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): self
    {
        $this->groupName = $groupName;

        return $this;
    }
}
