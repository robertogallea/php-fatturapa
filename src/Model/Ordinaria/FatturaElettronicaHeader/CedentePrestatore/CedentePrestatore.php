<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:30
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;


use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\Sede\Sede;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class CedentePrestatore
{
    use Traversable;

    public $Contatti;
    public $DatiAnagrafici;
    public $IscrizioneRea;
    public $Sede;
    public $StabileOrganizzazione;
    public $RiferimentoAmministrazione;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof Contatti) {
                $this->Contatti = $child['value'];
            } elseif ($child['value'] instanceof DatiAnagrafici) {
                $this->DatiAnagrafici = $child['value'];
            } elseif ($child['value'] instanceof IscrizioneRea) {
                $this->IscrizioneRea = $child['value'];
            } elseif ($child['value'] instanceof Sede) {
                $this->Sede = $child['value'];
            } elseif ($child['value'] instanceof StabileOrganizzazione) {
                $this->StabileOrganizzazione = $child['value'];
            } elseif ($child['value'] instanceof RiferimentoOrganizzazione) {
                $this->RiferimentoAmministrazione = $child['value'];
            }
        }
    }
}