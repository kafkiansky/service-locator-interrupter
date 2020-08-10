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
use Psalm\Codebase;
use Psalm\CodeLocation;
use Psalm\Context;
use Psalm\IssueBuffer;
use Psalm\Plugin\Hook\AfterExpressionAnalysisInterface;
use Psalm\StatementsSource;

final class PreventFacadeCall implements AfterExpressionAnalysisInterface
{
    /**
     * {@inheritdoc}
     */
    public static function afterExpressionAnalysis(
        Expr $expr,
        Context $context,
        StatementsSource $statementsSource,
        Codebase $codebase,
        array &$fileReplacements = []
    ): void {
        if (!$expr instanceof Expr\StaticCall) {
            return;
        }

        if (self::isFacadeCall($expr->class->getAttribute('resolvedName'))) {
            IssueBuffer::accepts(
                new FacadeCalled(
                    new CodeLocation($statementsSource, $expr)
                ),
                $statementsSource->getSuppressedIssues()
            );
        }
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
