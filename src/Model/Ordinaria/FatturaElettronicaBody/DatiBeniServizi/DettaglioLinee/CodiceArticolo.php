<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class CodiceArticolo implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $CodiceTipo;

    /** @var string */
    protected $CodiceValore;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}CodiceTipo') {
                $this->CodiceTipo = $child['value'];
            } elseif ($child['name'] === '{}CodiceValore') {
                $this->CodiceValore = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->CodiceTipo ? $data['CodiceTipo'] = $this->CodiceTipo : null;
        $this->CodiceValore ? $data['CodiceValore'] = $this->CodiceValore : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getCodiceTipo()
    {
        return $this->CodiceTipo;
    }

    /**
     * @param string $CodiceTipo
     * @return CodiceArticolo
     */
    public function setCodiceTipo($CodiceTipo)
    {
        if (strlen($CodiceTipo) > 35) {
            throw new InvalidValueException("CodiceTipo must be a string of maximum 35 characters");
        }
        $this->CodiceTipo = $CodiceTipo;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodiceValore()
    {
        return $this->CodiceValore;
    }

    /**
     * @param string $CodiceValore
     * @return CodiceArticolo
     */
    public function setCodiceValore($CodiceValore)
    {
        if (strlen($CodiceValore) > 35) {
            throw new InvalidValueException("CodiceValore must be a string of maximum 35 characters");
        }
        $this->CodiceValore = $CodiceValore;
        return $this;
    }


}
