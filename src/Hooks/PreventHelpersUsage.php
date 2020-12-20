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
use PhpParser\Node\Expr\FuncCall;
use Psalm\Codebase;
use Psalm\CodeLocation;
use Psalm\Context;
use Psalm\IssueBuffer;
use Psalm\Plugin\Hook\AfterEveryFunctionCallAnalysisInterface;
use Psalm\StatementsSource;

final class PreventHelpersUsage implements AfterEveryFunctionCallAnalysisInterface
{
    public static function afterEveryFunctionCallAnalysis(
        FuncCall $expr,
        string $function_id,
        Context $context,
        StatementsSource $statements_source,
        Codebase $codebase
    ): void {
        if (self::isServiceLocatorHelperCall($expr->name->toString())) {
            IssueBuffer::accepts(
                new HelperUsed(
                    new CodeLocation($statements_source, $expr)
                ),
                $statements_source->getSuppressedIssues()
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
