<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 10:20
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class ScontoMaggiorazione
{
    use Traversable;

    public $Tipo;
    public $Percentuale;
    public $Importo;

    private function traverse(Reader $reader)
    {
        return;
    }
}