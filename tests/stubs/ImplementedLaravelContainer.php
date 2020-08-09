<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Tests\stubs;

use Closure;
use Illuminate\Contracts\Container\Container;

final class ImplementedLaravelContainer implements Container
{
    /**
     * {@inheritdoc}
     */
    public function bound($abstract)
    {
        // TODO: Implement bound() method.
    }

    /**
     * {@inheritdoc}
     */
    public function alias($abstract, $alias)
    {
        // TODO: Implement alias() method.
    }

    /**
     * {@inheritdoc}
     */
    public function tag($abstracts, $tags)
    {
        // TODO: Implement tag() method.
    }

    /**
     * {@inheritdoc}
     */
    public function tagged($tag)
    {
        // TODO: Implement tagged() method.
    }

    /**
     * {@inheritdoc}
     */
    public function bind($abstract, $concrete = null, $shared = false)
    {
        // TODO: Implement bind() method.
    }

    /**
     * {@inheritdoc}
     */
    public function bindIf($abstract, $concrete = null, $shared = false)
    {
        // TODO: Implement bindIf() method.
    }

    /**
     * {@inheritdoc}
     */
    public function singleton($abstract, $concrete = null)
    {
        // TODO: Implement singleton() method.
    }

    /**
     * {@inheritdoc}
     */
    public function singletonIf($abstract, $concrete = null)
    {
        // TODO: Implement singletonIf() method.
    }

    /**
     * {@inheritdoc}
     */
    public function extend($abstract, Closure $closure)
    {
        // TODO: Implement extend() method.
    }

    /**
     * {@inheritdoc}
     */
    public function instance($abstract, $instance)
    {
        // TODO: Implement instance() method.
    }

    /**
     * {@inheritdoc}
     */
    public function addContextualBinding($concrete, $abstract, $implementation)
    {
        // TODO: Implement addContextualBinding() method.
    }

    /**
     * {@inheritdoc}
     */
    public function when($concrete)
    {
        // TODO: Implement when() method.
    }

    /**
     * {@inheritdoc}
     */
    public function factory($abstract)
    {
        // TODO: Implement factory() method.
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        // TODO: Implement flush() method.
    }

    /**
     * {@inheritdoc}
     */
    public function make($abstract, array $parameters = [])
    {
        // TODO: Implement make() method.
    }

    /**
     * {@inheritdoc}
     */
    public function call($callback, array $parameters = [], $defaultMethod = null)
    {
        // TODO: Implement call() method.
    }

    /**
     * {@inheritdoc}
     */
    public function resolved($abstract)
    {
        // TODO: Implement resolved() method.
    }

    /**
     * {@inheritdoc}
     */
    public function resolving($abstract, Closure $callback = null)
    {
        // TODO: Implement resolving() method.
    }

    /**
     * {@inheritdoc}
     */
    public function afterResolving($abstract, Closure $callback = null)
    {
        // TODO: Implement afterResolving() method.
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        // TODO: Implement has() method.
    }
}
