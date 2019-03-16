<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 09:23
 */

namespace Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class Anagrafica
{
    use Traversable;

    public $Denominazione;
    public $Nome;
    public $Cognome;
    public $Titolo;
    public $CodEORI;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Denominazione') {
                $this->Denominazione = $child['value'];
            } elseif ($child['name'] === '{}Nome') {
                $this->Nome = $child['value'];
            } elseif ($child['name'] === '{}Cognome') {
                $this->Cognome = $child['value'];
            } elseif ($child['name'] === '{}Titolo') {
                $this->Titolo = $child['value'];
            } elseif ($child['name'] === '{}CodEORI') {
                $this->CodEORI = $child['value'];
            }
        }
    }
}