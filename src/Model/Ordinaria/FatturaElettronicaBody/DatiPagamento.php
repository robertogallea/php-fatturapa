<?php

/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:39
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiPagamento\DettaglioPagamento;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiPagamento implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $CondizioniPagamento;

    /** @var DettaglioPagamento[] */
    protected $DettaglioPagamento;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}CondizioniPagamento') {
                $this->CondizioniPagamento = $child['value'];
            } elseif ($child['value'] instanceof DettaglioPagamento) {
                $this->DettaglioPagamento[] = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->CondizioniPagamento ? $data['CondizioniPagamento'] = $this->CondizioniPagamento : null;
        if ($this->DettaglioPagamento) {
            foreach ($this->DettaglioPagamento as $DettaglioPagamento) {
                $data[] = ['name' => 'DettaglioPagamento', 'value' => $DettaglioPagamento];
            }
        }
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getCondizioniPagamento()
    {
        return $this->CondizioniPagamento;
    }

    /**
     * @param string $CondizioniPagamento
     * @return DatiPagamento
     */
    public function setCondizioniPagamento($CondizioniPagamento)
    {
        if (in_array($CondizioniPagamento, ['TP01', 'TP02', 'TP03'])) {
            throw new InvalidValueException("CondizioniPagamento must be equal to TP01, TP02 or TP03");
        }
        $this->CondizioniPagamento = $CondizioniPagamento;
        return $this;
    }

    /**
     * @return DettaglioPagamento[]
     */
    public function getDettaglioPagamento()
    {
        return $this->DettaglioPagamento;
    }

    /**
     * @param DettaglioPagamento[] $DettaglioPagamento
     * @return DatiPagamento
     */
    public function setDettaglioPagamento($DettaglioPagamento)
    {
        $this->DettaglioPagamento = $DettaglioPagamento;
        return $this;
    }
}
