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

class DatiFattureCollegate
{
    use Traversable;

    public $RiferimentoNumeroLinea;
    public $IdDocumento;
    public $Data;
    public $NumItem;
    public $CodiceCommessaConvenzione;
    public $CodiceCUP;
    public $CodiceCIG;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}RiferimentoNumeroLinea') {
                $this->RiferimentoNumeroLinea[] = $child['value'];
            } elseif ($child['name'] === '{}IdDocumento') {
                $this->IdDocumento = $child['value'];
            } elseif ($child['name'] === '{}Data') {
                $this->Data = $child['value'];
            } elseif ($child['name'] === '{}NumItem') {
                $this->NumItem = $child['value'];
            } elseif ($child['name'] === '{}CodiceCommessaConvenzione') {
                $this->CodiceCommessaConvenzione = $child['value'];
            } elseif ($child['name'] === '{}CodiceCUP') {
                $this->CodiceCUP = $child['value'];
            } elseif ($child['name'] === '{}CodiceCIG') {
                $this->CodiceCIG = $child['value'];
            }
        }
    }
}