<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:35
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiBeniServizi;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class AltriDatiGestionali
{
    use Traversable;

    public $TipoDato;
    public $RiferimentoTesto;
    public $RiferimentoNumero;
    public $RiferimentoData;

    private function traverse(Reader $reader)
    {
        return;
    }
}