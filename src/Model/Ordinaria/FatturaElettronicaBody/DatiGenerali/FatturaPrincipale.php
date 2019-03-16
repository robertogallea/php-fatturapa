<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:39
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class FatturaPrincipale
{
    use Traversable;

    public $NumeroFatturaPrincipale;
    public $DataFatturaPrincipale;

    private function traverse(Reader $reader)
    {
        parent::traverse($reader);
    }
}