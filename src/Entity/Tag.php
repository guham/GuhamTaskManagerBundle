<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string the name of this tag
     *
     * @ORM\Column(unique=true)
     * @Assert\NotNull()
     * @Assert\NotBlank()
     * @Assert\Length(
     *     max = 255
     * )
     */
    protected $name = 'tag.default.name';

    /**
     * @var Collection|Task[]
     *
     * @ORM\ManyToMany(targetEntity="Task", mappedBy="tags")
     */
    protected $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Tag
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Task[]
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     */
    public function addTask(Task $task): void
    {
        if ($this->tasks->contains($task)) {
            return;
        }

        $this->tasks->add($task);
        $task->addTag($this);
    }

    public function removeTask(Task $task): void
    {
        if (!$this->tasks->contains($task)) {
            return;
        }

        $this->tasks->removeElement($task);
        $task->removeTag($this);
    }
}
