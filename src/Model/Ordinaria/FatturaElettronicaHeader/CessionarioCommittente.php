<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:31
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader;


use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\Sede;
use Robertogallea\FatturaPA\Model\Common\StabileOrganizzazione;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class CessionarioCommittente implements XmlSerializable
{
    use Traversable;

    /** @var DatiAnagrafici */
    protected $DatiAnagrafici;

    /** @var RappresentanteFiscale */
    protected $RappresentanteFiscale;

    /** @var StabileOrganizzazione */
    protected $StabileOrganizzazione;

    /** @var Sede */
    protected $Sede;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof DatiAnagrafici) {
                $this->DatiAnagrafici = $child['value'];
            } elseif ($child['value'] instanceof Sede) {
                $this->Sede = $child['value'];
            } elseif ($child['value'] instanceof RappresentanteFiscale) {
                $this->RappresentanteFiscale = $child['value'];
            } elseif ($child['value'] instanceof StabileOrganizzazione) {
                $this->StabileOrganizzazione = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->DatiAnagrafici ? $data['DatiAnagrafici'] = $this->DatiAnagrafici : null;
        $this->RappresentanteFiscale ? $data['RappresentanteFiscale'] = $this->RappresentanteFiscale : null;
        $this->StabileOrganizzazione ? $data['StabileOrganizzazione'] = $this->StabileOrganizzazione : null;
        $this->Sede ? $data['Sede'] = $this->Sede : null;
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
     * @return CessionarioCommittente
     */
    public function setDatiAnagrafici($DatiAnagrafici)
    {
        $this->DatiAnagrafici = $DatiAnagrafici;
        return $this;
    }

    /**
     * @return RappresentanteFiscale
     */
    public function getRappresentanteFiscale()
    {
        return $this->RappresentanteFiscale;
    }

    /**
     * @param RappresentanteFiscale $RappresentanteFiscale
     * @return CessionarioCommittente
     */
    public function setRappresentanteFiscale($RappresentanteFiscale)
    {
        $this->RappresentanteFiscale = $RappresentanteFiscale;
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
     * @return CessionarioCommittente
     */
    public function setStabileOrganizzazione($StabileOrganizzazione)
    {
        $this->StabileOrganizzazione = $StabileOrganizzazione;
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
     * @return CessionarioCommittente
     */
    public function setSede($Sede)
    {
        $this->Sede = $Sede;
        return $this;
    }


}