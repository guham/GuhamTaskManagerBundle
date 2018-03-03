<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests\Form\Type;

use Guham\TaskManagerBundle\Form\DataTransformer\NullToDateTimeDataTransformer;
use Guham\TaskManagerBundle\Form\Type\TaskDateTimeType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskDateTimeTypeTest extends TestCase
{
    /**
     * @var TaskDateTimeType
     */
    protected $type;

    protected function setUp()
    {
        $this->type = new TaskDateTimeType();
    }

    protected function tearDown()
    {
        $this->type = null;
    }

    public function testBuildForm()
    {
        $formBuilderInterfaceProphecy = $this->prophesize(FormBuilderInterface::class);
        $formBuilderInterfaceProphecy->addModelTransformer(new NullToDateTimeDataTransformer())->shouldBeCalled();
        $formBuilderInterface = $formBuilderInterfaceProphecy->reveal();

        $this->type->buildForm($formBuilderInterface, []);
    }

    public function testGetParent()
    {
        $this->assertEquals(DateTimeType::class, $this->type->getParent());
    }
}
