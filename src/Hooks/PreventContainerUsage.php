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
use Psalm\CodeLocation;
use Psalm\IssueBuffer;
use Psalm\Plugin\EventHandler\AfterExpressionAnalysisInterface;
use Psalm\Plugin\EventHandler\AfterFunctionLikeAnalysisInterface;
use Psalm\Plugin\EventHandler\Event\AfterExpressionAnalysisEvent;
use Psalm\Plugin\EventHandler\Event\AfterFunctionLikeAnalysisEvent;

final class PreventContainerUsage implements AfterFunctionLikeAnalysisInterface, AfterExpressionAnalysisInterface
{
    /**
     * @var array of container classes that laravel has.
     */
    private static array $containerClasses = [
        'Illuminate\Container\Container',
        'Illuminate\Foundation\Application',
    ];

    /**
     * @var array of container interfaces that laravel use.
     */
    private static array $containerInterfaces = [
        'Psr\Container\ContainerInterface',
        'Illuminate\Contracts\Container\Container',
        'Illuminate\Contracts\Foundation\Application',
    ];

    /**
     * {@inheritdoc}
     */
    public static function afterStatementAnalysis(AfterFunctionLikeAnalysisEvent $event): ?bool
    {
        $stmt = $event->getStmt();

        if ($stmt instanceof Node\Stmt\ClassMethod) {
            /** @var Node\Param $param */
            foreach ($stmt->params as $param) {
                if (
                    $param->type instanceof Node\Name
                    && $param->type->hasAttribute('resolvedName')
                    && self::isServiceLocatorCall($param->type->getAttribute('resolvedName'))
                ) {
                    IssueBuffer::accepts(
                        new ContainerUsed(
                            new CodeLocation($event->getStatementsSource(), $param)
                        ),
                        $event->getStatementsSource()->getSuppressedIssues()
                    );
                }
            }
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public static function afterExpressionAnalysis(AfterExpressionAnalysisEvent $event): ?bool
    {
        $expr = $event->getExpr();

        if ($expr instanceof Expr\StaticCall) {
            if ($expr->class->hasAttribute('resolvedName')) {
                $classOrInterface = $expr->class->getAttribute('resolvedName');

                if (self::isServiceLocatorCall($classOrInterface)) {
                    IssueBuffer::accepts(
                        new ContainerUsed(
                            new CodeLocation($event->getStatementsSource(), $expr)
                        ),
                        $event->getStatementsSource()->getSuppressedIssues()
                    );
                }
            }
        }

        return null;
    }

    /**
     * @param $resolvedName
     *
     * @return bool
     */
    private static function isServiceLocatorCall($resolvedName): bool
    {
        if (in_array($resolvedName, array_merge(self::$containerClasses, self::$containerInterfaces))) {
            return true;
        }

        try {
            $reflection = new \ReflectionClass($resolvedName);

            if (self::instanceOfContainer($reflection->getInterfaceNames(), self::$containerInterfaces)) {
                return true;
            }

            $parentsClass = [];

            while ($parent = $reflection->getParentClass()) {
                $parentsClass[] = $parent->getName();
                $reflection = $parent;
            }

            if (self::instanceOfContainer($parentsClass, self::$containerClasses)) {
                return true;
            }
        } catch (\ReflectionException $exception) {
        }

        return false;
    }

    /**
     * @param array $parents
     * @param array $declaringContainers
     *
     * @return bool
     */
    private static function instanceOfContainer(array $parents, array $declaringContainers): bool
    {
        $isContainer = false;

        foreach ($parents as $parent) {
            if (in_array($parent, $declaringContainers)) {
                $isContainer = true;
                break;
            }
        }

        return $isContainer;
    }
}
