<?php

/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:39
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto\DatiAnagraficiVettore;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto\IndirizzoResa;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiTrasporto implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $DatiAnagraificiVettore;

    /** @var string */
    protected $MezzoTraporto;

    /** @var string */
    protected $CausaleTrasporto;

    /** @var string */
    protected $NumeroColli;

    /** @var string */
    protected $Descrizione;

    /** @var string */
    protected $UnitaMisuraPeso;

    /** @var string */
    protected $PesoLordo;

    /** @var string */
    protected $PesoNetto;

    /** @var string */
    protected $DataOraRitiro;

    /** @var string */
    protected $DataInizioTraporto;

    /** @var string */
    protected $TipoResa;

    /** @var string */
    protected $IndirizzoResa;

    /** @var string */
    protected $DataOraConsegna;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        if (is_null($children)) {
            return;
        }

        foreach ($children as $child) {
            if ($child['value'] instanceof DatiAnagraficiVettore) {
                $this->DatiAnagraificiVettore = $child['value'];
            } elseif ($child['name'] === '{}MezzoTrasporto') {
                $this->MezzoTraporto = $child['value'];
            } elseif ($child['name'] === '{}CausaleTrasporto') {
                $this->CausaleTrasporto = $child['value'];
            } elseif ($child['name'] === '{}NumeroColli') {
                $this->NumeroColli = $child['value'];
            } elseif ($child['name'] === '{}Descrizione') {
                $this->Descrizione = $child['value'];
            } elseif ($child['name'] === '{}UnitaMisuraPeso') {
                $this->UnitaMisuraPeso = $child['value'];
            } elseif ($child['name'] === '{}PesoLordo') {
                $this->PesoLordo = $child['value'];
            } elseif ($child['name'] === '{}PesoNetto') {
                $this->PesoNetto = $child['value'];
            } elseif ($child['name'] === '{}DataOraRitiro') {
                $this->DataOraRitiro = $child['value'];
            } elseif ($child['name'] === '{}DataInizioTraporto') {
                $this->DataInizioTraporto = $child['value'];
            } elseif ($child['name'] === '{}TipoResa') {
                $this->TipoResa = $child['value'];
            } elseif ($child['value'] instanceof IndirizzoResa) {
                $this->IndirizzoResa = $child['value'];
            } elseif ($child['name'] === '{}DataOraConsegna') {
                $this->DataOraConsegna = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->DatiAnagraificiVettore ? $data['DatiAnagraificiVettore'] = $this->DatiAnagraificiVettore : null;
        $this->MezzoTraporto ? $data['MezzoTraporto'] = $this->MezzoTraporto : null;
        $this->CausaleTrasporto ? $data['CausaleTrasporto'] = $this->CausaleTrasporto : null;
        $this->NumeroColli ? $data['NumeroColli'] = $this->NumeroColli : null;
        $this->Descrizione ? $data['Descrizione'] = $this->Descrizione : null;
        $this->UnitaMisuraPeso ? $data['UnitaMisuraPeso'] = $this->UnitaMisuraPeso : null;
        $this->PesoLordo ? $data['PesoLordo'] = $this->PesoLordo : null;
        $this->PesoNetto ? $data['PesoNetto'] = $this->PesoNetto : null;
        $this->DataOraRitiro ? $data['DataOraRitiro'] = $this->DataOraRitiro : null;
        $this->DataInizioTraporto ? $data['DataInizioTraporto'] = $this->DataInizioTraporto : null;
        $this->TipoResa ? $data['TipoResa'] = $this->TipoResa : null;
        $this->IndirizzoResa ? $data['IndirizzoResa'] = $this->IndirizzoResa : null;
        $this->DataOraConsegna ? $data['DataOraConsegna'] = $this->DataOraConsegna : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getDatiAnagraificiVettore()
    {
        return $this->DatiAnagraificiVettore;
    }

    /**
     * @param string $DatiAnagraificiVettore
     * @return DatiTrasporto
     */
    public function setDatiAnagraificiVettore($DatiAnagraificiVettore)
    {
        $this->DatiAnagraificiVettore = $DatiAnagraificiVettore;
        return $this;
    }

    /**
     * @return string
     */
    public function getMezzoTraporto()
    {
        return $this->MezzoTraporto;
    }

    /**
     * @param string $MezzoTraporto
     * @return DatiTrasporto
     */
    public function setMezzoTraporto($MezzoTraporto)
    {
        if (strlen($MezzoTraporto) > 80) {
            throw new InvalidValueException("MezzoTrasporto must be a string of maximum 80 characters");
        }
        $this->MezzoTraporto = $MezzoTraporto;
        return $this;
    }

    /**
     * @return string
     */
    public function getCausaleTrasporto()
    {
        return $this->CausaleTrasporto;
    }

    /**
     * @param string $CausaleTrasporto
     * @return DatiTrasporto
     */
    public function setCausaleTrasporto($CausaleTrasporto)
    {
        if (strlen($CausaleTrasporto) > 100) {
            throw new InvalidValueException("CausaleTrasporto must be a string of maximum 100 characters");
        }
        $this->CausaleTrasporto = $CausaleTrasporto;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroColli()
    {
        return $this->NumeroColli;
    }

    /**
     * @param string $NumeroColli
     * @return DatiTrasporto
     */
    public function setNumeroColli($NumeroColli)
    {
        if (strlen($NumeroColli) > 4) {
            throw new InvalidValueException("NumeroColli must be a string of maximum 4 characters");
        }
        $this->NumeroColli = $NumeroColli;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescrizione()
    {
        return $this->Descrizione;
    }

    /**
     * @param string $Descrizione
     * @return DatiTrasporto
     */
    public function setDescrizione($Descrizione)
    {
        if (strlen($Descrizione) > 100) {
            throw new InvalidValueException("Descrizione must be a string of maximum 100 characters");
        }
        $this->Descrizione = $Descrizione;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnitaMisuraPeso()
    {
        return $this->UnitaMisuraPeso;
    }

    /**
     * @param string $UnitaMisuraPeso
     * @return DatiTrasporto
     */
    public function setUnitaMisuraPeso($UnitaMisuraPeso)
    {
        if (strlen($UnitaMisuraPeso) > 10) {
            throw new InvalidValueException("UnitaMisuraPeso must be a string of maximum 10 characters");
        }
        $this->UnitaMisuraPeso = $UnitaMisuraPeso;
        return $this;
    }

    /**
     * @return string
     */
    public function getPesoLordo()
    {
        return $this->PesoLordo;
    }

    /**
     * @param string $PesoLordo
     * @return DatiTrasporto
     */
    public function setPesoLordo($PesoLordo)
    {
        if ((strlen($PesoLordo) < 4) || (strlen($PesoLordo) > 7)) {
            throw new InvalidValueException("PesoLordo must be a string between 4 and 7 characters");
        }
        $this->PesoLordo = $PesoLordo;
        return $this;
    }

    /**
     * @return string
     */
    public function getPesoNetto()
    {
        return $this->PesoNetto;
    }

    /**
     * @param string $PesoNetto
     * @return DatiTrasporto
     */
    public function setPesoNetto($PesoNetto)
    {
        if ((strlen($PesoNetto) < 4) || (strlen($PesoNetto) > 7)) {
            throw new InvalidValueException("PesoNetto must be a string between 4 and 7 characters");
        }
        $this->PesoNetto = $PesoNetto;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataOraRitiro()
    {
        return $this->DataOraRitiro;
    }

    /**
     * @param string $DataOraRitiro
     * @return DatiTrasporto
     */
    public function setDataOraRitiro($DataOraRitiro)
    {
        if (strlen($DataOraRitiro) !== 19) {
            throw new InvalidValueException("DataOraRitiro must be a datetime string in the format YYYY-MM-DDTHH:MM:SS");
        }
        $this->DataOraRitiro = $DataOraRitiro;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataInizioTraporto()
    {
        return $this->DataInizioTraporto;
    }

    /**
     * @param string $DataInizioTraporto
     * @return DatiTrasporto
     */
    public function setDataInizioTraporto($DataInizioTraporto)
    {
        if (strlen($DataInizioTraporto) !== 10) {
            throw new InvalidValueException("DataInizioTrasporto must be a date string in the format YYYY-MM-DD");
        }
        $this->DataInizioTraporto = $DataInizioTraporto;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoResa()
    {
        return $this->TipoResa;
    }

    /**
     * @param string $TipoResa
     * @return DatiTrasporto
     */
    public function setTipoResa($TipoResa)
    {
        if (strlen($TipoResa) !== 3) {
            throw new InvalidValueException("TipoResa must be a string of 3 characters");
        }
        $this->TipoResa = $TipoResa;
        return $this;
    }

    /**
     * @return string
     */
    public function getIndirizzoResa()
    {
        return $this->IndirizzoResa;
    }

    /**
     * @param string $IndirizzoResa
     * @return DatiTrasporto
     */
    public function setIndirizzoResa($IndirizzoResa)
    {
        $this->IndirizzoResa = $IndirizzoResa;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataOraConsegna()
    {
        return $this->DataOraConsegna;
    }

    /**
     * @param string $DataOraConsegna
     * @return DatiTrasporto
     */
    public function setDataOraConsegna($DataOraConsegna)
    {
        if (strlen($DataOraConsegna) !== 19) {
            throw new InvalidValueException("DataOraConsegna must be a datetime string in the format YYYY-MM-DDTHH:MM:SS");
        }
        $this->DataOraConsegna = $DataOraConsegna;
        return $this;
    }
}
