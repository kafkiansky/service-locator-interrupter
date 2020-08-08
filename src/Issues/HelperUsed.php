<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Issues;

use Psalm\CodeLocation;
use Psalm\Issue\PluginIssue;

final class HelperUsed extends PluginIssue
{
    public function __construct(CodeLocation $codeLocation)
    {
        parent::__construct(
            'Helper uses container as service locator, use dependency injection instead.',
            $codeLocation
        );
    }
}
