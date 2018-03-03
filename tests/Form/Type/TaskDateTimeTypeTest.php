<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Tests\Form\Type;

use Guham\TaskManagerBundle\Form\DataTransformer\NullToDateTimeDataTransformer;
use Guham\TaskManagerBundle\Form\Type\TaskDateTimeType;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

    public function testBuildForm(): void
    {
        $formBuilderInterfaceProphecy = $this->prophesize(FormBuilderInterface::class);
        $formBuilderInterfaceProphecy->addModelTransformer(new NullToDateTimeDataTransformer())->shouldBeCalled();
        $formBuilderInterface = $formBuilderInterfaceProphecy->reveal();

        $this->type->buildForm($formBuilderInterface, []);
    }

    public function testConfigureOptions(): void
    {
        $optionsResolverProphecy = $this->prophesize(OptionsResolver::class);
        $optionsResolverProphecy->setDefaults(Argument::type('array'))->shouldBeCalled();
        $optionsResolver = $optionsResolverProphecy->reveal();

        $this->type->configureOptions($optionsResolver);
    }

    public function testGetParent(): void
    {
        $this->assertEquals(DateTimeType::class, $this->type->getParent());
    }

    public function testGetBlockPrefix(): void
    {
        $this->assertEquals('task_datetime', $this->type->getBlockPrefix());
    }
}
