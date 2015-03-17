# Mustache
## Summery

Zend Framework 2 module providing integration with [mustache.php](https://github.com/bobthecow/mustache.php/wiki) rendering engine

## Requirements

  * Zend Framework 2 (https://github.com/zendframework/zf2). Tested on *Zend Framework 2.0.0rc6*.

## Installation

### Composer installation

  1. `cd my/project/directory`
  2. create a `composer.json` file with following content:

     ```json
     {
         "require": {
             "widmogrod/zf2-mustache-module": "dev-master"
         }
     }
     ```
  3. run `php composer.phar install`
  4. open my/project/folder/configs/application.config.php and add 'Mustache' to your 'modules' parameter.

## How to add Mustache rendering to ZF2

Add to your Application module config file (module.config.php) new rendering strategy as following:

```php
<?php
return array(

    'view_manager' => array(
        // add this
        'strategies' => array(
            'Mustache\View\Strategy'
        ),
    ),
);
```

## How to configure partials

  Add to your Application module config file (module.config.php)
```php
<?php
return array(

    'mustache' => array(
        'partials_loader' => array( __DIR__ . '/../view/partials')
    ),
);
```