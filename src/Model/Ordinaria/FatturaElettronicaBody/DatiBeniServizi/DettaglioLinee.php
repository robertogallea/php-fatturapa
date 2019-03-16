<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiBeniServizi;


use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\ScontoMaggiorazione;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DettaglioLinee
{
    use Traversable;

    public $NumeroLinea;
    public $TipoCessionePrestazione;
    public $CodiceArticolo;
    public $Descrizione;
    public $Quantita;
    public $UnitaMisura;
    public $DataInizioPeriodo;
    public $DataFinePeriodo;
    public $PrezzoUnitario;
    public $ScontoMaggiorazione;
    public $PrezzoTotale;
    public $AliquotaIVA;
    public $Ritenuta;
    public $Natura;
    public $RiferimentoAmministrazione;
    public $AltriDatiGestionali;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}NumeroLinea') {
                $this->NumeroLinea = $child['value'];
            } elseif ($child['name'] === '{}TipoCessionePrestanzione') {
                $this->TipoCessionePrestazione = $child['value'];
            } elseif ($child['value'] instanceof CodiceArticolo) {
                $this->CodiceArticolo[] = $child['value'];
            } elseif ($child['name'] === '{}Descrizione') {
                $this->Descrizione = $child['value'];
            } elseif ($child['name'] === '{}Quantita') {
                $this->Quantita = $child['value'];
            } elseif ($child['name'] === '{}UnitaMisura') {
                $this->UnitaMisura = $child['value'];
            } elseif ($child['name'] === '{}DataInizioPeriodo') {
                $this->DataFinePeriodo = $child['value'];
            } elseif ($child['name'] === '{}DataFinePeriodo') {
                $this->DataFinePeriodo = $child['value'];
            } elseif ($child['name'] === '{}PrezzoUnitario') {
                $this->PrezzoUnitario = $child['value'];
            } elseif ($child['value'] instanceof ScontoMaggiorazione) {
                $this->ScontoMaggiorazione[] = $child['value'];
            } elseif ($child['name'] === '{}PrezzoTotale') {
                $this->PrezzoTotale = $child['value'];
            } elseif ($child['name'] === '{}AliquotaIVA') {
                $this->AliquotaIVA = $child['value'];
            } elseif ($child['name'] === '{}Ritenuta') {
                $this->Ritenuta = $child['value'];
            } elseif ($child['name'] === '{}Natura') {
                $this->Natura = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoAmministrazione') {
                $this->RiferimentoAmministrazione = $child['value'];
            } elseif ($child['value'] instanceof AltriDatiGestionali) {
                $this->AltriDatiGestionali[] = $child['value'];
            }
        }
    }
}