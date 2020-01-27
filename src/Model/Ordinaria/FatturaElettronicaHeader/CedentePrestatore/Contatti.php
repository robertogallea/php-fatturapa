<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:30
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Contatti implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $Telefono;

    /** @var string */
    protected $Email;

    /** @var string */
    protected $Fax;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        if (is_null($children)) {
            return;
        }

        foreach($children as $child) {
            if ($child['name'] === '{}Telefono') {
                $this->Telefono = $child['value'];
            } elseif ($child['name'] === '{}Email') {
                $this->Email = $child['value'];
            } elseif ($child['name'] === '{}Fax') {
                $this->Fax = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->Telefono ? $data['Telefono'] = $this->Telefono : null;
        $this->Email ? $data['Email'] = $this->Email : null;
        $this->Fax ? $data['Fax'] = $this->Fax : null;
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
     * @return Contatti
     */
    public function setTelefono($Telefono)
    {
        if ((strlen($Telefono) < 5) || (strlen($Telefono) > 12)) {
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
     * @return Contatti
     */
    public function setEmail($Email)
    {
        if ((strlen($Email) < 7) || (strlen($Email) > 256)) {
            throw new InvalidValueException("Email must be a string between 7 and 256 characters");
        }
        $this->Email = $Email;
        return $this;
    }

    /**
     * @return string
     */
    public function getFax()
    {
        return $this->Fax;
    }

    /**
     * @param string $Fax
     * @return Contatti
     */
    public function setFax($Fax)
    {
        if ((strlen($Fax) < 5) || (strlen($Fax) > 12)) {
            throw new InvalidValueException("Fax must be a string between 5 and 12 characters");
        }
        $this->Fax = $Fax;
        return $this;
    }


}