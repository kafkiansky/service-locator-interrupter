<?php

/**
 * This file is part of service-locator-interrupter package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Hooks;

use Kafkiansky\ServiceLocatorInterrupter\Issues\ContainerUsed;
use PhpParser\Node;
use PhpParser\Node\Expr;
use Psalm\Codebase;
use Psalm\CodeLocation;
use Psalm\Context;
use Psalm\IssueBuffer;
use Psalm\Plugin\Hook\AfterExpressionAnalysisInterface;
use Psalm\Plugin\Hook\AfterFunctionLikeAnalysisInterface;
use Psalm\StatementsSource;
use Psalm\Storage\FunctionLikeStorage;

final class PreventContainerUsage implements AfterFunctionLikeAnalysisInterface, AfterExpressionAnalysisInterface
{
    /**
     * @var array of container classes that laravel has.
     */
    private static $containerClasses = [
        'Illuminate\Container\Container',
        'Illuminate\Foundation\Application',
    ];

    /**
     * @var array of container interfaces that laravel use.
     */
    private static $containerInterfaces = [
        'Psr\Container\ContainerInterface',
        'Illuminate\Contracts\Container\Container',
        'Illuminate\Contracts\Foundation\Application',
    ];

    /**
     * @var array of keywords that not be analyzed.
     */
    private static $whiteList = [
        'parent',
        'self',
        'static',
    ];

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
                    new ContainerUsed(
                        new CodeLocation($statementsSource, $param)
                    ),
                    $statementsSource->getSuppressedIssues()
                );
            }
        }
    }

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

        if (!$expr->class->hasAttribute('resolvedName')) {
            return;
        }

        $classOrInterface = $expr->class->getAttribute('resolvedName');

        if (null === $classOrInterface) {
            return;
        }

        if (self::isServiceLocatorCall($classOrInterface)) {
            IssueBuffer::accepts(
                new ContainerUsed(
                    new CodeLocation($statementsSource, $expr)
                ),
                $statementsSource->getSuppressedIssues()
            );
        }
    }

    /**
     * @param $resolvedName
     *
     * @return bool
     */
    private static function isServiceLocatorCall($resolvedName): bool
    {
        if (in_array($resolvedName, self::$whiteList)) {
            return false;
        }

        if (in_array($resolvedName, array_merge(self::$containerClasses, self::$containerInterfaces))) {
            return true;
        }

        $instanceOfContainer = static function (array $parents, array $declaringContainers): bool {
            $isContainer = false;

            foreach ($parents as $parent) {
                if (in_array($parent, $declaringContainers)) {
                    $isContainer = true;
                    break;
                }

                continue;
            }

            return $isContainer;
        };

        if ($classParents = class_parents($resolvedName)) {
            return $instanceOfContainer($classParents, self::$containerClasses);
        }

        if ($classImplements = class_implements($resolvedName)) {
            return $instanceOfContainer($classImplements, self::$containerInterfaces);
        }

        return false;
    }
}
