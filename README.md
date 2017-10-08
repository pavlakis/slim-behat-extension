# A Behat 3 extension for Slim 3

### This extension was written based on the [Behat Laravel Extension](https://github.com/laracasts/Behat-Laravel-Extension)

## Can install it with composer through packagist

```
 composer require --dev pavlakis/slim-behat-extension
```

## On your behat.yml file add the extension within the _extensions_ section

```
    Pavlakis\Slim\Behat: ~
```

The above is the minimum setup as long as you are using [Akrabat's Slim 3 Skeleton](https://github.com/akrabat/slim3-skeleton) with the default location for `settings.php` at `app/settings.php` and `behat.yml` inside `tests/behat`.

This is the expected directory structure for the default configuration:

```
- my_app_dir
|___ app
    |_______ settings.php
    |_______ dependencies.php
|___ tests
    |_________ behat
    	       |_____ behat.yml


```

If `behat.yml` is in the root folder, use the following:

```yml

default:
  suites:
    default:
      contexts:
        - FeatureContext

  extensions:
    Pavlakis\Slim\Behat:
      config_file: app/settings.php
      dependencies_file: app/dependencies.php
      
```

Apart from the config (settings.php) all other parameters are optional, however you can also pass:

```
      config_file: ../../app/configs/settings_test.php
      dependencies_file: ../../app/dependencies.php
      middleware_file: ../../middleware.php
      routes_file: ../../routes.php
```

## In your *FeatureContext* file

* Include the _KernelAwareContext_ interface
* Include the _Pavlakis\Slim\Behat\Context\App_ trait
* Access the Slim 3 app using `$this->app`


### Feature Context example

Use the `logger` to log some text to ensure the extension works.

> FeatureContext.php

```php

<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Pavlakis\Slim\Behat\Context\App;
use Pavlakis\Slim\Behat\Context\KernelAwareContext;

class FeatureContext implements Context, KernelAwareContext
{
   use App;

    /**
     * @Then it works
     */

    public function itWorks()
   {
       /** @var \Psr\Log\LoggerInterface $logger */
       $logger = $this->app->getContainer()->get('logger');
       $logger->info("Slim-behat integration works!");
   }

    /**
     * @Given I load the slim-behat extension
     */
    public function iLoadTheSlimBehatExtension()
    {
    }
}

```

> test.feature

```gherkin

Feature: The extension works
  In order to see this extension works
  As a developer
  I need to be see something happening 

  Scenario: The extension works
    Given I load the slim-behat extension
    Then it works

```

### Feature Context example using Mink

```php
use Behat\Behat\Context\Context;

use Behat\MinkExtension\Context\MinkContext;
use Pavlakis\Slim\Behat\Context\App;
use Pavlakis\Slim\Behat\Context\KernelAwareContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context, KernelAwareContext
{
    use App;
}

```

### Accessing your dependencies

```php

$this->app->getContainer()

```

