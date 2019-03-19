<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:30
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\Sede\Sede;
use Robertogallea\FatturaPA\Model\Common\StabileOrganizzazione;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;


class CedentePrestatore implements XmlSerializable
{
    use Traversable;

    /** @var DatiAnagrafici */
    protected $DatiAnagrafici;

    /** @var Sede */
    protected $Sede;

    /** @var StabileOrganizzazione */
    protected $StabileOrganizzazione;

    /** @var IscrizioneREA */
    protected $IscrizioneREA;

    /** @var Contatti */
    protected $Contatti;

    /** @var string */
    protected $RiferimentoAmministrazione;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof Contatti) {
                $this->Contatti = $child['value'];
            } elseif ($child['value'] instanceof DatiAnagrafici) {
                $this->DatiAnagrafici = $child['value'];
            } elseif ($child['value'] instanceof IscrizioneREA) {
                $this->IscrizioneREA = $child['value'];
            } elseif ($child['value'] instanceof Sede) {
                $this->Sede = $child['value'];
            } elseif ($child['value'] instanceof StabileOrganizzazione) {
                $this->StabileOrganizzazione = $child['value'];
            } elseif ($child['name'] === '{}RiferimentoAmministrazione') {
                $this->RiferimentoAmministrazione = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->DatiAnagrafici ? $data['DatiAnagrafici'] = $this->DatiAnagrafici : null;
        $this->Sede ? $data['Sede'] = $this->Sede : null;
        $this->StabileOrganizzazione ? $data['StabileOrganizzazione'] = $this->StabileOrganizzazione : null;
        $this->IscrizioneREA ? $data['IscrizioneREA'] = $this->IscrizioneREA : null;
        $this->Contatti ? $data['Contatti'] = $this->Contatti : null;
        $this->RiferimentoAmministrazione ? $data['RiferimentoAmministrazione'] = $this->RiferimentoAmministrazione : null;
        $writer->write($data);
    }

    /**
     * @return DatiAnagrafici
     */
    public function getDatiAnagrafici()
    {
        return $this->DatiAnagrafici;
    }

    /**
     * @param DatiAnagrafici $DatiAnagrafici
     * @return CedentePrestatore
     */
    public function setDatiAnagrafici($DatiAnagrafici)
    {
        $this->DatiAnagrafici = $DatiAnagrafici;
        return $this;
    }

    /**
     * @return Sede
     */
    public function getSede()
    {
        return $this->Sede;
    }

    /**
     * @param Sede $Sede
     * @return CedentePrestatore
     */
    public function setSede($Sede)
    {
        $this->Sede = $Sede;
        return $this;
    }

    /**
     * @return StabileOrganizzazione
     */
    public function getStabileOrganizzazione()
    {
        return $this->StabileOrganizzazione;
    }

    /**
     * @param StabileOrganizzazione $StabileOrganizzazione
     * @return CedentePrestatore
     */
    public function setStabileOrganizzazione($StabileOrganizzazione)
    {
        $this->StabileOrganizzazione = $StabileOrganizzazione;
        return $this;
    }

    /**
     * @return IscrizioneREA
     */
    public function getIscrizioneREA()
    {
        return $this->IscrizioneRea;
    }

    /**
     * @param IscrizioneREA $IscrizioneREA
     * @return CedentePrestatore
     */
    public function setIscrizioneREA($IscrizioneREA)
    {
        $this->IscrizioneREA = $IscrizioneREA;
        return $this;
    }

    /**
     * @return Contatti
     */
    public function getContatti()
    {
        return $this->Contatti;
    }

    /**
     * @param Contatti $Contatti
     * @return CedentePrestatore
     */
    public function setContatti($Contatti)
    {
        $this->Contatti = $Contatti;
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
     * @return CedentePrestatore
     */
    public function setRiferimentoAmministrazione($RiferimentoAmministrazione)
    {
        if (strlen($RiferimentoAmministrazione) > 20) {
            throw new InvalidValueException("RiferimentoAmministrazione must be a string of maximum 20 characters");
        }
        $this->RiferimentoAmministrazione = $RiferimentoAmministrazione;
        return $this;
    }
    
    
}