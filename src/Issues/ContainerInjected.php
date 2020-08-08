<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Issues;

use Psalm\CodeLocation;
use Psalm\Issue\PluginIssue;

final class ContainerInjected extends PluginIssue
{
    public function __construct(CodeLocation $codeLocation)
    {
        parent::__construct('Don\'t inject container, inject necessary services.', $codeLocation);
    }
}
