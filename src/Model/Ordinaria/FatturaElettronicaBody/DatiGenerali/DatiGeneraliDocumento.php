<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:38
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\ScontoMaggiorazione;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiGeneraliDocumento
{
    use Traversable;

    public $TipoDocumento;
    public $Divisa;
    public $Data;
    public $Numero;
    public $DatiRitenuta;
    public $DatiBollo;
    public $DatiCassaPrevidenziale;
    public $ScontoMaggiorazione;
    public $ImportoTotaleDocumento;
    public $Arrotondamento;
    public $Causale;
    public $Art73;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}TipoDocumento') {
                $this->TipoDocumento = $child['value'];
            } elseif ($child['name'] === '{}Divisa') {
                $this->Divisa = $child['value'];
            } elseif ($child['name'] === '{}Data') {
                $this->Data = $child['value'];
            } elseif ($child['name'] === '{}Numero') {
                $this->Numero = $child['value'];
            } elseif ($child['value'] instanceof DatiRitenuta) {
                $this->DatiRitenuta = $child['value'];
            } elseif ($child['value'] instanceof DatiBollo) {
                $this->DatiBollo= $child['value'];
            } elseif ($child['value'] instanceof DatiCassaPrevidenziale) {
                $this->DatiCassaPrevidenziale[] = $child['value'];
            } elseif ($child['value'] instanceof ScontoMaggiorazione) {
                $this->ScontoMaggiorazione[] = $child['value'];
            }  elseif ($child['name'] === '{}ImportoTotaleDocumento') {
                $this->ImportoTotaleDocumento = $child['value'];
            } elseif ($child['name'] === '{}Arrotondamento') {
                $this->Arrotondamento = $child['value'];
            } elseif ($child['name'] === '{}Causale') {
                $this->Causale[] = $child['value'];
            } elseif ($child['name'] === '{}Art73') {
                $this->Art73 = $child['value'];
            }
        }
    }
}