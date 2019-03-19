<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:35
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;


use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\Allegati\Allegati;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DatiBeniServizi;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGenerali;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiPagamento\DatiPagamento;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiVeicoli\DatiVeicoli;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class FatturaElettronicaBody implements XmlSerializable
{
    use Traversable;

    /** @var DatiGenerali */
    protected $DatiGenerali;

    /** @var DatiBeniServizi */
    protected $DatiBeniServizi;

    /** @var DatiVeicoli */
    protected $DatiVeicoli;

    /** @var DatiPagamento[] */
    protected $DatiPagamento;

    /** @var Allegati[] */
    protected $Allegati;



    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof DatiGenerali) {
                $this->DatiGenerali = $child['value'];
            } elseif ($child['value'] instanceof DatiBeniServizi) {
                $this->DatiBeniServizi = $child['value'];
            } elseif ($child['value'] instanceof DatiVeicoli) {
                $this->DatiVeicoli = $child['value'];
            } elseif ($child['value'] instanceof DatiPagamento) {
                $this->DatiPagamento[] = $child['value'];
            } elseif ($child['value'] instanceof Allegati) {
                $this->Allegati[] = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->DatiGenerali ? $data['DatiGenerali'] = $this->DatiGenerali : null;
        $this->DatiBeniServizi? $data['DatiBeniServizi'] = $this->DatiBeniServizi : null;
        $this->DatiVeicoli ? $data['DatiVeicoli'] = $this->DatiVeicoli : null;
        $this->DatiPagamento ? $data['DatiPagamento'] = $this->DatiPagamento : null;
        $this->Allegati ? $data['Allegati'] = $this->Allegati : null;
        $writer->write($data);
    }

    /**
     * @return DatiGenerali
     */
    public function getDatiGenerali()
    {
        return $this->DatiGenerali;
    }

    /**
     * @param DatiGenerali $DatiGenerali
     * @return FatturaElettronicaBody
     */
    public function setDatiGenerali($DatiGenerali)
    {
        $this->DatiGenerali = $DatiGenerali;
        return $this;
    }

    /**
     * @return DatiBeniServizi
     */
    public function getDatiBeniServizi()
    {
        return $this->DatiBeniServizi;
    }

    /**
     * @param DatiBeniServizi $DatiBeniServizi
     * @return FatturaElettronicaBody
     */
    public function setDatiBeniServizi($DatiBeniServizi)
    {
        $this->DatiBeniServizi = $DatiBeniServizi;
        return $this;
    }

    /**
     * @return DatiVeicoli
     */
    public function getDatiVeicoli()
    {
        return $this->DatiVeicoli;
    }

    /**
     * @param DatiVeicoli $DatiVeicoli
     * @return FatturaElettronicaBody
     */
    public function setDatiVeicoli($DatiVeicoli)
    {
        $this->DatiVeicoli = $DatiVeicoli;
        return $this;
    }

    /**
     * @return DatiPagamento[]
     */
    public function getDatiPagamento()
    {
        return $this->DatiPagamento;
    }

    /**
     * @param DatiPagamento[] $DatiPagamento
     * @return FatturaElettronicaBody
     */
    public function setDatiPagamento($DatiPagamento)
    {
        $this->DatiPagamento = $DatiPagamento;
        return $this;
    }

    /**
     * @return Allegati[]
     */
    public function getAllegati()
    {
        return $this->Allegati;
    }

    /**
     * @param Allegati[] $Allegati
     * @return FatturaElettronicaBody
     */
    public function setAllegati($Allegati)
    {
        $this->Allegati = $Allegati;
        return $this;
    }

    /**
     * @param Allegati $allegati
     * @return FatturaElettronicaBody
     */
    public function addAllegato($allegati)
    {
        $this->Allegati[] = $allegati;
        return $this;
    }

    public function esportaAllegati($location)
    {
        if ($this->Allegati) {
            foreach ($this->Allegati as $allegato) {
                $allegato->saveToFile($location);
            }
        }
    }

}