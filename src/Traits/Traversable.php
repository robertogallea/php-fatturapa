<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 08:34
 */

namespace Robertogallea\FatturaPA\Traits;


trait Traversable
{
    protected function traverse($reader)
    {
        throw new \BadMethodCallException();
    }

    public function __call($function, $args)
    {
        if ($function === 'traverse') {
            $this->traverse($args[0]);
        }
    }
}