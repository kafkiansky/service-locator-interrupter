<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter;

use Kafkiansky\ServiceLocatorInterrupter\Hooks;
use Psalm\Plugin\PluginEntryPointInterface;
use Psalm\Plugin\RegistrationInterface;
use SimpleXMLElement;

final class Plugin implements PluginEntryPointInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(RegistrationInterface $api, SimpleXMLElement $config = null): void
    {
        require_once __DIR__ . '/Hooks/PreventContainerInjection.php';
        require_once __DIR__ . '/Hooks/PreventFacadeCall.php';
        require_once __DIR__ . '/Hooks/PreventHelpersUsage.php';

        $api->registerHooksFromClass(Hooks\PreventContainerInjection::class);
        $api->registerHooksFromClass(Hooks\PreventFacadeCall::class);
        $api->registerHooksFromClass(Hooks\PreventHelpersUsage::class);
    }
}
