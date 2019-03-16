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

class DatiSAL
{
    use Traversable;

    public $RiferimentoFase;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}RiferimentoFase') {
                $this->RiferimentoFase = $child['value'];
            }
        }
    }
}