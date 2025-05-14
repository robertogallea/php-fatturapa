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

class Anagrafica implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $Denominazione;

    /** @var string */
    protected $Nome;

    /** @var string */
    protected $Cognome;

    /** @var string */
    protected $Titolo;

    /** @var string */
    protected $CodEORI;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}Denominazione') {
                $this->Denominazione = $child['value'];
            } elseif ($child['name'] === '{}Nome') {
                $this->Nome = $child['value'];
            } elseif ($child['name'] === '{}Cognome') {
                $this->Cognome = $child['value'];
            } elseif ($child['name'] === '{}Titolo') {
                $this->Titolo = $child['value'];
            } elseif ($child['name'] === '{}CodEORI') {
                $this->CodEORI = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->Denominazione ? $data['Denominazione'] = $this->Denominazione : null;
        $this->Nome ? $data['Nome'] = $this->Nome : null;
        $this->Cognome ? $data['Cognome'] = $this->Cognome : null;
        $this->Titolo ? $data['Titolo'] = $this->Titolo : null;
        $this->CodEORI ? $data['CodEORI'] = $this->CodEORI : null;
        $writer->write($data);
    }

    /**
     * @return mixed
     */
    public function getDenominazione()
    {
        return $this->Denominazione;
    }

    /**
     * @param mixed $Denominazione
     * @return Anagrafica
     */
    public function setDenominazione($Denominazione)
    {
        if (strlen($Denominazione) > 80) {
            throw new InvalidValueException("Denominazione must be a string of maximum 80 characters");
        }
        $this->Denominazione = $Denominazione;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->Nome;
    }

    /**
     * @param mixed $Nome
     * @return Anagrafica
     */
    public function setNome($Nome)
    {
        if (strlen($Nome) > 60) {
            throw new InvalidValueException("Nome must be a string of maximum 60 characters");
        }
        $this->Nome = $Nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCognome()
    {
        return $this->Cognome;
    }

    /**
     * @param mixed $Cognome
     * @return Anagrafica
     */
    public function setCognome($Cognome)
    {
        if (strlen($Cognome) > 60) {
            throw new InvalidValueException("Cognome must be a string of maximum 60 characters");
        }
        $this->Cognome = $Cognome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitolo()
    {
        return $this->Titolo;
    }

    /**
     * @param mixed $Titolo
     * @return Anagrafica
     */
    public function setTitolo($Titolo)
    {
        if ((strlen($Titolo) < 2) && (strlen($Titolo) > 10)) {
            throw new InvalidValueException("Titolo must be a string between 2 and 10 characters");
        }
        $this->Titolo = $Titolo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCodEORI()
    {
        return $this->CodEORI;
    }

    /**
     * @param mixed $CodEORI
     * @return Anagrafica
     */
    public function setCodEORI($CodEORI)
    {
        if ((strlen($CodEORI) < 3) && (strlen($CodEORI) > 17)) {
            throw new InvalidValueException("CodEORI must be a string between 3 and 17 characters");
        }
        $this->CodEORI = $CodEORI;
        return $this;
    }
}
