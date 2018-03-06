<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests\Entity;

use Guham\TaskManagerBundle\Entity\Tag;
use Guham\TaskManagerBundle\Entity\Task;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    private const DEFAULT_NAME = 'tag.default.name';

    public function testDefaultInstance(): void
    {
        $tag = new Tag();
        $this->assertEquals(self::DEFAULT_NAME, $tag->getName());
        $this->assertEquals(self::DEFAULT_NAME, $tag);
        $this->assertCount(0, $tag->getTasks());
        $this->assertNull($tag->getId());
    }

    public function testTasks(): void
    {
        $tag = new Tag();
        $t1 = new Task();
        $t1->setTitle('t1');
        $t2 = new Task();
        $t2->setTitle('t2');
        $t3 = new Task();
        $t3->setTitle('t3');

        foreach ([$t1, $t2, $t3, $t2] as $task) {
            $tag->addTask($task);
        }
        $this->assertCount(3, $tag->getTasks());
        $this->assertTrue($t1->getTags()->contains($tag));
        $tag->removeTask($t1);
        $this->assertTrue($t1->getTags()->isEmpty());
    }
}
