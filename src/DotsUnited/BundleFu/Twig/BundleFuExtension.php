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

use DotsUnited\BundleFu\Bundle;
use DotsUnited\BundleFu\Filter\FilterInterface;
use DotsUnited\BundleFu\Twig\TokenParser\BundleTokenParser;

class BundleFuExtension extends \Twig_Extension
{
    protected $options = array();
    protected $filters = array();

    public function __construct(array $options = array(), array $filters = array())
    {
        $this->options = $options;
        $this->filters = $filters;
    }

    public function addOption($name, $value)
    {
        $this->options[$name] = $value;

        return $this;
    }

    public function addFilter($name, FilterInterface $filter)
    {
        $this->filters[$name] = $filter;

        return $this;
    }

    public function createBundle(array $options = array())
    {
        $options = array_merge($this->options, $options);

        if (isset($options['css_filter']) && is_string($options['css_filter'])) {
            if (!isset($this->filters[$options['css_filter']])) {
                throw new \Twig_Error_Runtime('There is no filter with the name "' . $options['css_filter'] . '" registered.');
            }

            $options['css_filter'] = $this->filters[$options['css_filter']];
        }

        if (isset($options['js_filter']) && is_string($options['js_filter'])) {
            if (!isset($this->filters[$options['js_filter']])) {
                 throw new \Twig_Error_Runtime('There is no filter with the name "' . $options['js_filter'] . '" registered.');
            }

            $options['js_filter'] = $this->filters[$options['js_filter']];
        }

        $bundle = new Bundle();
        $bundle->setOptions($options);

        return $bundle;
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
