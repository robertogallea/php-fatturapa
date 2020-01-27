<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:40
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiVeicoli implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $Data;

    /** @var string */
    protected $TotalePercorso;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Data') {
                $this->Data = $child['value'];
            } elseif ($child['name'] === '{}TotalePercorso') {
                $this->TotalePercorso = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->Data ? $data['Data'] = $this->Data : null;
        $this->TotalePercorso ? $data['TotalePercorso'] = $this->TotalePercorso : null;
        $writer->write($data);
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
     * @return DatiVeicoli
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
    public function getTotalePercorso()
    {
        return $this->TotalePercorso;
    }

    /**
     * @param string $TotalePercorso
     * @return DatiVeicoli
     */
    public function setTotalePercorso($TotalePercorso)
    {
        if (strlen($TotalePercorso) > 15) {
            throw new InvalidValueException("TotalePercorso must be a string of maximum 15 characters");
        }
        $this->TotalePercorso = $TotalePercorso;
        return $this;
    }
    
    
}