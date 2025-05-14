<?php

/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 09:23
 */

namespace Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class IdFiscaleIVA implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $IdPaese;

    /** @var string */
    protected $IdCodice;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}IdPaese') {
                $this->IdPaese = $child['value'];
            } elseif ($child['name'] === '{}IdCodice') {
                $this->IdCodice = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
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
     * @return IdFiscaleIVA
     */
    public function setIdPaese($IdPaese)
    {
        if (strlen($ProgressivoInvio) !== 2) {
            throw new InvalidValueException("IdPaese must be a string of 2 characters");
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
     * @return IdFiscaleIVA
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
