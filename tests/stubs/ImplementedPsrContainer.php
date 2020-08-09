<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Tests\stubs;

use Psr\Container\ContainerInterface;

final class ImplementedPsrContainer implements ContainerInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        // TODO: Implement has() method.
    }
}
