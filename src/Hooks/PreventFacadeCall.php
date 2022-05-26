<?php

/**
 * This file is part of service-locator-interrupter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Hooks;

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

        if ($expr instanceof Expr\StaticCall) {
            if (self::isFacadeCall($expr->class->getAttribute('resolvedName'))) {
                IssueBuffer::accepts(
                    new FacadeCalled(
                        new CodeLocation($event->getStatementsSource(), $expr)
                    ),
                    $event->getStatementsSource()->getSuppressedIssues()
                );
            }
        }

        return null;
    }

    /**
     * @param mixed|null $facadeName
     *
     * @return bool
     */
    private static function isFacadeCall($facadeName): bool
    {
        if (null === $facadeName) {
            return false;
        }

        if (false !== strpos($facadeName, 'Illuminate\Support\Facades')) {
            return true;
        }

        return class_exists($facadeName) && is_subclass_of($facadeName, 'Illuminate\Support\Facades\Facade');
    }
}
