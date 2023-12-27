<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:38
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiSAL implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $RiferimentoFase;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}RiferimentoFase') {
                $this->RiferimentoFase = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->RiferimentoFase ? $data['RiferimentoFase'] = $this->RiferimentoFase : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getRiferimentoFase()
    {
        return $this->RiferimentoFase;
    }

    /**
     * @param string $RiferimentoFase
     * @return DatiSAL
     */
    public function setRiferimentoFase($RiferimentoFase)
    {
        if (strlen($RiferimentoFase) > 3) {
            throw new InvalidValueException("RiferimentoFase must be a string of maximum 2 characters");
        }
        $this->RiferimentoFase = $RiferimentoFase;
        return $this;
    }


}
