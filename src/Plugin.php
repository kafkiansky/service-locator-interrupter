<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter;

use Psalm\Plugin\EventHandler\AfterEveryFunctionCallAnalysisInterface;
use Psalm\Plugin\EventHandler\AfterExpressionAnalysisInterface;
use Psalm\Plugin\EventHandler\AfterFunctionLikeAnalysisInterface;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;

/**
 * @api
 */
final class Plugin implements PluginEntryPointInterface
{
    public function __invoke(RegistrationInterface $registration, ?\SimpleXMLElement $config = null): void
    {
        foreach (self::hooks() as $hook) {
            /** @psalm-suppress UnresolvableInclude */
            require_once __DIR__ . '/' . str_replace([__NAMESPACE__, '\\'], ['', '/'], $hook) . '.php';

            $registration->registerHooksFromClass($hook);
        }
    }

    /**
     * @return iterable<class-string<AfterFunctionLikeAnalysisInterface>|class-string<AfterExpressionAnalysisInterface>|class-string<AfterEveryFunctionCallAnalysisInterface>>
     */
    private static function hooks(): iterable
    {
        yield EventHandler\PreventContainerUsage::class;
        yield EventHandler\PreventFacadeCall::class;
        yield EventHandler\PreventHelpersUsage::class;
    }
}
