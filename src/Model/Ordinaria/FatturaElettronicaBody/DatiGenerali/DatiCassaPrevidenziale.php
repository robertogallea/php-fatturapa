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

class DatiCassaPrevidenziale
{
    use Traversable;

    public $TipoCassa;
    public $AlCassa;
    public $ImportoContributoCassa;
    public $ImponibileCassa;
    public $AliquotaIVA;
    public $Ritenuta;
    public $Natura;
    public $RiferimentoAmministrazione;

    private function traverse(Reader $reader)
    {
        parent::traverse($reader);
    }
}