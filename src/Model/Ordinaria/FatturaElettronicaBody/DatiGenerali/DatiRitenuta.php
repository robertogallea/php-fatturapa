<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:38
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiRitenuta
{
    use Traversable;

    public $TipoRitenuta;
    public $ImportoRitenuta;
    public $AliquotaRitenuta;
    public $CausalePagamento;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {

            if ($child['name'] === '{}TipoRitenuta') {
                $this->TipoRitenuta = $child['value'];
            } elseif ($child['name'] === '{}ImportoRitenuta') {
                $this->ImportoRitenuta = $child['value'];
            } elseif ($child['name'] === '{}AliquotaRitenuta') {
                $this->AliquotaRitenuta = $child['value'];
            } elseif ($child['name'] === '{}CausalePagamento') {
                $this->CausalePagamento = $child['value'];
            }
        }
    }
}