<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:35
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria;



use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CessionarioCommittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\RappresentanteFiscale;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\TerzoIntermediarioOSoggettoEmittente;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class FatturaElettronicaHeader implements XmlSerializable
{
    use Traversable;

    /** @var CedentePrestatore */
    protected $CedentePrestatore;

    /** @var CessionarioCommittente */
    protected $CessionarioCommittente;

    /** @var DatiTrasmissione */
    protected $DatiTrasmissione;

    /** @var RappresentanteFiscale */
    protected $RappresentateFiscale;

    /** @var TerzoIntermediarioOSoggettoEmittente */
    protected $TerzoIntermediarioOSoggettoEmittente;

    /** @var string */
    protected $SoggettoEmittente;

    private function traverse($reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof CedentePrestatore) {
                $this->CedentePrestatore = $child['value'];
            } elseif ($child['value'] instanceof CessionarioCommittente) {
                $this->CessionarioCommittente = $child['value'];
            } elseif ($child['value'] instanceof DatiTrasmissione) {
                $this->DatiTrasmissione = $child['value'];
            } elseif ($child['value'] instanceof RappresentanteFiscale) {
                $this->CessionarioCommittente = $child['value'];
            } elseif ($child['value'] instanceof TerzoIntermediarioOSoggettoEmittente) {
                $this->TerzoIntermediarioOSoggettoEmittente = $child['value'];
            } elseif ($child['name'] === '{}SoggettoEmittente') {
                $this->SoggettoEmittente = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->DatiTrasmissione ? $data['DatiTrasmissione'] = $this->DatiTrasmissione : null;
        $this->CedentePrestatore ? $data['CedentePrestatore'] = $this->CedentePrestatore : null;
        $this->RappresentateFiscale ? $data['RappresentanteFiscale'] = $this->RappresentateFiscale : null;
        $this->CessionarioCommittente ? $data['CessionarioCommittente'] = $this->CessionarioCommittente : null;
        $this->TerzoIntermediarioOSoggettoEmittente ? $data['TerzoIntermediarioOSoggettoEmittente'] = $this->TerzoIntermediarioOSoggettoEmittente : null;
        $this->SoggettoEmittente ? $data['SoggettoEmittente'] = $this->SoggettoEmittente : null;
        $writer->write($data);
    }

    /**
     * @return CedentePrestatore
     */
    public function getCedentePrestatore()
    {
        return $this->CedentePrestatore;
    }

    /**
     * @param CedentePrestatore $CedentePrestatore
     * @return FatturaElettronicaHeader
     */
    public function setCedentePrestatore($CedentePrestatore)
    {
        $this->CedentePrestatore = $CedentePrestatore;
        return $this;
    }

    /**
     * @return CessionarioCommittente
     */
    public function getCessionarioCommittente()
    {
        return $this->CessionarioCommittente;
    }

    /**
     * @param CessionarioCommittente $CessionarioCommittente
     * @return FatturaElettronicaHeader
     */
    public function setCessionarioCommittente($CessionarioCommittente)
    {
        $this->CessionarioCommittente = $CessionarioCommittente;
        return $this;
    }

    /**
     * @return DatiTrasmissione
     */
    public function getDatiTrasmissione()
    {
        return $this->DatiTrasmissione;
    }

    /**
     * @param DatiTrasmissione $DatiTrasmissione
     * @return FatturaElettronicaHeader
     */
    public function setDatiTrasmissione($DatiTrasmissione)
    {
        $this->DatiTrasmissione = $DatiTrasmissione;
        return $this;
    }

    /**
     * @return RappresentanteFiscale
     */
    public function getRappresentateFiscale()
    {
        return $this->RappresentateFiscale;
    }

    /**
     * @param RappresentanteFiscale $RappresentateFiscale
     * @return FatturaElettronicaHeader
     */
    public function setRappresentateFiscale($RappresentateFiscale)
    {
        $this->RappresentateFiscale = $RappresentateFiscale;
        return $this;
    }

    /**
     * @return TerzoIntermediarioOSoggettoEmittente
     */
    public function getTerzoIntermediarioOSoggettoEmittente()
    {
        return $this->TerzoIntermediarioOSoggettoEmittente;
    }

    /**
     * @param TerzoIntermediarioOSoggettoEmittente $TerzoIntermediarioOSoggettoEmittente
     * @return FatturaElettronicaHeader
     */
    public function setTerzoIntermediarioOSoggettoEmittente($TerzoIntermediarioOSoggettoEmittente)
    {
        $this->TerzoIntermediarioOSoggettoEmittente = $TerzoIntermediarioOSoggettoEmittente;
        return $this;
    }

    /**
     * @return string
     */
    public function getSoggettoEmittente()
    {
        return $this->SoggettoEmittente;
    }

    /**
     * @param string $SoggettoEmittente
     */
    public function setSoggettoEmittente($SoggettoEmittente)
    {
        if (strlen($SoggettoEmittente) !== 2) {
            throw new InvalidValueException('SoggettoEmmitente must be a string of two characters');
        }
        $this->SoggettoEmittente = $SoggettoEmittente;
    }




}