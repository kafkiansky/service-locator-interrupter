@laravel-interrupter
Feature: Facade call
  Prevent facade call

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
  Scenario Outline: Asserting psalm recognizes facade call and show issue
    Given I have the following code
    """
    <?php
    final class SomeService
    {
       public function do(): void
       {
          <facadeName>::<method>;
       }
    }
    """
    When I run Psalm
    Then I see these errors
      | Type         | Message                                                                                                           |
      | FacadeCalled | Facade use static call for proxying to original class method through container. Use dependency injection instead. |

    Examples:
      |facadeName                                                     | method                             |
      |\Illuminate\Support\Facades\Auth                               | user()                             |
      |\Illuminate\Support\Facades\Broadcast                          | connection()                       |
      |\Illuminate\Support\Facades\Blade                              | withDoubleEncoding()               |
      |\Illuminate\Support\Facades\Notification                       | locale()                           |
      |\Illuminate\Support\Facades\Bus                                | hasCommandHandler(new \stdClass()) |
      |\Illuminate\Support\Facades\Crypt                              | getKey()                           |
      |\Illuminate\Support\Facades\Redirect                           | getUrlGenerator()                  |
      |\Illuminate\Support\Facades\Schema                             | defaultStringLength(255)           |
      |\Illuminate\Support\Facades\Log                                | info('Facade was called')          |
      |\Illuminate\Support\Facades\Storage                            | exists('/../../../vendor')         |
      |\Illuminate\Support\Facades\View                               | exists('some.blade.php')           |
      |\Illuminate\Support\Facades\Redis                              | connection('persistence')          |
      |\Illuminate\Support\Facades\Route                              | currentRouteName('nothing')        |
      |\Illuminate\Support\Facades\Date                               | today()                            |
      |\Illuminate\Support\Facades\Artisan                            | all()                              |
      |\Illuminate\Support\Facades\DB                                 | transactionLevel()                 |
      |\Illuminate\Support\Facades\Request                            | url()                              |
      |\Illuminate\Support\Facades\URL                                | current()                          |
      |\Illuminate\Support\Facades\Queue                              | getConnectionName()                |
      |\Illuminate\Support\Facades\Config                             | all()                              |
      |\Illuminate\Support\Facades\Http                               | asJson()                           |
      |\Illuminate\Support\Facades\Cookie                             | getQueuedCookies()                 |
      |\Illuminate\Support\Facades\File                               | isFile('/../../../vendor')         |
      |\Illuminate\Support\Facades\Session                            | getName()                          |
      |\Illuminate\Support\Facades\Cache                              | has('key')                         |
      |\Illuminate\Support\Facades\Response                           | json(null)                         |
      |\Illuminate\Support\Facades\Gate                               | abilities()                        |
      |\Illuminate\Support\Facades\Mail                               | failures()                         |
      |\Illuminate\Support\Facades\App                                | getLocale()                        |
      |\Illuminate\Support\Facades\Event                              | forgetPushed()                     |
      |\Illuminate\Support\Facades\Validator                          | extendImplicit('string', 'null')   |
      |\Illuminate\Support\Facades\Hash                               | info('secret')                     |
      |\Illuminate\Support\Facades\Lang                               | getLocale()                        |
      |\Kafkiansky\ServiceLocatorInterrupter\Tests\stubs\ProximaFacade|methodMustNotBeCallFromFacade()     |

  Scenario: Assert that we can use static methods for other classes and psalm no see errors.
    Given I have the following code
    """
    <?php
    final class SomeService
    {
      public function do(): void
      {
         $_errors = \DateTimeImmutable::getLastErrors();
      }
    }
    """
    When I run Psalm
    Then I see no errors