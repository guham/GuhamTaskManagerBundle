<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests\Entity;

use Guham\TaskManagerBundle\Entity\Tag;
use Guham\TaskManagerBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TagTest extends KernelTestCase
{
    private const DEFAULT_NAME = 'tag.default.name';
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
        $tag = new Tag();
        $this->assertNull($tag->getId());
        $this->assertEquals(self::DEFAULT_NAME, $tag->getName());
        $this->assertEquals(self::DEFAULT_NAME, $tag);
        $this->assertCount(0, $tag->getTasks());
        $errors = $this->validator->validate($tag);
        $this->assertCount(0, $errors);
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
