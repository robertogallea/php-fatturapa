<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:38
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiRitenuta implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $TipoRitenuta;

    /** @var string */
    protected $ImportoRitenuta;

    /** @var string */
    protected $AliquotaRitenuta;

    /** @var string */
    protected $CausalePagamento;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {

            if ($child['name'] === '{}TipoRitenuta') {
                $this->TipoRitenuta = $child['value'];
            } elseif ($child['name'] === '{}ImportoRitenuta') {
                $this->ImportoRitenuta = $child['value'];
            } elseif ($child['name'] === '{}AliquotaRitenuta') {
                $this->AliquotaRitenuta = $child['value'];
            } elseif ($child['name'] === '{}CausalePagamento') {
                $this->CausalePagamento = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->TipoRitenuta ? $data['TipoRitenuta'] = $this->TipoRitenuta : null;
        $this->ImportoRitenuta ? $data['ImportoRitenuta'] = $this->ImportoRitenuta : null;
        $this->AliquotaRitenuta ? $data['AliquotaRitenuta'] = $this->AliquotaRitenuta : null;
        $this->CausalePagamento ? $data['CausalePagamento'] = $this->CausalePagamento : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getTipoRitenuta()
    {
        return $this->TipoRitenuta;
    }

    /**
     * @param string $TipoRitenuta
     * @return DatiRitenuta
     */
    public function setTipoRitenuta($TipoRitenuta)
    {
        if (strlen($TipoRitenuta) !== 4) {
            throw new InvalidValueException("TipoRitenuta must be a string of 4 characters");
        }
        $this->TipoRitenuta = $TipoRitenuta;
        return $this;
    }

    /**
     * @return string
     */
    public function getImportoRitenuta()
    {
        return $this->ImportoRitenuta;
    }

    /**
     * @param string $ImportoRitenuta
     * @return DatiRitenuta
     */
    public function setImportoRitenuta($ImportoRitenuta)
    {
        if ((strlen($ImportoRitenuta) < 4) || (strlen($ImportoRitenuta) > 15)) {
            throw new InvalidValueException("ImportoRitenuta must be a string between 4 and 15 characters");
        }
        $this->ImportoRitenuta = $ImportoRitenuta;
        return $this;
    }

    /**
     * @return string
     */
    public function getAliquotaRitenuta()
    {
        return $this->AliquotaRitenuta;
    }

    /**
     * @param string $AliquotaRitenuta
     * @return DatiRitenuta
     */
    public function setAliquotaRitenuta($AliquotaRitenuta)
    {
        if ((strlen($AliquotaRitenuta) < 4) || (strlen($AliquotaRitenuta) > 6)) {
            throw new InvalidValueException("AliquotaRitenuta must be a string between 4 and 6 characters");
        }
        $this->AliquotaRitenuta = $AliquotaRitenuta;
        return $this;
    }

    /**
     * @return string
     */
    public function getCausalePagamento()
    {
        return $this->CausalePagamento;
    }

    /**
     * @param string $CausalePagamento
     * @return DatiRitenuta
     */
    public function setCausalePagamento($CausalePagamento)
    {
        if ((strlen($CausalePagamento) < 1) || (strlen($CausalePagamento) > 2)) {
            throw new InvalidValueException("CausalePagamento must be a string between 1 and 2 characters");
        }
        $this->CausalePagamento = $CausalePagamento;
        return $this;
    }
    
    
}