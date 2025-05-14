<?php

/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:35
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class AltriDatiGestionali implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $TipoDato;

    /** @var string */
    protected $RiferimentoTesto;

    /** @var string */
    protected $RiferimentoNumero;

    /** @var string */
    protected $RiferimentoData;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}TipoDato') {
                $this->TipoDato = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoTesto') {
                $this->RiferimentoTesto = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoNumero') {
                $this->RiferimentoNumero = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoData') {
                $this->RiferimentoData = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->TipoDato ? $data['TipoDato'] = $this->TipoDato : null;
        $this->RiferimentoTesto ? $data['RiferimentoTesto'] = $this->RiferimentoTesto : null;
        $this->RiferimentoNumero ? $data['RiferimentoNumero'] = $this->RiferimentoNumero : null;
        $this->RiferimentoData ? $data['RiferimentoData'] = $this->RiferimentoData : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getTipoDato()
    {
        return $this->TipoDato;
    }

    /**
     * @param string $TipoDato
     * @return AltriDatiGestionali
     */
    public function setTipoDato($TipoDato)
    {
        if (strlen($TipoDato) > 10) {
            throw new InvalidValueException("TipoDato must be a string of maximum 10 characters");
        }
        $this->TipoDato = $TipoDato;
        return $this;
    }

    /**
     * @return string
     */
    public function getRiferimentoTesto()
    {
        return $this->RiferimentoTesto;
    }

    /**
     * @param string $RiferimentoTesto
     * @return AltriDatiGestionali
     */
    public function setRiferimentoTesto($RiferimentoTesto)
    {
        if (strlen($RiferimentoTesto) > 60) {
            throw new InvalidValueException("RiferimentoTesto must be a string of maximum 60 characters");
        }
        $this->RiferimentoTesto = $RiferimentoTesto;
        return $this;
    }

    /**
     * @return string
     */
    public function getRiferimentoNumero()
    {
        return $this->RiferimentoNumero;
    }

    /**
     * @param string $RiferimentoNumero
     * @return AltriDatiGestionali
     */
    public function setRiferimentoNumero($RiferimentoNumero)
    {
        if ((strlen($RiferimentoNumero) < 4) || (strlen($RiferimentoNumero) > 21)) {
            throw new InvalidValueException("RiferimentoNumero must be a string between 4 and 21 characters");
        }
        $this->RiferimentoNumero = $RiferimentoNumero;
        return $this;
    }

    /**
     * @return string
     */
    public function getRiferimentoData()
    {
        return $this->RiferimentoData;
    }

    /**
     * @param string $RiferimentoData
     * @return AltriDatiGestionali
     */
    public function setRiferimentoData($RiferimentoData)
    {
        if (strlen($RiferimentoData) !== 10) {
            throw new InvalidValueException("RiferimentoData must be a date string in the format YYYY-MM-DD");
        }
        $this->RiferimentoData = $RiferimentoData;
        return $this;
    }
}
