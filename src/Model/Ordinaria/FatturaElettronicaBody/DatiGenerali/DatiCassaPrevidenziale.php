<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:37
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiCassaPrevidenziale implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $TipoCassa;

    /** @var string */
    protected $AlCassa;

    /** @var string */
    protected $ImportoContributoCassa;

    /** @var string */
    protected $ImponibileCassa;

    /** @var string */
    protected $AliquotaIVA;

    /** @var string */
    protected $Ritenuta;

    /** @var string */
    protected $Natura;

    /** @var string */
    protected $RiferimentoAmministrazione;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}TipoCassa') {
                $this->TipoCassa = $child['value'];
            } elseif ($child['name'] === '{}AlCassa') {
                $this->AlCassa = $child['value'];
            } elseif ($child['name'] === '{}ImportoContributoCassa') {
                $this->ImportoContributoCassa = $child['value'];
            } elseif ($child['name'] === '{}ImponibileCassa') {
                $this->ImponibileCassa = $child['value'];
            } elseif ($child['name'] === '{}AliquotaIVA') {
                $this->AliquotaIVA = $child['value'];
            } elseif ($child['name'] === '{}Ritenuta') {
                $this->Ritenuta = $child['value'];
            } elseif ($child['name'] === '{}Natura') {
                $this->Natura = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoAmministrazione') {
                $this->RiferimentoAmministrazione = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->TipoCassa ? $data['TipoCassa'] = $this->TipoCassa : null;
        $this->AlCassa ? $data['AlCassa'] = $this->AlCassa : null;
        $this->ImportoContributoCassa ? $data['ImportoContributoCassa'] = $this->ImportoContributoCassa : null;
        $this->ImponibileCassa ? $data['ImponibileCassa'] = $this->ImponibileCassa : null;
        $this->AliquotaIVA ? $data['AliquotaIVA'] = $this->AliquotaIVA : null;
        $this->Ritenuta ? $data['Ritenuta'] = $this->Ritenuta : null;
        $this->Natura ? $data['Natura'] = $this->Natura : null;
        $this->RiferimentoAmministrazione ? $data['RiferimentoAmministrazione'] = $this->RiferimentoAmministrazione : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getTipoCassa()
    {
        return $this->TipoCassa;
    }

    /**
     * @param string $TipoCassa
     * @return DatiCassaPrevidenziale
     */
    public function setTipoCassa($TipoCassa)
    {
        if (strlen($TipoCassa) !== 4) {
            throw new InvalidValueException("TipoCassa must be a string of 4 characters");
        }
        $this->TipoCassa = $TipoCassa;
        return $this;
    }

    /**
     * @return string
     */
    public function getAlCassa()
    {
        return $this->AlCassa;
    }

    /**
     * @param string $AlCassa
     * @return DatiCassaPrevidenziale
     */
    public function setAlCassa($AlCassa)
    {
        if ((strlen($AlCassa) < 4) || (strlen($AlCassa) > 6)) {
            throw new InvalidValueException("AlCassa must be a string between 4 and 6 characters");
        }
        $this->AlCassa = $AlCassa;
        return $this;
    }

    /**
     * @return string
     */
    public function getImportoContributoCassa()
    {
        return $this->ImportoContributoCassa;
    }

    /**
     * @param string $ImportoContributoCassa
     * @return DatiCassaPrevidenziale
     */
    public function setImportoContributoCassa($ImportoContributoCassa)
    {
        if ((strlen($ImportoContributoCassa) < 4) || (strlen($ImportoContributoCassa) > 15)) {
            throw new InvalidValueException("ImportoContributoCassa must be a string between 4 and 15 characters");
        }
        $this->ImportoContributoCassa = $ImportoContributoCassa;
        return $this;
    }

    /**
     * @return string
     */
    public function getImponibileCassa()
    {
        return $this->ImponibileCassa;
    }

    /**
     * @param string $ImponibileCassa
     * @return DatiCassaPrevidenziale
     */
    public function setImponibileCassa($ImponibileCassa)
    {
        if ((strlen($ImponibileCassa) < 4) || (strlen($ImponibileCassa) > 15)) {
            throw new InvalidValueException("ImponibileCassa must be a string between 4 and 15 characters");
        }
        $this->ImponibileCassa = $ImponibileCassa;
        return $this;
    }

    /**
     * @return string
     */
    public function getAliquotaIVA()
    {
        return $this->AliquotaIVA;
    }

    /**
     * @param string $AliquotaIVA
     * @return DatiCassaPrevidenziale
     */
    public function setAliquotaIVA($AliquotaIVA)
    {
        if ((strlen($AliquotaIVA) < 4) || (strlen($AliquotaIVA) > 6)) {
            throw new InvalidValueException("AliquotaIVA must be a string between 4 and 6 characters");
        }
        $this->AliquotaIVA = $AliquotaIVA;
        return $this;
    }

    /**
     * @return string
     */
    public function getRitenuta()
    {
        return $this->Ritenuta;
    }

    /**
     * @param string $Ritenuta
     * @return DatiCassaPrevidenziale
     */
    public function setRitenuta($Ritenuta)
    {
        if (strlen($Ritenuta) !== 2) {
            throw new InvalidValueException("Ritenuta must be a string of 2 characters");
        }
        $this->Ritenuta = $Ritenuta;
        return $this;
    }

    /**
     * @return string
     */
    public function getNatura()
    {
        return $this->Natura;
    }

    /**
     * @param string $Natura
     * @return DatiCassaPrevidenziale
     */
    public function setNatura($Natura)
    {
        if (strlen($Natura) !== 2) {
            throw new InvalidValueException("Natura must be a string of 2 characters");
        }
        $this->Natura = $Natura;
        return $this;
    }

    /**
     * @return string
     */
    public function getRiferimentoAmministrazione()
    {
        return $this->RiferimentoAmministrazione;
    }

    /**
     * @param string $RiferimentoAmministrazione
     * @return DatiCassaPrevidenziale
     */
    public function setRiferimentoAmministrazione($RiferimentoAmministrazione)
    {
        if (strlen($RiferimentoAmministrazione) > 20) {
            throw new InvalidValueException("ImportoContributoCassa must be a string of maximum 20 characters");
        }
        $this->RiferimentoAmministrazione = $RiferimentoAmministrazione;
        return $this;
    }


}