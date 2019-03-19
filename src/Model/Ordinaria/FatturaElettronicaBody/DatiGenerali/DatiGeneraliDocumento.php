<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:38
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\ScontoMaggiorazione;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiGeneraliDocumento implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $TipoDocumento;

    /** @var string */
    protected $Divisa;

    /** @var string */
    protected $Data;

    /** @var string */
    protected $Numero;

    /** @var DatiRitenuta */
    protected $DatiRitenuta;

    /** @var DatiBollo */
    protected $DatiBollo;

    /** @var DatiCassaPrevidenziale[] */
    protected $DatiCassaPrevidenziale;

    /** @var ScontoMaggiorazione[] */
    protected $ScontoMaggiorazione;

    /** @var string */
    protected $ImportoTotaleDocumento;

    /** @var string */
    protected $Arrotondamento;

    /** @var string[] */
    protected $Causale;

    /** @var string */
    protected $Art73;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}TipoDocumento') {
                $this->TipoDocumento = $child['value'];
            } elseif ($child['name'] === '{}Divisa') {
                $this->Divisa = $child['value'];
            } elseif ($child['name'] === '{}Data') {
                $this->Data = $child['value'];
            } elseif ($child['name'] === '{}Numero') {
                $this->Numero = $child['value'];
            } elseif ($child['value'] instanceof DatiRitenuta) {
                $this->DatiRitenuta = $child['value'];
            } elseif ($child['value'] instanceof DatiBollo) {
                $this->DatiBollo = $child['value'];
            } elseif ($child['value'] instanceof DatiCassaPrevidenziale) {
                $this->DatiCassaPrevidenziale[] = $child['value'];
            } elseif ($child['value'] instanceof ScontoMaggiorazione) {
                $this->ScontoMaggiorazione[] = $child['value'];
            }  elseif ($child['name'] === '{}ImportoTotaleDocumento') {
                $this->ImportoTotaleDocumento = $child['value'];
            } elseif ($child['name'] === '{}Arrotondamento') {
                $this->Arrotondamento = $child['value'];
            } elseif ($child['name'] === '{}Causale') {
                $this->Causale[] = $child['value'];
            } elseif ($child['name'] === '{}Art73') {
                $this->Art73 = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->TipoDocumento ? $data['TipoDocumento'] = $this->TipoDocumento : null;
        $this->Divisa ? $data['Divisa'] = $this->Divisa : null;
        $this->Data ? $data['Data'] = $this->Data : null;
        $this->Numero ? $data['Numero'] = $this->Numero : null;
        $this->DatiRitenuta ? $data['DatiRitenuta'] = $this->DatiRitenuta : null;
        $this->DatiBollo ? $data['DatiBollo'] = $this->DatiBollo : null;
        if ($this->DatiCassaPrevidenziale) {
            foreach ($this->DatiCassaPrevidenziale as $DatiCassaPrevidenziale) {
                $data[] = ['name' => 'DatiCassaPrevidenziale', 'value' => $DatiCassaPrevidenziale];
            }
        }
        if ($this->ScontoMaggiorazione) {
            foreach ($this->ScontoMaggiorazione as $ScontoMaggiorazione) {
                $data[] = ['name' => 'ScontoMaggiorazione', 'value' => $ScontoMaggiorazione];
            }
        }
        $this->DatiBollo ? $data['DatiBollo'] = $this->DatiBollo : null;
        $this->DatiCassaPrevidenziale ? $data['DatiCassaPrevidenziale'] = $this->DatiCassaPrevidenziale : null;
        if ($this->ScontoMaggiorazione) {
            foreach ($this->ScontoMaggiorazione as $ScontoMaggiorazione) {
                $data[] = ['name' => 'ScontoMaggiorazione', 'value' => $ScontoMaggiorazione];
            }
        }
        $this->ImportoTotaleDocumento ? $data['ImportoTotaleDocumento'] = $this->ImportoTotaleDocumento : null;
        $this->Arrotondamento ? $data['Arrotondamento'] = $this->Arrotondamento : null;
        if ($this->Causale) {
            foreach ($this->Causale as $Causale) {
                $data[] = ['name' => 'Causale', 'value' => $Causale];
            }
        }
        $this->Art73 ? $data['Art73'] = $this->Art73 : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getTipoDocumento()
    {
        return $this->TipoDocumento;
    }

    /**
     * @param string $TipoDocumento
     * @return DatiGeneraliDocumento
     */
    public function setTipoDocumento($TipoDocumento)
    {
        if (strlen($TipoDocumento) !== 4) {
            throw new InvalidValueException("TipoDocumento must be a string between of 4 characters");
        }
        $this->TipoDocumento = $TipoDocumento;
        return $this;
    }

    /**
     * @return string
     */
    public function getDivisa()
    {
        return $this->Divisa;
    }

    /**
     * @param string $Divisa
     * @return DatiGeneraliDocumento
     */
    public function setDivisa($Divisa)
    {
        if (strlen($Divisa) !== 3) {
            throw new InvalidValueException("Divisa must be a string of 3 characters");
        }
        $this->Divisa = $Divisa;
        return $this;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->Data;
    }

    /**
     * @param string $Data
     * @return DatiGeneraliDocumento
     */
    public function setData($Data)
    {
        if (strlen($Data) !== 10) {
            throw new InvalidValueException("Data must be a string data in the format YYYY-MM-DD");
        }
        $this->Data = $Data;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumero()
    {
        return $this->Numero;
    }

    /**
     * @param string $Numero
     * @return DatiGeneraliDocumento
     */
    public function setNumero($Numero)
    {
        if (strlen($Numero) > 20) {
            throw new InvalidValueException("Numero must be a string of maximum 20 characters");
        }
        $this->Numero = $Numero;
        return $this;
    }

    /**
     * @return DatiRitenuta
     */
    public function getDatiRitenuta()
    {
        return $this->DatiRitenuta;
    }

    /**
     * @param DatiRitenuta $DatiRitenuta
     * @return DatiGeneraliDocumento
     */
    public function setDatiRitenuta($DatiRitenuta)
    {
        $this->DatiRitenuta = $DatiRitenuta;
        return $this;
    }

    /**
     * @return DatiBollo
     */
    public function getDatiBollo()
    {
        return $this->DatiBollo;
    }

    /**
     * @param DatiBollo $DatiBollo
     * @return DatiGeneraliDocumento
     */
    public function setDatiBollo($DatiBollo)
    {
        $this->DatiBollo = $DatiBollo;
        return $this;
    }

    /**
     * @return DatiCassaPrevidenziale[]
     */
    public function getDatiCassaPrevidenziale()
    {
        return $this->DatiCassaPrevidenziale;
    }

    /**
     * @param DatiCassaPrevidenziale[] $DatiCassaPrevidenziale
     * @return DatiGeneraliDocumento
     */
    public function setDatiCassaPrevidenziale($DatiCassaPrevidenziale)
    {
        $this->DatiCassaPrevidenziale = $DatiCassaPrevidenziale;
        return $this;
    }

    /**
     * @return ScontoMaggiorazione[]
     */
    public function getScontoMaggiorazione()
    {
        return $this->ScontoMaggiorazione;
    }

    /**
     * @param ScontoMaggiorazione[] $ScontoMaggiorazione
     * @return DatiGeneraliDocumento
     */
    public function setScontoMaggiorazione($ScontoMaggiorazione)
    {
        $this->ScontoMaggiorazione = $ScontoMaggiorazione;
        return $this;
    }

    /**
     * @return string
     */
    public function getImportoTotaleDocumento()
    {
        return $this->ImportoTotaleDocumento;
    }

    /**
     * @param string $ImportoTotaleDocumento
     * @return DatiGeneraliDocumento
     */
    public function setImportoTotaleDocumento($ImportoTotaleDocumento)
    {
        if ((strlen($ImportoTotaleDocumento) < 4) || (strlen($ImportoTotaleDocumento) > 15)) {
            throw new InvalidValueException("ImportoTotaleDocumento must be a string between 4 and 15 characters");
        }
        $this->ImportoTotaleDocumento = $ImportoTotaleDocumento;
        return $this;
    }

    /**
     * @return string
     */
    public function getArrotondamento()
    {
        return $this->Arrotondamento;
    }

    /**
     * @param string $Arrotondamento
     * @return DatiGeneraliDocumento
     */
    public function setArrotondamento($Arrotondamento)
    {
        if ((strlen($Arrotondamento) < 4) || (strlen($Arrotondamento) > 15)) {
            throw new InvalidValueException("Arrotondamento must be a string between 4 and 15 characters");
        }
        $this->Arrotondamento = $Arrotondamento;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getCausale()
    {
        return $this->Causale;
    }

    /**
     * @param string[] $Causale
     * @return DatiGeneraliDocumento
     */
    public function setCausale($Causale)
    {
        if (strlen($Causale) > 200) {
            throw new InvalidValueException("Causale must be a string of maximum 200 characters");
        }
        $this->Causale = $Causale;
        return $this;
    }

    /**
     * @return string
     */
    public function getArt73()
    {
        return $this->Art73;
    }

    /**
     * @param string $Art73
     * @return DatiGeneraliDocumento
     */
    public function setArt73($Art73)
    {
        if (strlen($ImportoContributoCassa) !== 2) {
            throw new InvalidValueException("Art73 must be a string of 2 characters");
        }
        $this->Art73 = $Art73;
        return $this;
    }
    
    
}