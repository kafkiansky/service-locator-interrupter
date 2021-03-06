<?php

/**
 * This file is part of service-locator-interrupter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Issues;

use Psalm\CodeLocation;
use Psalm\Issue\PluginIssue;

final class FacadeCalled extends PluginIssue
{
    public function __construct(CodeLocation $codeLocation)
    {
        parent::__construct(
            'Facade use static call for proxying to original class method through container. Use dependency injection instead.',
            $codeLocation
        );
    }
}
