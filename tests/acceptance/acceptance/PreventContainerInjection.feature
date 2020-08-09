@laravel-interrupter
Feature: Container Injection
  Prevent container injection

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
    final class SomeService
    {
       public function do(<injectedContainer> $container): void
       {
       }
    }
    """
    When I run Psalm
    Then I see these errors
      | Type              | Message                                            |
      | ContainerInjected | Don't inject container, inject necessary services. |

    Examples:
      |injectedContainer                            |
      |\Psr\Container\ContainerInterface            |
      |\Illuminate\Contracts\Container\Container    |
      |\Illuminate\Contracts\Foundation\Application |
      |\Illuminate\Container\Container              |
      |\Illuminate\Foundation\Application           |

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