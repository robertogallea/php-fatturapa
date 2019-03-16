<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:33
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class IdTrasmittente
{
    use Traversable;

    public $IdPaese;
    public $IdCodice;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}IdPaese') {
                $this->IdPaese = $child['value'];
            } elseif ($child['name'] === '{}IdCodice') {
                $this->IdCodice = $child['value'];
            }
        }
    }
}