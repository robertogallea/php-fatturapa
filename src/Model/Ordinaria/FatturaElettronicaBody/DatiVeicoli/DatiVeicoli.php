<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:40
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiVeicoli;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiVeicoli
{
    use Traversable;

    public $Data;
    public $TotalePercorso;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Data') {
                $this->Data = $child['value'];
            } elseif ($child['name'] === '{}TotalePercorso') {
                $this->TotalePercorso = $child['value'];
            }
        }
    }
}