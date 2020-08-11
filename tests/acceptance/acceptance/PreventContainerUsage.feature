@laravel-interrupter
Feature: Container Used
  Prevent container usage

  Background:
    Given I have the following config
     """
     <?xml version="1.0"?>
      <psalm errorLevel="1">
        <projectFiles>
          <directory name="."/>
          <ignoreFiles> <directory name="../../vendor"/> </ignoreFiles>
        </projectFiles>
        <plugins>
          <pluginClass class="Kafkiansky\ServiceLocatorInterrupter\Plugin"/>
        </plugins>
      </psalm>
      """
  Scenario Outline: Asserting psalm recognizes container injection and show issue
    Given I have the following code
    """
    <?php

    namespace Kafkiansky\ServiceLocatorInterrupter\Tests\_run;

    final class SomeService
    {
       public function do(<injectedContainer> $container): void
       {
       }
    }
    """
    When I run Psalm
    Then I see these errors
      | Type          | Message                                          |
      | ContainerUsed | Don't use container, inject necessary services. |

    Examples:
      |injectedContainer                                                               |
      |\Psr\Container\ContainerInterface                                               |
      |\Illuminate\Contracts\Container\Container                                       |
      |\Illuminate\Contracts\Foundation\Application                                    |
      |\Illuminate\Container\Container                                                 |
      |\Illuminate\Foundation\Application                                              |
      |\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\ExtendedApplication           |
      |\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\ExtendedContainer             |
      |\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\ImplementedLaravelApplication |
      |\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\ImplementedLaravelContainer   |
      |\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\ImplementedPsrContainer       |

  Scenario Outline: Asserting psalm recognizes container instance creation and show issue
    Given I have the following code
    """
    <?php

    namespace Kafkiansky\ServiceLocatorInterrupter\Tests\_run;

    final class SomeService
    {
       public function do(): void
       {
          <containerInstance>::getInstance();
       }
    }
    """
    When I run Psalm
    Then I see these errors
      | Type          | Message                                         |
      | ContainerUsed | Don't use container, inject necessary services. |

    Examples:
      |containerInstance                                                     |
      |\Illuminate\Container\Container                                       |
      |\Illuminate\Foundation\Application                                    |
      |\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\ExtendedApplication |
      |\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\ExtendedContainer   |

  Scenario: Assert that we can inject other service and psalm no see errors
    Given I have the following code
    """
    <?php
    final class SomeService
    {
      public function do(\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\Proxima $proxima): void
      {
         $proxima->call();
      }
    }
    """
    When I run Psalm
    Then I see no errors

  Scenario: Assert that we can use other service instances and psalm no see errors
    Given I have the following code
    """
    <?php
    final class SomeService
    {
      public function do(\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\Proxima $proxima): void
      {
         \Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\Proxima::getInstance();
      }
    }
    """
    When I run Psalm
    Then I see no errors