<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:31
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CessionarioCommittente;


use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\Sede\Sede;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore\StabileOrganizzazione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\RappresentanteFiscale\RappresentanteFiscale;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class CessionarioCommittente
{
    use Traversable;

    public $DatiAnagrafici;
    public $RappresentanteFiscale;
    public $StabileOrganizzazione;
    public $Sede;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof DatiAnagrafici) {
                $this->DatiAnagrafici = $child['value'];
            } elseif ($child['value'] instanceof Sede) {
                $this->Sede = $child['value'];
            } elseif ($child['value'] instanceof RappresentanteFiscale) {
                $this->RappresentanteFiscale = $child['value'];
            } elseif ($child['value'] instanceof StabileOrganizzazione) {
                $this->StabileOrganizzazione = $child['value'];
            }
        }
    }
}