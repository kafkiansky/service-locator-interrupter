<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Tests\stubs;

final class Proxima
{
    public function methodMustNotBeCallFromFacade(): void
    {
    }

    public function call(): void
    {
    }

    public static function getInstance(): Proxima
    {
        return new self();
    }
}
