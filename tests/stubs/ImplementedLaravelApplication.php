<?php

declare(strict_types=1);

namespace Kafkiansky\ServiceLocatorInterrupter\Tests\stubs;

use Closure;
use Illuminate\Contracts\Foundation\Application;

final class ImplementedLaravelApplication implements Application
{

    /**
     * {@inheritdoc}
     */
    public function version()
    {
        // TODO: Implement version() method.
    }

    /**
     * {@inheritdoc}
     */
    public function basePath($path = '')
    {
        // TODO: Implement basePath() method.
    }

    /**
     * {@inheritdoc}
     */
    public function bootstrapPath($path = '')
    {
        // TODO: Implement bootstrapPath() method.
    }

    /**
     * {@inheritdoc}
     */
    public function configPath($path = '')
    {
        // TODO: Implement configPath() method.
    }

    /**
     * {@inheritdoc}
     */
    public function databasePath($path = '')
    {
        // TODO: Implement databasePath() method.
    }

    /**
     * {@inheritdoc}
     */
    public function resourcePath($path = '')
    {
        // TODO: Implement resourcePath() method.
    }

    /**
     * {@inheritdoc}
     */
    public function storagePath()
    {
        // TODO: Implement storagePath() method.
    }

    /**
     * {@inheritdoc}
     */
    public function environment(...$environments)
    {
        // TODO: Implement environment() method.
    }

    /**
     * {@inheritdoc}
     */
    public function runningInConsole()
    {
        // TODO: Implement runningInConsole() method.
    }

    /**
     * {@inheritdoc}
     */
    public function runningUnitTests()
    {
        // TODO: Implement runningUnitTests() method.
    }

    /**
     * {@inheritdoc}
     */
    public function isDownForMaintenance()
    {
        // TODO: Implement isDownForMaintenance() method.
    }

    /**
     * {@inheritdoc}
     */
    public function registerConfiguredProviders()
    {
        // TODO: Implement registerConfiguredProviders() method.
    }

    /**
     * {@inheritdoc}
     */
    public function register($provider, $force = false)
    {
        // TODO: Implement register() method.
    }

    /**
     * {@inheritdoc}
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        // TODO: Implement registerDeferredProvider() method.
    }

    /**
     * {@inheritdoc}
     */
    public function resolveProvider($provider)
    {
        // TODO: Implement resolveProvider() method.
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // TODO: Implement boot() method.
    }

    /**
     * {@inheritdoc}
     */
    public function booting($callback)
    {
        // TODO: Implement booting() method.
    }

    /**
     * {@inheritdoc}
     */
    public function booted($callback)
    {
        // TODO: Implement booted() method.
    }

    /**
     * {@inheritdoc}
     */
    public function bootstrapWith(array $bootstrappers)
    {
        // TODO: Implement bootstrapWith() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale()
    {
        // TODO: Implement getLocale() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getNamespace()
    {
        // TODO: Implement getNamespace() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getProviders($provider)
    {
        // TODO: Implement getProviders() method.
    }

    /**
     * {@inheritdoc}
     */
    public function hasBeenBootstrapped()
    {
        // TODO: Implement hasBeenBootstrapped() method.
    }

    /**
     * {@inheritdoc}
     */
    public function loadDeferredProviders()
    {
        // TODO: Implement loadDeferredProviders() method.
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale($locale)
    {
        // TODO: Implement setLocale() method.
    }

    /**
     * {@inheritdoc}
     */
    public function shouldSkipMiddleware()
    {
        // TODO: Implement shouldSkipMiddleware() method.
    }

    /**
     * {@inheritdoc}
     */
    public function terminate()
    {
        // TODO: Implement terminate() method.
    }

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
