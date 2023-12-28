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

class DatiDDT implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $NumeroDDT;

    /** @var string */
    protected $DataDDT;

    /** @var string[] */
    protected $RiferimentoNumeroLinea;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}NumeroDDT') {
                $this->NumeroDDT = $child['value'];
            } elseif ($child['name'] === '{}DataDDT') {
                $this->DataDDT = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoNumeroLinea') {
                $this->RiferimentoNumeroLinea[] = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->NumeroDDT ? $data['NumeroDDT'] = $this->NumeroDDT : null;
        $this->DataDDT ? $data['DataDDT'] = $this->DataDDT : null;
        if ($this->RiferimentoNumeroLinea) {
            foreach ($this->RiferimentoNumeroLinea as $RiferimentoNumeroLinea) {
                $data[] = ['name' => 'RiferimentoNumeroLinea', 'value' => $RiferimentoNumeroLinea];
            }
        }
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getNumeroDDT()
    {
        return $this->NumeroDDT;
    }

    /**
     * @param string $NumeroDDT
     * @return DatiDDT
     */
    public function setNumeroDDT($NumeroDDT)
    {
        if (strlen($NumeroDDT) > 20) {
            throw new InvalidValueException("NumeroDDT must be a string of maximum 20 characters");
        }
        $this->NumeroDDT = $NumeroDDT;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataDDT()
    {
        return $this->DataDDT;
    }

    /**
     * @param string $DataDDT
     * @return DatiDDT
     */
    public function setDataDDT($DataDDT)
    {
        if (strlen($DataDDT) !== 10) {
            throw new InvalidValueException("DataDDT must be a date string in the format YYYY-MM-DD");
        }
        $this->DataDDT = $DataDDT;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getRiferimentoNumeroLinea()
    {
        return $this->RiferimentoNumeroLinea;
    }

    /**
     * @param string $RiferimentoNumeroLinea
     * @return DatiDDT
     */
    public function setRiferimentoNumeroLinea($RiferimentoNumeroLinea)
    {
        if (strlen($RiferimentoNumeroLinea) > 4) {
            throw new InvalidValueException("RiferimentoNumeroLinea must be a string of maximum 4 characters");
        }
        $this->RiferimentoNumeroLinea = $RiferimentoNumeroLinea;
        return $this;
    }


}
