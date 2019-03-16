<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:31
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class IscrizioneRea
{
    use Traversable;

    public $Ufficio;
    public $NumeroREA;
    public $CapitaleSociale;
    public $SocioUnico;
    public $StatoLiquidazione;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Ufficio') {
                $this->Ufficio = $child['value'];
            } elseif ($child['name'] === '{}NumeroREA') {
                $this->NumeroREA = $child['value'];
            } elseif ($child['name'] === '{}CapitaleSociale') {
                $this->CapitaleSociale = $child['value'];
            } elseif ($child['name'] === '{}SocioUnico') {
                $this->SocioUnico= $child['value'];
            } elseif ($child['name'] === '{}StatoLiquidazione') {
                $this->StatoLiquidazione = $child['value'];
            }
        }
    }
}