<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 09:28
 */

namespace Robertogallea\FatturaPA\Model\Common\Sede;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class Sede
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

        foreach($children as $child) {
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