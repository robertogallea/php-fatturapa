<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:31
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class IscrizioneREA implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $Ufficio;

    /** @var string */
    protected $NumeroREA;

    /** @var string */
    protected $CapitaleSociale;

    /** @var string */
    protected $SocioUnico;

    /** @var string */
    protected $StatoLiquidazione;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Ufficio') {
                $this->Ufficio = $child['value'];
            } elseif ($child['name'] === '{}NumeroREA') {
                $this->NumeroREA = $child['value'];
            } elseif ($child['name'] === '{}CapitaleSociale') {
                $this->CapitaleSociale = $child['value'];
            } elseif ($child['name'] === '{}SocioUnico') {
                $this->SocioUnico= $child['value'];
            } elseif ($child['name'] === '{}StatoLiquidazione') {
                $this->StatoLiquidazione = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->Ufficio ? $data['Ufficio'] = $this->Ufficio : null;
        $this->NumeroREA ? $data['NumeroREA'] = $this->NumeroREA : null;
        $this->CapitaleSociale ? $data['CapitaleSociale'] = $this->CapitaleSociale : null;
        $this->SocioUnico ? $data['SocioUnico'] = $this->SocioUnico : null;
        $this->StatoLiquidazione ? $data['StatoLiquidazione'] = $this->StatoLiquidazione : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getUfficio()
    {
        return $this->Ufficio;
    }

    /**
     * @param string $Ufficio
     * @return IscrizioneREA
     */
    public function setUfficio($Ufficio)
    {
        if (strlen($Ufficio) !== 2) {
            throw new InvalidValueException("Ufficio must be a string of 2 characters");
        }
        $this->Ufficio = $Ufficio;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroREA()
    {
        return $this->NumeroREA;
    }

    /**
     * @param string $NumeroREA
     * @return IscrizioneREA
     */
    public function setNumeroREA($NumeroREA)
    {
        if (strlen($NumeroREA) > 20) {
            throw new InvalidValueException("NumeroREA must be a string of maximum 20 characters");
        }
        $this->NumeroREA = $NumeroREA;
        return $this;
    }

    /**
     * @return string
     */
    public function getCapitaleSociale()
    {
        return $this->CapitaleSociale;
    }

    /**
     * @param string $CapitaleSociale
     * @return IscrizioneREA
     */
    public function setCapitaleSociale($CapitaleSociale)
    {
        if ((strlen($CapitaleSociale) < 4) || (strlen($CapitaleSociale) > 15)) {
            throw new InvalidValueException("CapitaleSociale must be a string between 4 and 15 characters");
        }
        $this->CapitaleSociale = $CapitaleSociale;
        return $this;
    }

    /**
     * @return string
     */
    public function getSocioUnico()
    {
        return $this->SocioUnico;
    }

    /**
     * @param string $SocioUnico
     * @return IscrizioneREA
     */
    public function setSocioUnico($SocioUnico)
    {
        if (strlen($SocioUnico) !== 2) {
            throw new InvalidValueException("SocioUnico must be a string of 2 characters");
        }
        $this->SocioUnico = $SocioUnico;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatoLiquidazione()
    {
        return $this->StatoLiquidazione;
    }

    /**
     * @param string $StatoLiquidazione
     * @return IscrizioneREA
     */
    public function setStatoLiquidazione($StatoLiquidazione)
    {
        if (strlen($StatoLiquidazione) !== 2) {
            throw new InvalidValueException("StatoLiquidazione must be a string of 2 characters");
        }
        $this->StatoLiquidazione = $StatoLiquidazione;
        return $this;
    }


}