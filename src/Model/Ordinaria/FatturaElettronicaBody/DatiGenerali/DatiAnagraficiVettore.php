<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\Anagrafica;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\IdFiscaleIVA;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiAnagraficiVettore extends DatiAnagrafici
{
    use Traversable;

    public $NumeroLicenzaGuida;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {

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
            } elseif ($child['name'] === '{}NumeroLicenzaGuida') {
                $this->NumeroLicenzaGuida = $child['value'];
            }
        }
    }
}