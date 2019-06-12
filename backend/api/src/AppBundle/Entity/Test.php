<?php

declare(strict_types=1);

namespace AppBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The most generic type of item.
 *
 * @see http://schema.org/Thing Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Thing")
 */
class Test
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string the name of the item
     *
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @ApiProperty(iri="http://schema.org/name")
     * @Assert\NotNull
     */
    private $name;

    /**
     * @var Collection<Role>
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Role")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(nullable=false, unique=true)})
     * @Assert\NotNull
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addRole(Role $role): void
    {
        $this->roles[] = $role;
    }

    public function removeRole(Role $role): void
    {
        $this->roles->removeElement($role);
    }

    public function getRoles(): Collection
    {
        return $this->roles;
    }
}
