<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:39
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class IndirizzoResa
{
    use Traversable;

    public $Indirizzo;
    public $NumeroCivico;
    public $CAP;
    public $Comune;
    public $Provincia;
    public $Nazione;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}Indirizzo') {
                $this->Indirizzo = $child['value'];
            } elseif ($child['name'] === '{}NumeroCivico') {
                $this->NumeroCivico = $child['value'];
            } elseif ($child['name'] === '{}CAP') {
                $this->CAP = $child['value'];
            } elseif ($child['name'] === '{}Comune') {
                $this->Comune = $child['value'];
            } elseif ($child['name'] === '{}Provincia') {
                $this->Provincia = $child['value'];
            } elseif ($child['name'] === '{}Nazione') {
                $this->Nazione = $child['value'];
            }
        }
    }
}