Twig extension for BundleFu
===========================

[![Build Status](https://secure.travis-ci.org/dotsunited/BundleFuTwigExtension.png?branch=master)](http://travis-ci.org/dotsunited/BundleFuTwigExtension)

The BundleFuTwigExtension integrates [BundleFu](https://github.com/dotsunited/BundleFu) into the [Twig template engine](http://twig.sensiolabs.org).

Installation
------------

BundleFuTwigExtension can be installed using the [Composer](http://packagist.org) tool. You can either add `dotsunited/bundlefu-twig-extension` to the dependencies in your composer.json, or if you want to install BundleFuTwigExtension as standalone, go to the main directory and run:

```bash
$ wget http://getcomposer.org/composer.phar 
$ php composer.phar install
```

You can then use the composer-generated autoloader to access the BundleFuTwigExtension classes:

```php
<?php
require 'vendor/.composer/autoload.php';
?>
```

License
-------

BundleFuTwigExtension is released under the [New BSD License](https://github.com/dotsunited/BundleFuTwigExtension/blob/master/LICENSE).
