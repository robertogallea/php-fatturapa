<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:37
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiContratto implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $RiferimentoNumeroLinea;

    /** @var string */
    protected $IdDocumento;

    /** @var string */
    protected $Data;

    /** @var string */
    protected $NumItem;

    /** @var string */
    protected $CodiceCommessaConvenzione;

    /** @var string */
    protected $CodiceCUP;

    /** @var string */
    protected $CodiceCIG;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}RiferimentoNumeroLinea') {
                $this->RiferimentoNumeroLinea[] = $child['value'];
            } elseif ($child['name'] === '{}IdDocumento') {
                $this->IdDocumento = $child['value'];
            } elseif ($child['name'] === '{}Data') {
                $this->Data = $child['value'];
            } elseif ($child['name'] === '{}NumItem') {
                $this->NumItem = $child['value'];
            } elseif ($child['name'] === '{}CodiceCommessaConvenzione') {
                $this->CodiceCommessaConvenzione = $child['value'];
            } elseif ($child['name'] === '{}CodiceCUP') {
                $this->CodiceCUP = $child['value'];
            } elseif ($child['name'] === '{}CodiceCIG') {
                $this->CodiceCIG = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        if ($this->RiferimentoNumeroLinea) {
            foreach ($this->RiferimentoNumeroLinea as $RiferimentoNumeroLinea) {
                $data[] = ['name' => 'RiferimentoNumeroLinea', 'value' => $RiferimentoNumeroLinea];
            }
        }
        $this->IdDocumento ? $data['IdDocumento'] = $this->IdDocumento : null;
        $this->Data ? $data['Data'] = $this->Data : null;
        $this->NumItem ? $data['NumItem'] = $this->NumItem : null;
        $this->CodiceCommessaConvenzione ? $data['CodiceCommessaConvenzione'] = $this->CodiceCommessaConvenzione : null;
        $this->CodiceCUP ? $data['CodiceCUP'] = $this->CodiceCUP : null;
        $this->CodiceCIG ? $data['CodiceCIG'] = $this->CodiceCIG : null;
        $writer->write($data);
    }

    /**
     * @return string[]
     */
    public function getRiferimentoNumeroLinea()
    {
        return $this->RiferimentoNumeroLinea;
    }

    /**
     * @param string[] $RiferimentoNumeroLinea
     * @return DatiOrdineAcquisto
     */
    public function setRiferimentoNumeroLinea($RiferimentoNumeroLinea)
    {
        if (strlen($RiferimentoNumeroLinea) > 4) {
            throw new InvalidValueException("RiferimentoNumeroLinea must be a string of maximum 4 characters");
        }
        $this->RiferimentoNumeroLinea = $RiferimentoNumeroLinea;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdDocumento()
    {
        return $this->IdDocumento;
    }

    /**
     * @param string $IdDocumento
     * @return DatiOrdineAcquisto
     */
    public function setIdDocumento($IdDocumento)
    {
        if (strlen($IdDocumento) > 20) {
            throw new InvalidValueException("IdDocumento must be a string of maximum 20 characters");
        }
        $this->IdDocumento = $IdDocumento;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->Data;
    }

    /**
     * @param string $Data
     * @return DatiOrdineAcquisto
     */
    public function setData($Data)
    {
        if (strlen($Data) !== 10) {
            throw new InvalidValueException("Data must be a date string in the format YYYY-MM-DD");
        }
        $this->Data = $Data;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumItem()
    {
        return $this->NumItem;
    }

    /**
     * @param string $NumItem
     * @return DatiOrdineAcquisto
     */
    public function setNumItem($NumItem)
    {
        if (strlen($NumItem) > 20) {
            throw new InvalidValueException("NumItem must be a string of maximum 20 characters");
        }
        $this->NumItem = $NumItem;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodiceCommessaConvenzione()
    {
        return $this->CodiceCommessaConvenzione;
    }

    /**
     * @param string $CodiceCommessaConvenzione
     * @return DatiOrdineAcquisto
     */
    public function setCodiceCommessaConvenzione($CodiceCommessaConvenzione)
    {
        if (strlen($CodiceCommessaConvenzione) > 100) {
            throw new InvalidValueException("CodiceCommessaConvenzione must be a string of maximum 100 characters");
        }
        $this->CodiceCommessaConvenzione = $CodiceCommessaConvenzione;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodiceCUP()
    {
        return $this->CodiceCUP;
    }

    /**
     * @param string $CodiceCUP
     * @return DatiOrdineAcquisto
     */
    public function setCodiceCUP($CodiceCUP)
    {
        if (strlen($CodiceCUP) > 15) {
            throw new InvalidValueException("CodiceCUP must be a string of maximum 15 characters");
        }
        $this->CodiceCUP = $CodiceCUP;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodiceCIG()
    {
        return $this->CodiceCIG;
    }

    /**
     * @param string $CodiceCIG
     * @return DatiOrdineAcquisto
     */
    public function setCodiceCIG($CodiceCIG)
    {
        if (strlen($CodiceCIG) > 15) {
            throw new InvalidValueException("CodiceCIG must be a string of maximum 15 characters");
        }
        $this->CodiceCIG = $CodiceCIG;
        return $this;
    }


}