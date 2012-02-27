<?php

/*
 * This file is part of BundleFuTwigExtension.
 *
 * (c) 2011 Jan Sorgalla <jan.sorgalla@dotsunited.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DotsUnited\BundleFu\Twig\TokenParser;

use DotsUnited\BundleFu\Twig\Node\BundleNode;

class BundleTokenParser extends \Twig_TokenParser
{
    public function getTag()
    {
        return 'bundle';
    }

    public function parse(\Twig_Token $token)
    {
        $lineno = $token->getLine();
        $stream = $this->parser->getStream();

        $options = array();

        while (!$stream->test(\Twig_Token::BLOCK_END_TYPE)) {
            if ($stream->test(\Twig_Token::NAME_TYPE)) {
                $name = $stream->getCurrent()->getValue();
                $stream->next();
                $stream->expect(\Twig_Token::OPERATOR_TYPE, '=');
                $options[$name] = $this->parser->getExpressionParser()->parseExpression();
            } else {
                $token = $stream->getCurrent();
                throw new \Twig_Error_Syntax(sprintf('Unexpected token "%s" of value "%s"', \Twig_Token::typeToEnglish($token->getType(), $token->getLine()), $token->getValue()), $token->getLine());
            }
        }

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        $body = $this->parser->subparse(function(\Twig_Token $token) { return $token->test('endbundle'); }, true);

        $stream->expect(\Twig_Token::BLOCK_END_TYPE);

        return new BundleNode($body, new \Twig_Node($options), $lineno, $this->getTag());
    }
}
