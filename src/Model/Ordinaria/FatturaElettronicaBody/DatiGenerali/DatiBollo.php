<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:37
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiBollo
{
    use Traversable;

    public $BolloVirtuale;
    public $ImportoBollo;

    private function traverse(Reader $reader)
    {
        parent::traverse($reader);
    }
}