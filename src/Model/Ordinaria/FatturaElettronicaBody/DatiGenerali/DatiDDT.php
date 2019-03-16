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

class DatiDDT
{
    use Traversable;

    public $NumeroDDT;
    public $DataDDT;
    public $RiferimentoNumeroLinea;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}NumeroDDT') {
                $this->NumeroDDT = $child['value'];
            } elseif ($child['name'] === '{}DataDDT') {
                $this->DataDDT = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoNumeroLinea') {
                $this->RiferimentoNumeroLinea[] = $child['value'];
            }
        }
    }
}