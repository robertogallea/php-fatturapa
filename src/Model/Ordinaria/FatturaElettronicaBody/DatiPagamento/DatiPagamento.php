<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:39
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiPagamento;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiPagamento
{
    use Traversable;

    public $CondizioniPagamento;
    public $DettaglioPagamento;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}CondizioniPagamento') {
                $this->CondizioniPagamento= $child['value'];
            } elseif ($child['value'] instanceof DettaglioPagamento) {
                $this->DettaglioPagamento[] = $child['value'];
            }
        }
    }
}