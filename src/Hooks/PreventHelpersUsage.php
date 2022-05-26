<?php

/**
 * This file is part of service-locator-interrupter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Hooks;

use Kafkiansky\ServiceLocatorInterrupter\Issues\HelperUsed;
use Psalm\CodeLocation;
use Psalm\IssueBuffer;
use Psalm\Plugin\EventHandler\AfterEveryFunctionCallAnalysisInterface;
use Psalm\Plugin\EventHandler\Event\AfterEveryFunctionCallAnalysisEvent;

final class PreventHelpersUsage implements AfterEveryFunctionCallAnalysisInterface
{
    public static function afterEveryFunctionCallAnalysis(AfterEveryFunctionCallAnalysisEvent $event): void
    {
        $expr = $event->getExpr();

        if (self::isServiceLocatorHelperCall($expr->name->toString())) {
            IssueBuffer::accepts(
                new HelperUsed(
                    new CodeLocation($event->getStatementsSource(), $expr)
                ),
                $event->getStatementsSource()->getSuppressedIssues()
            );
        }
    }

    /**
     * @param string $functionName
     *
     * @return bool
     */
    private static function isServiceLocatorHelperCall(string $functionName): bool
    {
        return in_array(
            $functionName,
            [
                'resolve',
                'app',
                'event',
                'info',
                'logger',
                'logs',
                'abort',
                'abort_if',
                'abort_unless',
                'auth',
                'back',
                'broadcast',
                'cache',
                'config',
                'cookie',
                'dispatch',
                'dispatch_now',
                'redirect',
                'report',
                'request',
                'response',
                'route',
                'session',
                'trans',
                'trans_choice',
                'url',
                'validator',
                'view',
            ]
        );
    }
}
