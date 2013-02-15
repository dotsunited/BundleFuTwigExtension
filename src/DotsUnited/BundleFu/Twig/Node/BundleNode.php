<?php

/*
 * This file is part of BundleFuTwigExtension.
 *
 * (c) 2013 Jan Sorgalla <jan.sorgalla@dotsunited.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DotsUnited\BundleFu\Twig\Node;

class BundleNode extends \Twig_Node
{
    public function __construct(\Twig_NodeInterface $body, \Twig_NodeInterface $options, $lineno = 0, $tag = null)
    {
        parent::__construct(array('body' => $body, 'options' => $options), array(), $lineno, $tag);
    }

    public function compile(\Twig_Compiler $compiler)
    {
        $compiler->addDebugInfo($this);

        $compiler
            ->write("\$_bundle_ = \$this->env->getExtension('bundlefu')->createBundle(array(\n")
            ->indent()
        ;

        foreach ($this->getNode('options') as $name => $option) {
            $compiler
                ->write('')
                ->string($name)
                ->raw(' => ')
                ->subcompile($option)
                ->raw(",\n")
            ;
        }

        $compiler
            ->outdent()
            ->write("))->start();\n\n")
            ->subcompile($this->getNode('body'))
            ->write("echo \$_bundle_->end();\n")
        ;
    }
}
