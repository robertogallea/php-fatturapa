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

class DatiTrasporto
{
    use Traversable;

    public $DatiAnagraificiVettore;
    public $MezzoTraporto;
    public $CausaleTrasporto;
    public $NumeroColli;
    public $Descrizione;
    public $UnitaMisuraPeso;
    public $PesoLordo;
    public $PesoNetto;
    public $DataOraRitiro;
    public $DataInizioTraporto;
    public $TipoResa;
    public $IndirizzoResa;
    public $DataOraConsegna;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['value'] instanceof DatiAnagraficiVettore) {
                $this->DatiAnagraificiVettore = $child['value'];
            } elseif ($child['name'] === '{}MezzoTrasporto') {
                $this->MezzoTraporto = $child['value'];
            } elseif ($child['name'] === '{}CausaleTrasporto') {
                $this->CausaleTrasporto = $child['value'];
            } elseif ($child['name'] === '{}NumeroColli') {
                $this->NumeroColli = $child['value'];
            } elseif ($child['name'] === '{}Descrizione') {
                $this->Descrizione = $child['value'];
            } elseif ($child['name'] === '{}UnitaMisuraPeso') {
                $this->UnitaMisuraPeso = $child['value'];
            } elseif ($child['name'] === '{}PesoLordo') {
                $this->PesoLordo = $child['value'];
            } elseif ($child['name'] === '{}PesoNetto') {
                $this->PesoNetto = $child['value'];
            } elseif ($child['name'] === '{}DataOraRitiro') {
                $this->DataOraRitiro = $child['value'];
            } elseif ($child['name'] === '{}DataInizioTraporto') {
                $this->DataInizioTraporto = $child['value'];
            } elseif ($child['name'] === '{}TipoResa') {
                $this->TipoResa = $child['value'];
            } elseif ($child['value'] instanceof IndirizzoResa) {
                $this->IndirizzoResa = $child['value'];
            } elseif ($child['name'] === '{}DataOraConsegna') {
                $this->DataOraConsegna = $child['value'];
            }
        }
    }
}