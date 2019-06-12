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
 * Represents additional information about a relationship or property. For example a Role can be used to say that a 'member' role linking some SportsTeam to a player occurred during a particular time period. Or that a Person's 'actor' role in a Movie was for some particular characterName. Such properties can be attached to a Role entity, which is then associated with the main entities using ordinary properties like 'member' or 'actor'.\\n\\nSee also \[blog post\](http://blog.schema.org/2014/06/introducing-role.html).
 *
 * @see http://schema.org/Role Documentation on Schema.org
 *
 * @ORM\Entity
 * @ApiResource(iri="http://schema.org/Role")
 */
class Role
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
     * @ORM\Column(type="string", nullable=false)
     * @ApiProperty(iri="http://schema.org/name")
     * @Assert\NotNull
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotNull
     */
    private $score;

    /**
     * @var Collection<Test>|null
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Test")
     * @ORM\JoinTable(inverseJoinColumns={@ORM\JoinColumn(unique=true)})
     */
    private $tests;

    public function __construct()
    {
        $this->tests = new ArrayCollection();
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

    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function addTest(Test $test): void
    {
        $this->tests[] = $test;
    }

    public function removeTest(Test $test): void
    {
        $this->tests->removeElement($test);
    }

    public function getTests(): Collection
    {
        return $this->tests;
    }
}
