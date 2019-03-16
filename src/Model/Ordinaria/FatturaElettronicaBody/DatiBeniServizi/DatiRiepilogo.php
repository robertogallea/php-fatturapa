<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiBeniServizi;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiRiepilogo
{
    use Traversable;

    public $AliquotaIVA;
    public $Natura;
    public $SpeseAccessorie;
    public $Arrotondamento;
    public $ImponibileImporto;
    public $Imposta;
    public $EsigibilitaIVA;
    public $RiferimentoNormativo;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}AliquotaIVA') {
                $this->AliquotaIVA = $child['value'];
            } elseif ($child['name'] === '{}Natura') {
                $this->Natura = $child['value'];
            } elseif ($child['name'] === '{}SpeseAccessorie') {
                $this->SpeseAccessorie = $child['value'];
            } elseif ($child['name'] === '{}Arrotondamento') {
                $this->Arrotondamento = $child['value'];
            } elseif ($child['name'] === '{}ImponibileImporto') {
                $this->ImponibileImporto = $child['value'];
            } elseif ($child['name'] === '{}Imposta') {
                $this->Imposta = $child['value'];
            } elseif ($child['name'] === '{}EsigibilitaIVA') {
                $this->EsigibilitaIVA = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoNormativo') {
                $this->RiferimentoNormativo = $child['value'];
            }
        }
    }
}