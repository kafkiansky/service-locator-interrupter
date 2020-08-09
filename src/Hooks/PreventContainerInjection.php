<?php

/**
 * This file is part of service-locator-interrupter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Hooks;

use Kafkiansky\ServiceLocatorInterrupter\Issues\ContainerInjected;
use PhpParser\Node;
use Psalm\Codebase;
use Psalm\CodeLocation;
use Psalm\IssueBuffer;
use Psalm\Plugin\Hook\AfterFunctionLikeAnalysisInterface;
use Psalm\StatementsSource;
use Psalm\Storage\FunctionLikeStorage;

final class PreventContainerInjection implements AfterFunctionLikeAnalysisInterface
{
    /**
     * {@inheritdoc}
     */
    public static function afterStatementAnalysis(
        Node\FunctionLike $stmt,
        FunctionLikeStorage $classLikeStorage,
        StatementsSource $statementsSource,
        Codebase $codebase,
        array &$fileReplacements = []
    ): void {
        if (!$stmt instanceof Node\Stmt\ClassMethod) {
            return;
        }

        /** @var Node\Param $param */
        foreach ($stmt->params as $param) {
            if (
                $param->type instanceof Node\Name
                && self::isServiceLocatorCall($param->type->getAttribute('resolvedName'))
            ) {
                IssueBuffer::accepts(
                    new ContainerInjected(
                        new CodeLocation($statementsSource, $param)
                    ),
                    $statementsSource->getSuppressedIssues()
                );
            }
        }
    }

    /**
     * @param mixed|null $resolvedName
     *
     * @return bool
     */
    public static function isServiceLocatorCall($resolvedName): bool
    {
        return in_array(
            $resolvedName,
            [
                'Psr\Container\ContainerInterface',
                'Illuminate\Contracts\Container\Container',
                'Illuminate\Contracts\Foundation\Application',
                'Illuminate\Container\Container',
                'Illuminate\Foundation\Application',
            ]
        );
    }
}
