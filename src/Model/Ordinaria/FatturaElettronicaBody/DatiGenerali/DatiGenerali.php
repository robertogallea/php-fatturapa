<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:38
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiGenerali
{
    use Traversable;

    public $DatiGeneraliDocumento;
    public $DatiOrdineAcquisto;
    public $DatiContratto;
    public $DatiConvenzione;
    public $DatiRicezione;
    public $DatiFattureCollegate;
    public $DatiSAL;
    public $DatiDDT;
    public $DatiTrasporto;
    public $FatturaPrincipale;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof DatiGeneraliDocumento) {
                $this->DatiGeneraliDocumento = $child['value'];
            } elseif ($child['value'] instanceof DatiOrdineAcquisto) {
                $this->DatiOrdineAcquisto[] = $child['value'];
            } elseif ($child['value'] instanceof DatiContratto) {
                $this->DatiContratto[] = $child['value'];
            } elseif ($child['value'] instanceof DatiConvenzione) {
                $this->DatiConvenzione[] = $child['value'];
            } elseif ($child['value'] instanceof DatiRicezione) {
                $this->DatiRicezione[] = $child['value'];
            } elseif ($child['value'] instanceof DatiFattureCollegate) {
                $this->DatiFattureCollegate[] = $child['value'];
            } elseif ($child['value'] instanceof DatiSAL) {
                $this->DatiSAL[] = $child['value'];
            } elseif ($child['value'] instanceof DatiDDT) {
                $this->DatiDDT[] = $child['value'];
            } elseif ($child['value'] instanceof DatiTrasporto) {
                $this->DatiTrasporto = $child['value'];
            } elseif ($child['value'] instanceof FatturaPrincipale) {
                $this->FatturaPrincipale = $child['value'];
            }
        }
    }
}