<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Form\Type;

use Guham\TaskManagerBundle\Form\DataTransformer\NullToDateTimeDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskDateTimeType extends AbstractType
{
    private const DEFAULT_MINUTES = [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55];

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer(new NullToDateTimeDataTransformer());
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'minutes' => self::DEFAULT_MINUTES,
        ]);
    }

    public function getParent(): string
    {
        return DateTimeType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'task_datetime';
    }
}
