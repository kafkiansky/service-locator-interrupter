# Psalm plugin that prevent service locator calls for Laravel applications.

![test](https://github.com/kafkiansky/service-locator-interrupter/workflows/test/badge.svg?event=push)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/kafkiansky/service-locator-interrupter.svg?style=flat-square)](https://scrutinizer-ci.com/g/kafkiansky/service-locator-interrupter)
[![StyleCI](https://styleci.io/repos/261290955/shield)](https://styleci.io/repos/261290955)
[![Total Downloads](https://img.shields.io/packagist/dt/kafkiansky/service-locator-interrupter.svg?style=flat-square)](https://packagist.org/packages/kafkiansky/service-locator-interrupter)
[![Codecov](https://codecov.io/gh/kafkiansky/service-locator-interrupter/branch/master/graph/badge.svg)](https://codecov.io/gh/kafkiansky/service-locator-interrupter)

### Contents:
- [Installation](#installation)
- [WHY](#why)
- [Dependency Injection](#dependency-injection)
- [Testing](#testing)
- [License](#license)

## Installation

Install this package with Composer:

```bash
composer require kafkiansky/service-locator-interrupter "1.0.1"
```

## WHY
Laravel-like developers prefer to use some kinds of ioc bad practices.
In example: facades, helpers method, container injection and container instances creation anywhere: controllers, services, routes and even in models (wtf?).
You need inject necessary services in method and constructor, not call container to do it for you.
Any services **must has** it own contract, container injection - it's not legal contract, it's hack.

This plugin can found issues of service locator usage - helpers, facades, container injection, container instances creation - and prevent them.

**Even if you have your own facade, the plugin will be found it**.

**Even if you have inherited `Container/Application` classes, the plugin will be found it**.

**Even if you have implemented any fo `ContainerInterface`, the plugin also prevent that**.

## Dependency Injection

#### Replacement map
<table>
<thead>
    <th>Helper(s)/Facade</th>
    <th>What you <b>need</b> to use instead</th>
</thead>
<tbody>
    <tr>
        <td>
            <code>event</code>,<code>\Illuminate\Support\Facades\Event</code>
        </td>
        <td>
            <code>\Illuminate\Events\Dispatcher::class</code>,<code>\Illuminate\Contracts\Events\Dispatcher::class</code>
        </td> 
    </tr>
    <tr>
        <td>
            <code>info</code>,<code>\Illuminate\Support\Facades\Log</code>
        </td> 
        <td>
            <code>\Illuminate\Log\LogManager::class</code>, <code>\Psr\Log\LoggerInterface::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>logger</code>,<code>\Illuminate\Support\Facades\Log</code>
        </td>
        <td>
            <code>\Illuminate\Log\LogManager::class</code>, <code>\Psr\Log\LoggerInterface::class</code>
        </td>
    </tr>
    <tr>
        <td>
           <code>logs</code>,<code>\Illuminate\Support\Facades\Log</code>
        </td>
        <td>
           <code>\Illuminate\Log\LogManager::class</code>, <code>\Psr\Log\LoggerInterface::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>abort, abort_if, abort_unless</code>
        </td>
        <td>
            <code>\Illuminate\Http\Exceptions\HttpResponseException</code>, <code>\Symfony\Component\HttpKernel\Exception\HttpException</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>auth</code>, <code>\Illuminate\Support\Facades\Auth</code>
        </td>
        <td>
            <code>\Illuminate\Auth\AuthManager::class</code>, <code>\Illuminate\Contracts\Auth\Factory::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>back</code>
        </td>
        <td>
            <code>\Illuminate\Routing\Redirector</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>broadcast</code>, <code>\Illuminate\Support\Facades\Broadcast</code>
        </td>
        <td>
            <code>\Illuminate\Broadcasting\BroadcastManager</code>, <code>\Illuminate\Contracts\Broadcasting\Factory</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>cache</code>, <code>\Illuminate\Support\Facades\Cache</code>
        </td>
        <td>
            <code>\Illuminate\Cache\CacheManager::class</code>, <code>\Illuminate\Contracts\Cache\Factory::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>config</code>, <code>\Illuminate\Support\Facades\Config</code>
        </td>
        <td>
            <code>\Illuminate\Config\Repository::class</code>, <code>\Illuminate\Contracts\Config\Repository::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>cookie</code>, <code>\Illuminate\Support\Facades\Cookie</code>
        </td>
        <td>
            <code>\Illuminate\Cookie\CookieJar::class</code>,
            <code>\Illuminate\Contracts\Cookie\Factory::class</code>,
            <code>\Illuminate\Contracts\Cookie\QueueingFactory::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>dispatch, dispatch_now</code>
        </td>
        <td>
            <code>\Illuminate\Contracts\Bus\Dispatcher</code>,
            <code>\Illuminate\Bus\Dispatcher</code>,
            <code>\Illuminate\Contracts\Bus\QueueingDispatcher</code>,
        </td>
    </tr>
    <tr>
        <td>
            <code>redirect</code>, <code>\Illuminate\Support\Facades\Redirect</code>
        </td>
        <td>
            <code>\Illuminate\Routing\Redirector</code>, <code>\Illuminate\Http\RedirectResponse</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>report</code>
        </td>
        <td>
            <code>\Illuminate\Contracts\Debug\ExceptionHandler</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>request</code>, <code>\Illuminate\Support\Facades\Request</code>
        </td>
        <td>
            <code>\Illuminate\Http\Request::class</code>, <code>\Symfony\Component\HttpFoundation\Request::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>response</code>, <code>\Illuminate\Support\Facades\Response</code>
        </td>
        <td>
            <code>\Illuminate\Contracts\Routing\ResponseFactory</code>,
            <code>\Illuminate\Routing\ResponseFactory</code>,
        </td>
    </tr>
    <tr>
        <td>
            <code>route</code>, <code>\Illuminate\Support\Facades\Route</code>
        </td>
        <td>
            <code>\Illuminate\Routing\UrlGenerator::class</code>,
            <code>\Illuminate\Contracts\Routing\UrlGenerator::class</code>,
        </td>
    </tr>
    <tr>
        <td>
            <code>url</code>, <code>\Illuminate\Support\Facades\URL</code>
        </td>
        <td>
            <code>\Illuminate\Routing\UrlGenerator::class</code>,
            <code>\Illuminate\Contracts\Routing\UrlGenerator::class</code>,
        </td>
    </tr>
    <tr>
        <td>
            <code>session</code>, <code>\Illuminate\Support\Facades\Session</code>
        </td>
        <td>
            <code>\Illuminate\Session\SessionManager::class</code>,
            <code>\Illuminate\Session\Store::class</code>,
            <code>\Illuminate\Contracts\Session\Session::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>trans, trans_choice</code>
        </td>
        <td>
            <code>\Illuminate\Contracts\Translation\Translator</code>,
            <code>\Illuminate\Translation\Translator</code>,
        </td>
    </tr>
    <tr>
        <td>
            <code>validator</code>, <code>\Illuminate\Support\Facades\Validator</code>
        </td>
        <td>
            <code>\Illuminate\Validation\Factory::class</code>,
            <code>\Illuminate\Contracts\Validation\Factory::class</code>
        </td>
    </tr>
    <tr>
        <td>
            <code>view</code>, <code>\Illuminate\Support\Facades\View</code>
        </td>
        <td>
            <code>\Illuminate\View\Factory::class</code>,
            <code>\Illuminate\Contracts\View\Factory::class</code>
        </td>
    </tr>
</tbody>
</table>

## Testing

``` bash
$ composer test
```  

## License

The MIT License (MIT). See [License File](LICENSE.md) for more information.