<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass()
 */
class Task
{
    use TimestampableEntity;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string the title of this task
     *
     * @ORM\Column
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    protected $title = 'task.default.title';

    /**
     * @var \DateTimeInterface the start date of this task
     *
     * @ORM\Column(type="datetime")
     */
    protected $startDate;

    /**
     * @var \DateTimeInterface the end date of this task
     *
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThanOrEqual(propertyPath="startDate")
     */
    protected $endDate;

    /**
     * @var bool true if this task is completed
     *
     * @ORM\Column(type="boolean")
     */
    protected $isCompleted = false;

    /**
     * @var bool true if this task is pinned
     *
     * @ORM\Column(type="boolean")
     */
    protected $isPinned = false;

    /**
     * @var string|null notes of this task
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $note;

    /**
     * @var Collection|Tag[]
     *
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="tasks")
     * @ORM\JoinTable(name="tasks_tags")
     */
    protected $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $date = new \DateTimeImmutable();
        $this->startDate = $date->setTime((int) $date->format('H'), 0);
        $this->endDate = $this->startDate->modify('+1 hour');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->title;
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Task
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getStartDate(): \DateTimeInterface
    {
        return $this->startDate;
    }

    /**
     * @param \DateTimeInterface $startDate
     *
     * @return Task
     */
    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getEndDate(): \DateTimeInterface
    {
        return $this->endDate;
    }

    /**
     * @param \DateTimeInterface $endDate
     *
     * @return Task
     */
    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->isCompleted;
    }

    /**
     * @return Task
     */
    public function markAsCompleted(): self
    {
        $this->isCompleted = true;

        return $this;
    }

    /**
     * @return Task
     */
    public function unmarkAsCompleted(): self
    {
        $this->isCompleted = false;

        return $this;
    }

    /**
     * @param bool $isCompleted
     *
     * @return Task
     */
    public function setIsCompleted(bool $isCompleted): self
    {
        $this->isCompleted = $isCompleted;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     *
     * @return Task
     */
    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPinned(): bool
    {
        return $this->isPinned;
    }

    /**
     * @return Task
     */
    public function markAsPinned(): self
    {
        $this->isPinned = true;

        return $this;
    }

    /**
     * @return Task
     */
    public function unmarkAsPinned(): self
    {
        $this->isPinned = false;

        return $this;
    }

    /**
     * @param bool $isPinned
     *
     * @return Task
     */
    public function setIsPinned(bool $isPinned): self
    {
        $this->isPinned = $isPinned;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            return;
        }

        $this->tags->add($tag);
        $tag->addTask($this);
    }

    public function removeTag(Tag $tag): void
    {
        if (!$this->tags->contains($tag)) {
            return;
        }

        $this->tags->removeElement($tag);
        $tag->removeTask($this);
    }
}
