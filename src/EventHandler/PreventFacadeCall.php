<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\EventHandler;

use Kafkiansky\ServiceLocatorInterrupter\Issues\FacadeCalled;
use PhpParser\Node\Expr;
use Psalm\CodeLocation;
use Psalm\IssueBuffer;
use Psalm\Plugin\EventHandler\AfterExpressionAnalysisInterface;
use Psalm\Plugin\EventHandler\Event\AfterExpressionAnalysisEvent;

final class PreventFacadeCall implements AfterExpressionAnalysisInterface
{
    /**
     * {@inheritdoc}
     */
    public static function afterExpressionAnalysis(AfterExpressionAnalysisEvent $event): ?bool
    {
        $expr = $event->getExpr();

        if ($expr instanceof Expr\StaticCall && $expr->class->hasAttribute('resolvedName')) {
            /** @var null|string $name */
            $name = $expr->class->getAttribute('resolvedName');

            if (null !== $name && self::isFacadeCall($name)) {
                IssueBuffer::accepts(
                    new FacadeCalled(
                        new CodeLocation($event->getStatementsSource(), $expr)
                    ),
                    $event->getStatementsSource()->getSuppressedIssues(),
                );
            }
        }

        return null;
    }

    private static function isFacadeCall(string $facadeName): bool
    {
        if (str_contains($facadeName, 'Illuminate\Support\Facades')) {
            return true;
        }

        return class_exists($facadeName) && is_subclass_of($facadeName, \Illuminate\Support\Facades\Facade::class);
    }
}
