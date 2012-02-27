<?php

/*
 * This file is part of BundleFuTwigExtension.
 *
 * (c) 2011 Jan Sorgalla <jan.sorgalla@dotsunited.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DotsUnited\BundleFu\Tests\Twig;

use DotsUnited\BundleFu\Tests\TestCase;
use DotsUnited\BundleFu\Twig\BundleFuExtension;

class BundleFuExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function setUp()
    {
        if (!class_exists('Twig_Environment')) {
            $this->markTestSkipped('Twig is not installed.');
        }

        $options = array(
            'doc_root' => __DIR__.'/_files',
            'render_as_xhtml' => true
        );

        $this->twig = new \Twig_Environment();
        $this->twig->setLoader(new \Twig_Loader_Filesystem(__DIR__.'/_templates'));
        $this->twig->addExtension(new BundleFuExtension($options, array()));
    }
    
    public function tearDown()
    {
        $paths = array(
            __DIR__ . '/_files/cache',
        );

        foreach ($paths as $path) {
            if (!file_exists($path)) {
                continue;
            }

            foreach (glob($path . '/*') as $file) {
                if ($file[0] == '.') {
                    continue;
                }
                unlink($file);
            }

            rmdir($path);
        }
    }

    public function testOptionsAsString()
    {
        $cssFilter = $this->getMock('DotsUnited\\BundleFu\\Filter\\FilterInterface');
        $cssFilter->expects($this->once())
            ->method('filter');

        $jsFilter = $this->getMock('DotsUnited\\BundleFu\\Filter\\FilterInterface');
        $jsFilter->expects($this->once())
            ->method('filter');

        $this->twig->getExtension('bundlefu')
            ->addFilter('css_filter', $cssFilter);

        $this->twig->getExtension('bundlefu')
            ->addFilter('js_filter', $jsFilter);

        $xml = $this->renderXml('options_string.twig');

        $this->assertEquals(1, count($xml->script));
        $this->assertStringStartsWith('/cache/test_bundle', (string) $xml->script['src']);

        $this->assertEquals(1, count($xml->link));
        $this->assertStringStartsWith('/cache/test_bundle', (string) $xml->link['href']);
    }

    public function testOptionsAsVariables()
    {
        $cssFilter = $this->getMock('DotsUnited\\BundleFu\\Filter\\FilterInterface');
        $cssFilter->expects($this->once())
            ->method('filter');

        $jsFilter = $this->getMock('DotsUnited\\BundleFu\\Filter\\FilterInterface');
        $jsFilter->expects($this->once())
            ->method('filter');

        $this->twig->getExtension('bundlefu')
            ->addOption('doc_root', '/')
            ->addOption('bypass', true)
            ->addOption('render_as_xhtml', false);

        $context = array(
            'name' => 'test_bundle',
            'doc_root' => __DIR__.'/_files',
            'bypass' => false,
            'render_as_xhtml' => true,
            'css_filter' => $cssFilter,
            'js_filter' => $jsFilter,
            'css_cache_path' => 'cache',
            'js_cache_path' => 'cache',
            'css_cache_url' => '/cache',
            'js_cache_url' => '/cache',
        );

        $xml = $this->renderXml('options_variable.twig', $context);

        $this->assertEquals(1, count($xml->script));
        $this->assertStringStartsWith('/cache/test_bundle', (string) $xml->script['src']);

        $this->assertEquals(1, count($xml->link));
        $this->assertStringStartsWith('/cache/test_bundle', (string) $xml->link['href']);
    }

    public function testUnregisteredCssFilterThrowsException()
    {
        $this->setExpectedException('\Twig_Error_Runtime', 'There is no filter with the name "foo" registered.');
        $this->renderXml('unregistered_css_filter.twig');
    }
    
    public function testUnregisteredJsFilterThrowsException()
    {
        $this->setExpectedException('\Twig_Error_Runtime', 'There is no filter with the name "foo" registered.');
        $this->renderXml('unregistered_js_filter.twig');
    }

    private function renderXml($name, $context = array())
    {
        return new \SimpleXMLElement($this->twig->loadTemplate($name)->render($context));
    }
}
