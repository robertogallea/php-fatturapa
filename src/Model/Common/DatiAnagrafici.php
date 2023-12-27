<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 09:21
 */

namespace Robertogallea\FatturaPA\Model\Common;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\Anagrafica;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\IdFiscaleIVA;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiAnagrafici implements XmlSerializable
{
    use Traversable;

    /** @var IdFiscaleIVA */
    protected $IdFiscaleIVA;

    /** @var string */
    protected $CodiceFiscale;

    /** @var Anagrafica */
    protected $Anagrafica;

    /** @var string */
    protected $AlboProfessionale;

    /** @var string */
    protected $ProvinciaAlbo;

    /** @var string */
    protected $NumeroIscrizioneAlbo;

    /** @var string */
    protected $DataIscrizioneAlbo;

    /** @var string */
    protected $RegimeFiscale;

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

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->IdFiscaleIVA ? $data['IdFiscaleIVA'] = $this->IdFiscaleIVA : null;
        $this->CodiceFiscale ? $data['CodiceFiscale'] = $this->CodiceFiscale : null;
        $this->Anagrafica ? $data['Anagrafica'] = $this->Anagrafica : null;
        $this->AlboProfessionale ? $data['AlboProfessionale'] = $this->AlboProfessionale : null;
        $this->ProvinciaAlbo ? $data['ProvinciaAlbo'] = $this->ProvinciaAlbo : null;
        $this->NumeroIscrizioneAlbo ? $data['NumeroIscrizioneAlbo'] = $this->NumeroIscrizioneAlbo : null;
        $this->DataIscrizioneAlbo ? $data['DataIscrizioneAlbo'] = $this->DataIscrizioneAlbo : null;
        $this->RegimeFiscale ? $data['RegimeFiscale'] = $this->RegimeFiscale : null;
        $writer->write($data);
    }

    /**
     * @return IdFiscaleIVA
     */
    public function getIdFiscaleIVA()
    {
        return $this->IdFiscaleIVA;
    }

    /**
     * @param IdFiscaleIVA $IdFiscaleIVA
     * @return DatiAnagrafici
     */
    public function setIdFiscaleIVA($IdFiscaleIVA)
    {
        $this->IdFiscaleIVA = $IdFiscaleIVA;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodiceFiscale()
    {
        return $this->CodiceFiscale;
    }

    /**
     * @param string $CodiceFiscale
     * @return DatiAnagrafici
     */
    public function setCodiceFiscale($CodiceFiscale)
    {
        if ((strlen($CodiceFiscale) < 11) && (strlen($CodiceFiscale) > 16)) {
            throw new InvalidValueException("CodiceFiscale must be a string between 11 and 16 characters");
        }
        $this->CodiceFiscale = $CodiceFiscale;
        return $this;
    }

    /**
     * @return Anagrafica
     */
    public function getAnagrafica()
    {
        return $this->Anagrafica;
    }

    /**
     * @param Anagrafica $Anagrafica
     * @return DatiAnagrafici
     */
    public function setAnagrafica($Anagrafica)
    {
        $this->Anagrafica = $Anagrafica;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlboProfessionale()
    {
        return $this->AlboProfessionale;
    }

    /**
     * @param string $AlboProfessionale
     * @return DatiAnagrafici
     */
    public function setAlboProfessionale($AlboProfessionale)
    {
        if (strlen($AlboProfessionale) > 60) {
            throw new InvalidValueException("AlboProfessionale must be a stringof maximum 60 characters");
        }
        $this->AlboProfessionale = $AlboProfessionale;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvinciaAlbo()
    {
        return $this->ProvinciaAlbo;
    }

    /**
     * @param string $ProvinciaAlbo
     * @return DatiAnagrafici
     */
    public function setProvinciaAlbo($ProvinciaAlbo)
    {
        if (strlen($ProvinciaAlbo) !== 2) {
            throw new InvalidValueException("ProvinciaAlbo must be a string of 2 characters");
        }
        $this->ProvinciaAlbo = $ProvinciaAlbo;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroIscrizioneAlbo()
    {
        return $this->NumeroIscrizioneAlbo;
    }

    /**
     * @param string $NumeroIscrizioneAlbo
     * @return DatiAnagrafici
     */
    public function setNumeroIscrizioneAlbo($NumeroIscrizioneAlbo)
    {
        if (strlen($NumeroIscrizioneAlbo) > 60) {
            throw new InvalidValueException("NumeroIscrizioneAlbo must be a string of maximum 60 characters");
        }
        $this->NumeroIscrizioneAlbo = $NumeroIscrizioneAlbo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataIscrizioneAlbo()
    {
        return $this->DataIscrizioneAlbo;
    }

    /**
     * @param string $DataIscrizioneAlbo
     * @return DatiAnagrafici
     */
    public function setDataIscrizioneAlbo($DataIscrizioneAlbo)
    {
        if (strlen($DataIscrizioneAlbo) !== 10) {
            throw new InvalidValueException("DataIscrizioneAlbo must be a date string in the format YYYY-MM-DD");
        }
        $this->DataIscrizioneAlbo = $DataIscrizioneAlbo;
        return $this;
    }

    /**
     * @return string
     */
    public function getRegimeFiscale()
    {
        return $this->RegimeFiscale;
    }

    /**
     * @param string $RegimeFiscale
     * @return DatiAnagrafici
     */
    public function setRegimeFiscale($RegimeFiscale)
    {
        if (strlen($RegimeFiscale) !== 4) {
            throw new InvalidValueException("RegimeFiscale must be a string of 4 characters");
        }
        $this->RegimeFiscale = $RegimeFiscale;
        return $this;
    }


}
