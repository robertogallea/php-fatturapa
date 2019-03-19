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

class DatiBollo implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $BolloVirtuale;

    /** @var string */
    protected $ImportoBollo;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}BolloVirtuale') {
                $this->BolloVirtuale = $child['value'];
            } elseif ($child['name'] === '{}ImportoBollo') {
                $this->ImportoBollo = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->BolloVirtuale ? $data['BolloVirtuale'] = $this->BolloVirtuale : null;
        $this->ImportoBollo ? $data['ImportoBollo'] = $this->ImportoBollo : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getBolloVirtuale()
    {
        return $this->BolloVirtuale;
    }

    /**
     * @param string $BolloVirtuale
     * @return DatiBollo
     */
    public function setBolloVirtuale($BolloVirtuale)
    {
        if (strlen($BolloVirtuale) !== 2) {
            throw new InvalidValueException("BolloVirtuale must be a string of 2 characters");
        }
        $this->BolloVirtuale = $BolloVirtuale;
        return $this;
    }

    /**
     * @return string
     */
    public function getImportoBollo()
    {
        return $this->ImportoBollo;
    }

    /**
     * @param string $ImportoBollo
     * @return DatiBollo
     */
    public function setImportoBollo($ImportoBollo)
    {
        if ((strlen($ImportoBollo) < 4) || (strlen($ImportoBollo) > 15)) {
            throw new InvalidValueException("ImportoBollo must be a string between 4 and 15 characters");
        }
        $this->ImportoBollo = $ImportoBollo;
        return $this;
    }


}