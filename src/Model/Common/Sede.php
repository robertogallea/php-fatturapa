<?php

/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 09:28
 */

namespace Robertogallea\FatturaPA\Model\Common;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Sede implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $Indirizzo;

    /** @var string */
    protected $NumeroCivico;

    /** @var string */
    protected $CAP;

    /** @var string */
    protected $Comune;

    /** @var string */
    protected $Provincia;

    /** @var string */
    protected $Nazione;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}Indirizzo') {
                $this->Indirizzo = $child['value'];
            } elseif ($child['name'] === '{}NumeroCivico') {
                $this->NumeroCivico = $child['value'];
            } elseif ($child['name'] === '{}CAP') {
                $this->CAP = $child['value'];
            } elseif ($child['name'] === '{}Comune') {
                $this->Comune = $child['value'];
            } elseif ($child['name'] === '{}Provincia') {
                $this->Provincia = $child['value'];
            } elseif ($child['name'] === '{}Nazione') {
                $this->Nazione = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->Indirizzo ? $data['Indirizzo'] = $this->Indirizzo : null;
        $this->NumeroCivico ? $data['NumeroCivico'] = $this->NumeroCivico : null;
        $this->CAP ? $data['CAP'] = $this->CAP : null;
        $this->Comune ? $data['Comune'] = $this->Comune : null;
        $this->Provincia ? $data['Provincia'] = $this->Provincia : null;
        $this->Nazione ? $data['Nazione'] = $this->Nazione : null;
        $writer->write($data);
    }

    /**
     * @return mixed
     */
    public function getIndirizzo()
    {
        return $this->Indirizzo;
    }

    /**
     * @param string $Indirizzo
     * @return Sede
     */
    public function setIndirizzo($Indirizzo)
    {
        if (strlen($Indirizzo) > 60) {
            throw new InvalidValueException("Indirizzo must be a string of maximum 60 characters");
        }
        $this->Indirizzo = $Indirizzo;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumeroCivico()
    {
        return $this->NumeroCivico;
    }

    /**
     * @param string $NumeroCivico
     * @return Sede
     */
    public function setNumeroCivico($NumeroCivico)
    {
        if (strlen($NumeroCivico) > 8) {
            throw new InvalidValueException("NumeroCivico must be a string of maximum 8 characters");
        }
        $this->NumeroCivico = $NumeroCivico;
        return $this;
    }

    /**
     * @return string
     */
    public function getCAP()
    {
        return $this->CAP;
    }

    /**
     * @param string $CAP
     * @return Sede
     */
    public function setCAP($CAP)
    {
        if (strlen($CAP) !== 5) {
            throw new InvalidValueException("Indirizzo must be a string of 5 characters");
        }
        $this->CAP = $CAP;
        return $this;
    }

    /**
     * @return string
     */
    public function getComune()
    {
        return $this->Comune;
    }

    /**
     * @param string $Comune
     * @return Sede
     */
    public function setComune($Comune)
    {
        if (strlen($Comune) > 60) {
            throw new InvalidValueException("Comune must be a string of maximum 60 characters");
        }
        $this->Comune = $Comune;
        return $this;
    }

    /**
     * @return string
     */
    public function getProvincia()
    {
        return $this->Provincia;
    }

    /**
     * @param string $Provincia
     * @return Sede
     */
    public function setProvincia($Provincia)
    {
        if (strlen($Provincia) !== 2) {
            throw new InvalidValueException("Provincia must be a string of 2 characters");
        }
        $this->Provincia = $Provincia;
        return $this;
    }

    /**
     * @return string
     */
    public function getNazione()
    {
        return $this->Nazione;
    }

    /**
     * @param string $Nazione
     * @return Sede
     */
    public function setNazione($Nazione)
    {
        if (strlen($Nazione) !== 2) {
            throw new InvalidValueException("Nazione must be a string of 2 characters");
        }
        $this->Nazione = $Nazione;
        return $this;
    }
}
