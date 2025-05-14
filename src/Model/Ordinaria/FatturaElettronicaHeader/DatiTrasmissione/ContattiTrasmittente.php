<?php

/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:32
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class ContattiTrasmittente implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $Telefono;

    /** @var string */
    protected $Email;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        if (is_null($children)) {
            return;
        }

        foreach ($children as $child) {
            if ($child['name'] === '{}Telefono') {
                $this->Telefono = $child['value'];
            } elseif ($child['name'] === '{}Email') {
                $this->Email = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->Telefono ? $data['Telefono'] = $this->Telefono : null;
        $this->Email ? $data['Email'] = $this->Email : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getTelefono()
    {
        return $this->Telefono;
    }

    /**
     * @param string $Telefono
     * @return ContattiTrasmittente
     */
    public function setTelefono($Telefono)
    {
        if ((strlen($Telefono) < 5) && (strlen($Telefono) > 12)) {
            throw new InvalidValueException("Telefono must be a string between 5 and 12 characters");
        }
        $this->Telefono = $Telefono;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * @param string $Email
     * @return ContattiTrasmittente
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;
        return $this;
    }
}
