<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiRiepilogo implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $AliquotaIVA;

    /** @var string */
    protected $Natura;

    /** @var string */
    protected $SpeseAccessorie;

    /** @var string */
    protected $Arrotondamento;

    /** @var string */
    protected $ImponibileImporto;

    /** @var string */
    protected $Imposta;

    /** @var string */
    protected $EsigibilitaIVA;

    /** @var string */
    protected $RiferimentoNormativo;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}AliquotaIVA') {
                $this->AliquotaIVA = $child['value'];
            } elseif ($child['name'] === '{}Natura') {
                $this->Natura = $child['value'];
            } elseif ($child['name'] === '{}SpeseAccessorie') {
                $this->SpeseAccessorie = $child['value'];
            } elseif ($child['name'] === '{}Arrotondamento') {
                $this->Arrotondamento = $child['value'];
            } elseif ($child['name'] === '{}ImponibileImporto') {
                $this->ImponibileImporto = $child['value'];
            } elseif ($child['name'] === '{}Imposta') {
                $this->Imposta = $child['value'];
            } elseif ($child['name'] === '{}EsigibilitaIVA') {
                $this->EsigibilitaIVA = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoNormativo') {
                $this->RiferimentoNormativo = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->AliquotaIVA ? $data['AliquotaIVA'] = $this->AliquotaIVA : null;
        $this->Natura ? $data['Natura'] = $this->Natura : null;
        $this->SpeseAccessorie ? $data['SpeseAccessorie'] = $this->SpeseAccessorie : null;
        $this->Arrotondamento ? $data['Arrotondamento'] = $this->Arrotondamento : null;
        $this->ImponibileImporto ? $data['ImponibileImporto'] = $this->ImponibileImporto : null;
        $this->Imposta ? $data['Imposta'] = $this->Imposta : null;
        $this->EsigibilitaIVA ? $data['EsigibilitaIVA'] = $this->EsigibilitaIVA : null;
        $this->RiferimentoNormativo ? $data['RiferimentoNormativo'] = $this->RiferimentoNormativo : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getAliquotaIVA()
    {
        return $this->AliquotaIVA;
    }

    /**
     * @param string $AliquotaIVA
     * @return DatiRiepilogo
     */
    public function setAliquotaIVA($AliquotaIVA)
    {
        if ((strlen($AliquotaIVA) < 4) || (strlen($AliquotaIVA) > 6)) {
            throw new InvalidValueException("AliquotaIVA must be a string between 4 and 6 characters");
        }
        $this->AliquotaIVA = $AliquotaIVA;
        return $this;
    }

    /**
     * @return string
     */
    public function getNatura()
    {
        return $this->Natura;
    }

    /**
     * @param string $Natura
     * @return DatiRiepilogo
     */
    public function setNatura($Natura)
    {
        if (strlen($Natura) !== 2) {
            throw new InvalidValueException("Natura must be a string of 2 characters");
        }
        $this->Natura = $Natura;
        return $this;
    }

    /**
     * @return string
     */
    public function getSpeseAccessorie()
    {
        return $this->SpeseAccessorie;
    }

    /**
     * @param string $SpeseAccessorie
     * @return DatiRiepilogo
     */
    public function setSpeseAccessorie($SpeseAccessorie)
    {
        if ((strlen($SpeseAccessorie) < 4) || (strlen($SpeseAccessorie) > 15)) {
            throw new InvalidValueException("SpeseAccessorie must be a string between 4 and 15 characters");
        }
        $this->SpeseAccessorie = $SpeseAccessorie;
        return $this;
    }

    /**
     * @return string
     */
    public function getArrotondamento()
    {
        return $this->Arrotondamento;
    }

    /**
     * @param string $Arrotondamento
     * @return DatiRiepilogo
     */
    public function setArrotondamento($Arrotondamento)
    {
        if ((strlen($Arrotondamento) < 4) || (strlen($Arrotondamento) > 21)) {
            throw new InvalidValueException("Arrotondamento must be a string between 4 and 21 characters");
        }
        $this->Arrotondamento = $Arrotondamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getImponibileImporto()
    {
        return $this->ImponibileImporto;
    }

    /**
     * @param string $ImponibileImporto
     * @return DatiRiepilogo
     */
    public function setImponibileImporto($ImponibileImporto)
    {
        if ((strlen($ImponibileImporto) < 4) || (strlen($ImponibileImporto) > 15)) {
            throw new InvalidValueException("ImponibileImporto must be a string between 4 and 15 characters");
        }
        $this->ImponibileImporto = $ImponibileImporto;
        return $this;
    }

    /**
     * @return string
     */
    public function getImposta()
    {
        return $this->Imposta;
    }

    /**
     * @param string $Imposta
     * @return DatiRiepilogo
     */
    public function setImposta($Imposta)
    {
        if ((strlen($Imposta) < 4) || (strlen($Imposta) > 15)) {
            throw new InvalidValueException("Imposta must be a string between 4 and 15 characters");
        }
        $this->Imposta = $Imposta;
        return $this;
    }

    /**
     * @return string
     */
    public function getEsigibilitaIVA()
    {
        return $this->EsigibilitaIVA;
    }

    /**
     * @param string $EsigibilitaIVA
     * @return DatiRiepilogo
     */
    public function setEsigibilitaIVA($EsigibilitaIVA)
    {
        if (strlen($EsigibilitaIVA) !== 1) {
            throw new InvalidValueException("EsigibilitaIVA must be a string of 1 character");
        }
        $this->EsigibilitaIVA = $EsigibilitaIVA;
        return $this;
    }

    /**
     * @return string
     */
    public function getRiferimentoNormativo()
    {
        return $this->RiferimentoNormativo;
    }

    /**
     * @param string $RiferimentoNormativo
     * @return DatiRiepilogo
     */
    public function setRiferimentoNormativo($RiferimentoNormativo)
    {
        if (strlen($RiferimentoNormativo) > 100) {
            throw new InvalidValueException("RiferimentoNormativo must be a string of maximum 100 characters");
        }
        $this->RiferimentoNormativo = $RiferimentoNormativo;
        return $this;
    }


}
