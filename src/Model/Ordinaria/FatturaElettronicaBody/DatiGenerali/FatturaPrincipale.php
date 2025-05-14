<?php

/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:39
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class FatturaPrincipale implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $NumeroFatturaPrincipale;

    /** @var string */
    protected $DataFatturaPrincipale;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}NumeroFatturaPrincipale') {
                $this->NumeroFatturaPrincipale = $child['value'];
            } elseif ($child['name'] === '{}DataFatturaPrincipale') {
                $this->DataFatturaPrincipale = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->NumeroFatturaPrincipale ? $data['NumeroFatturaPrincipale'] = $this->NumeroFatturaPrincipale : null;
        $this->DataFatturaPrincipale ? $data['DataFatturaPrincipale'] = $this->DataFatturaPrincipale : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getNumeroFatturaPrincipale()
    {
        return $this->NumeroFatturaPrincipale;
    }

    /**
     * @param string $NumeroFatturaPrincipale
     * @return FatturaPrincipale
     */
    public function setNumeroFatturaPrincipale($NumeroFatturaPrincipale)
    {
        $this->NumeroFatturaPrincipale = $NumeroFatturaPrincipale;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataFatturaPrincipale()
    {
        return $this->DataFatturaPrincipale;
    }

    /**
     * @param string $DataFatturaPrincipale
     * @return FatturaPrincipale
     */
    public function setDataFatturaPrincipale($DataFatturaPrincipale)
    {
        $this->DataFatturaPrincipale = $DataFatturaPrincipale;
        return $this;
    }
}
