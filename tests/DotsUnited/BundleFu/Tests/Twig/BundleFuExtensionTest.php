<?php

/*
 * This file is part of BundleFuTwigExtension.
 *
 * (c) 2013 Jan Sorgalla <jan.sorgalla@dotsunited.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DotsUnited\BundleFu\Tests\Twig;

use DotsUnited\BundleFu\Twig\BundleFuExtension;

class BundleFuExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var \DotsUnited\BundleFu\Bundle
     */
    private $bundle;

    /**
     * @var \DotsUnited\BundleFu\Factory
     */
    private $factory;

    /**
     * @var array
     */
    private $options;

    public function setUp()
    {
        if (!class_exists('\\Twig_Environment')) {
            $this->markTestSkipped('Twig is not installed.');
        }

        $this->options = array(
            'name' => 'test_bundle',
            'doc_root' => '/my/docroot',
            'bypass' => false,
            'render_as_xhtml' => true,
            'css_filter' => 'css_filter',
            'js_filter' => 'js_filter',
            'css_cache_path' => 'cache',
            'js_cache_path' => 'cache',
            'css_cache_url' => '/cache',
            'js_cache_url' => '/cache',
        );

        $this->bundle = $this->getMock('DotsUnited\\BundleFu\\Bundle');

        $this->bundle
            ->expects($this->at(0))
            ->method('start')
            ->will($this->returnSelf());

        $this->bundle
            ->expects($this->at(1))
            ->method('end')
            ->will($this->returnSelf());

        $this->bundle
            ->expects($this->at(2))
            ->method('render')
            ->will($this->returnValue(''));

        $this->factory = $this->getMock('DotsUnited\\BundleFu\\Factory');

        $this->factory
            ->expects($this->once())
            ->method('createBundle')
            ->with($this->equalTo($this->options))
            ->will($this->returnValue($this->bundle));

        $this->twig = new \Twig_Environment();
        $this->twig->setLoader(new \Twig_Loader_Filesystem(__DIR__.'/_templates'));
        $this->twig->addExtension(new BundleFuExtension($this->factory));
    }

    public function testOptionsAsString()
    {
        $this->twig->loadTemplate('options_string.twig')->render(array());
    }

    public function testOptionsAsVariables()
    {
        $this->twig->loadTemplate('options_variable.twig')->render($this->options);
    }
}
