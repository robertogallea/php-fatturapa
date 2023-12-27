<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto;


use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\Anagrafica;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\IdFiscaleIVA;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiAnagraficiVettore extends DatiAnagrafici
{
    use Traversable;

    /** @var string */
    protected $NumeroLicenzaGuida;

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
            } elseif ($child['name'] === '{}NumeroLicenzaGuida') {
                $this->NumeroLicenzaGuida = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->IdFiscaleIVA ? $data['IdFiscaleIVA'] = $this->IdFiscaleIVA : null;
        $this->CodiceFiscale ? $data['CodiceFiscale'] = $this->CodiceFiscale : null;
        $this->Anagrafica ? $data['Anagrafica'] = $this->Anagrafica : null;
        $this->NumeroLicenzaGuida ? $data['NumeroLicenzaGuida'] = $this->NumeroLicenzaGuida : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getNumeroLicenzaGuida()
    {
        return $this->NumeroLicenzaGuida;
    }

    /**
     * @param string $NumeroLicenzaGuida
     * @return DatiAnagraficiVettore
     */
    public function setNumeroLicenzaGuida($NumeroLicenzaGuida)
    {
        if (strlen($NumeroLicenzaGuida) > 20) {
            throw new InvalidValueException("NumeroLicenzaGuida must be a string of maximum 20 characters");
        }
        $this->NumeroLicenzaGuida = $NumeroLicenzaGuida;
        return $this;
    }


}
