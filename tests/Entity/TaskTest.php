<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests\Entity;

use Guham\TaskManagerBundle\Entity\Tag;
use Guham\TaskManagerBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TaskTest extends KernelTestCase
{
    private const DEFAULT_TITLE = 'task.default.title';
    /**
     * @var ValidatorInterface
     */
    private $validator;

    protected function setUp()
    {
        self::bootKernel();
        $this->validator = self::$kernel->getContainer()->get('validator');
    }

    public function testDefaultInstance(): void
    {
        $task = new Task();
        $this->assertNull($task->getId());
        $this->assertEquals($task->getEndDate()->format('H'), $task->getStartDate()->modify('+1 hour')->format('H'));
        $this->assertFalse($task->isCompleted());
        $this->assertFalse($task->isPinned());
        $this->assertNull($task->getNote());
        $this->assertCount(0, $task->getTags());
        $this->assertEquals(self::DEFAULT_TITLE, $task->getTitle());
        $errors = $this->validator->validate($task);
        $this->assertCount(0, $errors);
    }

    public function testMarkAsFunctions(): void
    {
        $task = new Task();
        $task
            ->markAsCompleted()
            ->markAsPinned()
        ;
        $this->assertTrue($task->isCompleted());
        $this->assertTrue($task->isPinned());
        $task
            ->unmarkAsCompleted()
            ->unmarkAsPinned()
        ;
        $this->assertFalse($task->isCompleted());
        $this->assertFalse($task->isPinned());
        $task->setIsCompleted(true);
        $task->setIsPinned(true);
        $this->assertTrue($task->isCompleted());
        $this->assertTrue($task->isPinned());
    }

    public function testTags(): void
    {
        $task = new Task();
        $t1 = new Tag();
        $t1->setName('t1');
        $t2 = new Tag();
        $t2->setName('t2');
        $t3 = new Tag();
        $t3->setName('t3');

        foreach ([$t1, $t2, $t3, $t2] as $tag) {
            $task->addTag($tag);
        }
        $this->assertCount(3, $task->getTags());
        $this->assertTrue($t1->getTasks()->contains($task));
        $task->removeTag($t1);
        $this->assertTrue($t1->getTasks()->isEmpty());
    }

    public function testUpdateTitle(): void
    {
        $task = new Task();
        $task->setTitle('new title');
        $this->assertEquals('new title', $task);
    }

    public function testUpdateNote(): void
    {
        $task = new Task();
        $task->setNote('new note');
        $this->assertEquals('new note', $task->getNote());
    }

    public function testIncorrectEndDate(): void
    {
        $task = new Task();
        $incorrectEndDate = $task->getStartDate()->modify('-2 days');
        $task->setEndDate($incorrectEndDate);
        $errors = $this->validator->validate($task);
        $this->assertCount(1, $errors);
    }

    public function testIncorrectStartDate(): void
    {
        $task = new Task();
        $startDate = $task->getEndDate()->modify('+3 days');
        $task->setStartDate($startDate);
        $errors = $this->validator->validate($task);
        $this->assertCount(1, $errors);
    }
}
