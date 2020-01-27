<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee\AltriDatiGestionali;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee\CodiceArticolo;
use Robertogallea\FatturaPA\Model\Common\ScontoMaggiorazione;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DettaglioLinee implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $NumeroLinea;

    /** @var string */
    protected $TipoCessionePrestazione;

    /** @var CodiceArticolo */
    protected $CodiceArticolo;

    /** @var string */
    protected $Descrizione;

    /** @var string */
    protected $Quantita;

    /** @var string */
    protected $UnitaMisura;

    /** @var string */
    protected $DataInizioPeriodo;

    /** @var string */
    protected $DataFinePeriodo;

    /** @var string */
    protected $PrezzoUnitario;

    /** @var ScontoMaggiorazione */
    protected $ScontoMaggiorazione;

    /** @var string */
    protected $PrezzoTotale;

    /** @var string */
    protected $AliquotaIVA;

    /** @var string */
    protected $Ritenuta;

    /** @var string */
    protected $Natura;

    /** @var string */
    protected $RiferimentoAmministrazione;

    /** @var AltriDatiGestionali[] */
    protected $AltriDatiGestionali;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}NumeroLinea') {
                $this->NumeroLinea = $child['value'];
            } elseif ($child['name'] === '{}TipoCessionePrestanzione') {
                $this->TipoCessionePrestazione = $child['value'];
            } elseif ($child['value'] instanceof CodiceArticolo) {
                $this->CodiceArticolo[] = $child['value'];
            } elseif ($child['name'] === '{}Descrizione') {
                $this->Descrizione = $child['value'];
            } elseif ($child['name'] === '{}Quantita') {
                $this->Quantita = $child['value'];
            } elseif ($child['name'] === '{}UnitaMisura') {
                $this->UnitaMisura = $child['value'];
            } elseif ($child['name'] === '{}DataInizioPeriodo') {
                $this->DataInizioPeriodo = $child['value'];
            } elseif ($child['name'] === '{}DataFinePeriodo') {
                $this->DataFinePeriodo = $child['value'];
            } elseif ($child['name'] === '{}PrezzoUnitario') {
                $this->PrezzoUnitario = $child['value'];
            } elseif ($child['value'] instanceof ScontoMaggiorazione) {
                $this->ScontoMaggiorazione[] = $child['value'];
            } elseif ($child['name'] === '{}PrezzoTotale') {
                $this->PrezzoTotale = $child['value'];
            } elseif ($child['name'] === '{}AliquotaIVA') {
                $this->AliquotaIVA = $child['value'];
            } elseif ($child['name'] === '{}Ritenuta') {
                $this->Ritenuta = $child['value'];
            } elseif ($child['name'] === '{}Natura') {
                $this->Natura = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoAmministrazione') {
                $this->RiferimentoAmministrazione = $child['value'];
            } elseif ($child['value'] instanceof AltriDatiGestionali) {
                $this->AltriDatiGestionali[] = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->NumeroLinea ? $data['NumeroLinea'] = $this->NumeroLinea : null;
        $this->TipoCessionePrestazione ? $data['TipoCessionePrestazione'] = $this->Natura : null;
        if ($this->CodiceArticolo) {
            foreach ($this->CodiceArticolo as $CodiceArticolo) {
                $data[] = ['name' => 'CodiceArticolo', 'value' => $CodiceArticolo];
            }
        }
        $this->Descrizione ? $data['Descrizione'] = $this->Descrizione : null;
        $this->Quantita ? $data['Quantita'] = $this->Quantita : null;
        $this->UnitaMisura ? $data['UnitaMisura'] = $this->UnitaMisura : null;
        $this->DataInizioPeriodo ? $data['DataInizioPeriodo'] = $this->DataInizioPeriodo : null;
        $this->DataFinePeriodo ? $data['DataFinePeriodo'] = $this->DataFinePeriodo : null;
        $this->PrezzoUnitario ? $data['PrezzoUnitario'] = $this->PrezzoUnitario : null;
        if ($this->ScontoMaggiorazione) {
            foreach ($this->ScontoMaggiorazione as $ScontoMaggiorazione) {
                $data[] = ['name' => 'ScontoMaggiorazione', 'value' => $ScontoMaggiorazione];
            }
        }
        $this->PrezzoTotale ? $data['PrezzoTotale'] = $this->PrezzoTotale : null;
        $this->AliquotaIVA ? $data['AliquotaIVA'] = $this->AliquotaIVA : null;
        $this->Ritenuta ? $data['Ritenuta'] = $this->Ritenuta : null;
        $this->Natura ? $data['Natura'] = $this->Natura : null;
        $this->RiferimentoAmministrazione ? $data['RiferimentoAmministrazione'] = $this->RiferimentoAmministrazione : null;
        if ($this->AltriDatiGestionali) {
            foreach ($this->AltriDatiGestionali as $AltriDatigestionali) {
                $data[] = ['name' => 'AltriDatiGestionali', 'value' => $AltriDatigestionali];
            }
        }
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getNumeroLinea()
    {
        return $this->NumeroLinea;
    }

    /**
     * @param string $NumeroLinea
     * @return DettaglioLinee
     */
    public function setNumeroLinea($NumeroLinea)
    {
        if (strlen($NumeroLinea) > 4) {
            throw new InvalidValueException("NumeroLinea must be a string of maximum 4 characters");
        }
        $this->NumeroLinea = $NumeroLinea;
        return $this;
    }

    /**
     * @return string
     */
    public function getTipoCessionePrestazione()
    {
        return $this->TipoCessionePrestazione;
    }

    /**
     * @param string $TipoCessionePrestazione
     * @return DettaglioLinee
     */
    public function setTipoCessionePrestazione($TipoCessionePrestazione)
    {
        if (strlen($TipoCessionePrestazione) !== 2) {
            throw new InvalidValueException("TipoCessionePrestazione must be a string of 2 characters");
        }
        $this->TipoCessionePrestazione = $TipoCessionePrestazione;
        return $this;
    }

    /**
     * @return CodiceArticolo
     */
    public function getCodiceArticolo()
    {
        return $this->CodiceArticolo;
    }

    /**
     * @param CodiceArticolo $CodiceArticolo
     * @return DettaglioLinee
     */
    public function setCodiceArticolo($CodiceArticolo)
    {
        $this->CodiceArticolo = $CodiceArticolo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescrizione()
    {
        return $this->Descrizione;
    }

    /**
     * @param string $Descrizione
     * @return DettaglioLinee
     */
    public function setDescrizione($Descrizione)
    {
        if (strlen($Descrizione) > 1000) {
            throw new InvalidValueException("Descrizione must be a string of maximum 1000 characters");
        }
        $this->Descrizione = $Descrizione;
        return $this;
    }

    /**
     * @return string
     */
    public function getQuantita()
    {
        return $this->Quantita;
    }

    /**
     * @param string $Quantita
     * @return DettaglioLinee
     */
    public function setQuantita($Quantita)
    {
        if ((strlen($Quantita) < 4) || (strlen($Quantita) > 21)) {
            throw new InvalidValueException("Quantita must be a string between 4 and 21 characters");
        }
        $this->Quantita = $Quantita;
        return $this;
    }

    /**
     * @return string
     */
    public function getUnitaMisura()
    {
        return $this->UnitaMisura;
    }

    /**
     * @param string $UnitaMisura
     * @return DettaglioLinee
     */
    public function setUnitaMisura($UnitaMisura)
    {
        if (strlen($UnitaMisura) > 10) {
            throw new InvalidValueException("UnitaMisura must be a string of maximum 10 characters");
        }
        $this->UnitaMisura = $UnitaMisura;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataInizioPeriodo()
    {
        return $this->DataInizioPeriodo;
    }

    /**
     * @param string $DataInizioPeriodo
     * @return DettaglioLinee
     */
    public function setDataInizioPeriodo($DataInizioPeriodo)
    {
        if (strlen($DataInizioPeriodo) !== 10) {
            throw new InvalidValueException("DataInizioPeriodo must be a date string in the format YYYY-MM-DD");
        }
        $this->DataInizioPeriodo = $DataInizioPeriodo;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataFinePeriodo()
    {
        return $this->DataFinePeriodo;
    }

    /**
     * @param string $DataFinePeriodo
     * @return DettaglioLinee
     */
    public function setDataFinePeriodo($DataFinePeriodo)
    {
        if (strlen($DataFinePeriodo) !== 10) {
            throw new InvalidValueException("DataFinePeriodo must be a date string in the format YYYY-MM-DD");
        }
        $this->DataFinePeriodo = $DataFinePeriodo;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrezzoUnitario()
    {
        return $this->PrezzoUnitario;
    }

    /**
     * @param string $PrezzoUnitario
     * @return DettaglioLinee
     */
    public function setPrezzoUnitario($PrezzoUnitario)
    {
        if ((strlen($PrezzoUnitario) < 4) || (strlen($PrezzoUnitario) > 21)) {
            throw new InvalidValueException("PrezzoUnitario must be a string between 4 and 21 characters");
        }
        $this->PrezzoUnitario = $PrezzoUnitario;
        return $this;
    }

    /**
     * @return ScontoMaggiorazione
     */
    public function getScontoMaggiorazione()
    {
        return $this->ScontoMaggiorazione;
    }

    /**
     * @param ScontoMaggiorazione $ScontoMaggiorazione
     * @return DettaglioLinee
     */
    public function setScontoMaggiorazione($ScontoMaggiorazione)
    {
        $this->ScontoMaggiorazione = $ScontoMaggiorazione;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrezzoTotale()
    {
        return $this->PrezzoTotale;
    }

    /**
     * @param string $PrezzoTotale
     * @return DettaglioLinee
     */
    public function setPrezzoTotale($PrezzoTotale)
    {
        if ((strlen($PrezzoTotale) < 4) || (strlen($PrezzoTotale) > 21)) {
            throw new InvalidValueException("PrezzoTotale must be a string between 4 and 21 characters");
        }
        $this->PrezzoTotale = $PrezzoTotale;
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
     * @return DettaglioLinee
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
     * @return DettaglioLinee
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
     * @return DettaglioLinee
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
     * @return DettaglioLinee
     */
    public function setRiferimentoAmministrazione($RiferimentoAmministrazione)
    {
        if (strlen($RiferimentoAmministrazione) > 20) {
            throw new InvalidValueException("RiferimentoAmministrazione must be a string of maximum 20 characters");
        }
        $this->RiferimentoAmministrazione = $RiferimentoAmministrazione;
        return $this;
    }

    /**
     * @return AltriDatiGestionali[]
     */
    public function getAltriDatiGestionali()
    {
        return $this->AltriDatiGestionali;
    }

    /**
     * @param AltriDatiGestionali[] $AltriDatiGestionali
     * @return DettaglioLinee
     */
    public function setAltriDatiGestionali($AltriDatiGestionali)
    {
        $this->AltriDatiGestionali = $AltriDatiGestionali;
        return $this;
    }


}