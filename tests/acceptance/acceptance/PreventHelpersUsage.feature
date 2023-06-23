@laravel-interrupter
Feature: Helpers call
  Prevent helpers call

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
  Scenario Outline: Asserting psalm recognizes helpers call and show issue
    Given I have the following code
    """
    <?php
    final class SomeService
    {
       public function do(): void
       {
          <func>(<argument>);
       }
    }
    """
    When I run Psalm
    Then I see these errors
      | Type       | Message                                                                     |
      | HelperUsed | Helper uses container as service locator, use dependency injection instead. |

    Examples:
      |func         | argument             |
      |app          | \stdClass::class     |
      |resolve      | \stdClass::class     |
      |event        | new \stdClass()      |
      |info         | 'Some info log'      |
      |logger       | 'Some log text'      |
      |logs         | null                 |
      |abort        | 404                  |
      |abort_if     | true , 404           |
      |abort_unless | true , 404           |
      |auth         | 'web'                |
      |back         | 302                  |
      |broadcast    | null                 |
      |cache        | null                 |
      |config       | 'app.some'           |
      |cookie       | 'x-developer'        |
      |dispatch     | new \stdClass()      |
      |dispatch_sync| new \stdClass()      |
      |redirect     | '/dev/null'          |
      |report       | new \Exception()     |
      |request      | 'key'                |
      |response     | 'null content'       |
      |route        | 'home'               |
      |session      | 'user_id'            |
      |trans        | 'service_locator'    |
      |trans_choice | 'key', 2             |
      |url          | 'localhost'          |
      |validator    | 'di !== helper'      |
      |view         | 'narrow'             |
      |encrypt      | 'value'              |
      |decrypt      | 'value'              |
      |action       | 'test'               |
      |app_path     | 'storage'            |
      |asset        | 'css'                |
      |base_path    | ''                   |
      |bcrypt       | 'value'              |
      |config_path  | 'app.providers'      |
      |csrf_token   |                      |
      |database_path| ''                   |
      |lang_path    | ''                   |
      |old          | 'key'                |
      |policy       | \stdClass::class     |
      |precognitive |null                  |
      |public_path  |''                    |
      |report_if    |true, new \Exception()|
      |report_unless|true, new \Exception()|
      |resource_path|''                    |
      |secure_asset |''                    |
      |secure_url   |''                    |
      |storage_path |''                    |
      |to_route     |'main'                |
      |__           |'key'                 |

  Scenario: Assert that we can use simple function and psalm no see errors.
    Given I have the following code
    """
    <?php
    final class SomeService
    {
      public function do(): void
      {
         $_output = array_map(function (int $el) { return $el + 1; }, [1, 2, 3]);
      }
    }
    """
    When I run Psalm
    Then I see no errors