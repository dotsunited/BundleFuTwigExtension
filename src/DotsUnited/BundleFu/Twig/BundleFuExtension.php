<?php

/*
 * This file is part of BundleFuTwigExtension.
 *
 * (c) 2011 Jan Sorgalla <jan.sorgalla@dotsunited.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DotsUnited\BundleFu\Twig;

use DotsUnited\BundleFu\Factory;
use DotsUnited\BundleFu\Filter\FilterInterface;
use DotsUnited\BundleFu\Twig\TokenParser\BundleTokenParser;

class BundleFuExtension extends \Twig_Extension
{
    /**
     * @var \DotsUnited\BundleFu\Factory
     */
    protected $factory = array();

    /**
     * @param \DotsUnited\BundleFu\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return \DotsUnited\BundleFu\Factory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param array $options
     * @return \DotsUnited\BundleFu\Bundle
     */
    public function createBundle(array $options = array())
    {
        return $this->getFactory()->createBundle($options);
    }

    public function getTokenParsers()
    {
        return array(
            new BundleTokenParser(),
        );
    }

    public function getName()
    {
        return 'bundlefu';
    }
}
