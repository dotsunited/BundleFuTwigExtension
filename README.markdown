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

Usage
-----

Register the BundleFuExtension to your Twig environment:

```php
<?php
$factory = new \DotsUnited\BundleFu\Factory();
$extension = \DotsUnited\BundleFu\Twig\BundleFuExtension($factory);

$twig = new \Twig_Environment($loader);
$twig->addExtension($extension);
?>
```

The extension uses the factory to create bundle instances. See the [BundleFu documentation](https://github.com/dotsunited/BundleFu#readme) about how to configure the factory.

The extension exposes a new `bundle` tag with the following syntax:

```html
{% bundle name='test_bundle'
          doc_root = '/my/docroot'
          bypass=false
          render_as_xhtml=true
          css_filter='css_filter'
          js_filter='js_filter'
          css_cache_path='cache'
          js_cache_path='cache'
          css_cache_url='/cache'
          js_cache_url='/cache'
%}
<link href="/css_1.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="/js_1.js" type="text/javascript"></script>
{% endbundle %}
```

License
-------

BundleFuTwigExtension is released under the [New BSD License](https://github.com/dotsunited/BundleFuTwigExtension/blob/master/LICENSE).
