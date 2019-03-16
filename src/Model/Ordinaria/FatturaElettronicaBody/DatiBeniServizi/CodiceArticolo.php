<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiBeniServizi;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class CodiceArticolo
{
    use Traversable;

    public $CodiceTipo;
    public $CodiceValore;

    private function traverse(Reader $reader)
    {
        return;
    }
}