<?php

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
    /**
     * {@inheritdoc}
     */
    public static function afterEveryFunctionCallAnalysis(
        FuncCall $expr,
        string $functionId,
        Context $context,
        StatementsSource $statementsSource,
        Codebase $codebase
    ): void {
        if (self::isServiceLocatorHelperCall($expr->name->toString())) {
            IssueBuffer::accepts(
                new HelperUsed(
                    new CodeLocation($statementsSource, $expr)
                ),
                $statementsSource->getSuppressedIssues()
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
