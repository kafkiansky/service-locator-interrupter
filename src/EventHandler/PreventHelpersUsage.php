<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\EventHandler;

use Kafkiansky\ServiceLocatorInterrupter\Issues\HelperUsed;
use PhpParser\Node\Name;
use Psalm\CodeLocation;
use Psalm\IssueBuffer;
use Psalm\Plugin\EventHandler\AfterEveryFunctionCallAnalysisInterface;
use Psalm\Plugin\EventHandler\Event\AfterEveryFunctionCallAnalysisEvent;

final class PreventHelpersUsage implements AfterEveryFunctionCallAnalysisInterface
{
    public static function afterEveryFunctionCallAnalysis(AfterEveryFunctionCallAnalysisEvent $event): void
    {
        if ($event->getExpr()->name instanceof Name) {
            if (self::isServiceLocatorHelperCall($event->getExpr()->name->toString())) {
                IssueBuffer::accepts(
                    new HelperUsed(
                        new CodeLocation($event->getStatementsSource(), $event->getExpr())
                    ),
                    $event->getStatementsSource()->getSuppressedIssues(),
                );
            }
        }
    }

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
                'dispatch_sync',
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
                'encrypt',
                'decrypt',
                'action',
                'app_path',
                'asset',
                'base_path',
                'bcrypt',
                'config_path',
                'csrf_token',
                'database_path',
                'lang_path',
                'old',
                'policy',
                'precognitive',
                'public_path',
                'report_if',
                'report_unless',
                'resource_path',
                'secure_asset',
                'secure_url',
                'storage_path',
                'to_route',
                '__',
            ],
        );
    }
}
