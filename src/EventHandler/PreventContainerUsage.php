<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\EventHandler;

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
    /** @var class-string[] */
    private static array $containerClasses = [
        \Illuminate\Container\Container::class,
        \Illuminate\Foundation\Application::class,
    ];

    /** @psalm-var interface-string[] */
    private static array $containerInterfaces = [
        \Psr\Container\ContainerInterface::class,
        \Illuminate\Contracts\Container\Container::class,
        \Illuminate\Contracts\Foundation\Application::class,
    ];

    /**
     * {@inheritdoc}
     */
    public static function afterStatementAnalysis(AfterFunctionLikeAnalysisEvent $event): ?bool
    {
        $stmt = $event->getStmt();

        if ($stmt instanceof Node\Stmt\ClassMethod) {
            foreach ($stmt->params as $param) {
                if ($param->type instanceof Node\Name && $param->type->hasAttribute('resolvedName')) {
                    /** @psalm-var class-string|interface-string $classOrInterface */
                    $classOrInterface = $param->type->getAttribute('resolvedName');

                    if (self::isServiceLocatorCall($classOrInterface)) {
                        IssueBuffer::accepts(
                            new ContainerUsed(
                                new CodeLocation($event->getStatementsSource(), $param)
                            ),
                            $event->getStatementsSource()->getSuppressedIssues(),
                        );
                    }
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
                /** @psalm-var class-string|interface-string $classOrInterface */
                $classOrInterface = $expr->class->getAttribute('resolvedName');

                if (self::isServiceLocatorCall($classOrInterface)) {
                    IssueBuffer::accepts(
                        new ContainerUsed(
                            new CodeLocation($event->getStatementsSource(), $expr)
                        ),
                        $event->getStatementsSource()->getSuppressedIssues(),
                    );
                }
            }
        }

        return null;
    }

    /**
     * @psalm-param class-string|interface-string $resolvedName
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
        } catch (\ReflectionException) {
        }

        return false;
    }

    /**
     * @param string[] $parents
     * @psalm-param class-string[]|interface-string[] $declaringContainers
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
