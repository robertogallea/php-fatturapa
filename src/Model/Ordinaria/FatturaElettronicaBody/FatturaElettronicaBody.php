<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:35
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;


use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\Allegati\Allegati;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiBeniServizi\DatiBeniServizi;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiContratto;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiConvenzione;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiDDT;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiFattureCollegate;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiGenerali;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiOrdineAcquisto;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiRicezione;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiSAL;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\DatiTrasporto;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali\FatturaPrincipale;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiPagamento\DatiPagamento;
use Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiVeicoli\DatiVeicoli;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class FatturaElettronicaBody
{
    use Traversable;


    public $DatiGenerali;
    public $DatiBeniServizi;
    public $DatiVeicoli;
    public $DatiPagamento;
    public $Allegati;



    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof DatiGenerali) {
                $this->DatiGenerali = $child['value'];
            } elseif ($child['value'] instanceof DatiBeniServizi) {
                $this->DatiBeniServizi = $child['value'];
            } elseif ($child['value'] instanceof DatiVeicoli) {
                $this->DatiVeicoli = $child['value'];
            } elseif ($child['value'] instanceof DatiPagamento) {
                $this->DatiPagamento[] = $child['value'];
            } elseif ($child['value'] instanceof Allegati) {
                $this->Allegati[] = $child['value'];
            }
        }
    }
}