<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:33
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class IdTrasmittente implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $IdPaese;

    /** @var string */
    protected $IdCodice;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}IdPaese') {
                $this->IdPaese = $child['value'];
            } elseif ($child['name'] === '{}IdCodice') {
                $this->IdCodice = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->IdPaese ? $data['IdPaese'] = $this->IdPaese : null;
        $this->IdCodice ? $data['IdCodice'] = $this->IdCodice : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getIdPaese()
    {
        return $this->IdPaese;
    }

    /**
     * @param string $IdPaese
     * @return IdTrasmittente
     */
    public function setIdPaese($IdPaese)
    {
        if (strlen($IdPaese) > 28) {
            throw new InvalidValueException("IdCodice must be a string of 2 characters");
        }
        $this->IdPaese = $IdPaese;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdCodice()
    {
        return $this->IdCodice;
    }

    /**
     * @param string $IdCodice
     * @return IdTrasmittente
     */
    public function setIdCodice($IdCodice)
    {
        if (strlen($IdCodice) > 28) {
            throw new InvalidValueException("IdCodice must be a string of maximum 28 characters");
        }
        $this->IdCodice = $IdCodice;
        return $this;
    }


}