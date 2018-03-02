<?php

declare(strict_types=1);

namespace Guham\TaskManagerBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;

class NullToDateTimeDataTransformer implements DataTransformerInterface
{
    public function transform($value)
    {
        return $value;
    }

    public function reverseTransform($value)
    {
        if ($value) {
            return $value;
        }

        $date = new \DateTimeImmutable();

        return $date->setTime((int) $date->format('H'), 0);
    }
}
