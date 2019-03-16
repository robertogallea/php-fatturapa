<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 09:21
 */

namespace Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiAnagrafici
{
    use Traversable;

    public $IdFiscaleIVA;
    public $CodiceFiscale;
    public $Anagrafica;
    public $AlboProfessionale;
    public $ProvinciaAlbo;
    public $NumeroIscrizioneAlbo;
    public $DataIscrizioneAlbo;
    public $RegimeFiscale;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof IdFiscaleIVA) {
                $this->IdFiscaleIVA = $child['value'];
            } elseif ($child['value'] instanceof Anagrafica) {
                $this->Anagrafica = $child['value'];
            } elseif ($child['name'] === '{}CodiceFiscale') {
                $this->CodiceFiscale = $child['value'];
            } elseif ($child['name'] === '{}AlboProfessionale') {
                $this->AlboProfessionale = $child['value'];
            } elseif ($child['name'] === '{}ProvinciaAlbo') {
                $this->ProvinciaAlbo = $child['value'];
            } elseif ($child['name'] === '{}NumeroIscrizioneAlbo') {
                $this->NumeroIscrizioneAlbo = $child['value'];
            } elseif ($child['name'] === '{}DataIscrizioneAlbo') {
                $this->DataIscrizioneAlbo= $child['value'];
            } elseif ($child['name'] === '{}RegimeFiscale') {
                $this->RegimeFiscale = $child['value'];
            }
        }
    }
}