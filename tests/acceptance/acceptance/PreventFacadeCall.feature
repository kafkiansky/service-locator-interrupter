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
  Scenario: Asserting psalm recognizes facade call and show issue
    Given I have the following code
    """
    <?php
    final class AuthorizationService
    {
       public function checkCredentials(): void
       {
          $user = \Illuminate\Support\Facades\Auth::user();
       }
    }
    """
    When I run Psalm
    Then I see these errors
      | Type         | Message                                                                                                           |
      | FacadeCalled | Facade use static call for proxying to original class method through container. Use dependency injection instead. |