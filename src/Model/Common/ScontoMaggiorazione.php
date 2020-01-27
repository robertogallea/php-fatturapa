<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 10:20
 */

namespace Robertogallea\FatturaPA\Model\Common;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class ScontoMaggiorazione implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $Tipo;

    /** @var string */
    protected $Percentuale;

    /** @var string */
    protected $Importo;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Tipo') {
                $this->Tipo = $child['value'];
            } elseif ($child['name'] === '{}Percentuale') {
                $this->Percentuale = $child['value'];
            } elseif ($child['name'] === '{}Importo') {
                $this->Importo = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->Tipo ? $data['Tipo'] = $this->Tipo : null;
        $this->Percentuale ? $data['Percentuale'] = $this->Percentuale : null;
        $this->Importo ? $data['Importo'] = $this->Importo : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->Tipo;
    }

    /**
     * @param string $Tipo
     * @return ScontoMaggiorazione
     */
    public function setTipo($Tipo)
    {
        if (strlen($Tipo) !== 2) {
            throw new InvalidValueException("Tipo must be a string of 2 characters");
        }
        $this->Tipo = $Tipo;
        return $this;
    }

    /**
     * @return string
     */
    public function getPercentuale()
    {
        return $this->Percentuale;
    }

    /**
     * @param string $Percentuale
     * @return ScontoMaggiorazione
     */
    public function setPercentuale($Percentuale)
    {
        if ((strlen($Percentuale) < 4) || (strlen($Percentuale) > 6)) {
            throw new InvalidValueException("Percentuale must be a string between 4 and 6 characters");
        }
        $this->Percentuale = $Percentuale;
        return $this;
    }

    /**
     * @return string
     */
    public function getImporto()
    {
        return $this->Importo;
    }

    /**
     * @param string $Importo
     * @return ScontoMaggiorazione
     */
    public function setImporto($Importo)
    {
        if ((strlen($Importo) < 4) || (strlen($Importo) > 15)) {
            throw new InvalidValueException("Importo must be a string between 4 and 15 characters");
        }
        $this->Importo = $Importo;
        return $this;
    }
    
    
}