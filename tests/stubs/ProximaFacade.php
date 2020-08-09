<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Tests\stubs;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void methodMustNotBeCallFromFacade()
 * @method static void call()
 */
final class ProximaFacade extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return Proxima::class;
    }
}
