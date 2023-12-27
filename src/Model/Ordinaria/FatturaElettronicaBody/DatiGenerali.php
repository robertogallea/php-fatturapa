<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:38
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;


use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiContratto;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiConvenzione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiDDT;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiFattureCollegate;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiOrdineAcquisto;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiRicezione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiSAL;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\FatturaPrincipale;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiGenerali implements XmlSerializable
{
    use Traversable;

    /** @var DatiGeneraliDocumento */
    protected $DatiGeneraliDocumento;

    /** @var DatiOrdineAcquisto[] */
    protected $DatiOrdineAcquisto;

    /** @var DatiContratto[] */
    protected $DatiContratto;

    /** @var DatiConvenzione[] */
    protected $DatiConvenzione;

    /** @var DatiRicezione[] */
    protected $DatiRicezione;

    /** @var DatiFattureCollegate[] */
    protected $DatiFattureCollegate;

    /** @var DatiSAL[] */
    protected $DatiSAL;

    /** @var DatiDDT[] */
    protected $DatiDDT;

    /** @var DatiTrasporto[] */
    protected $DatiTrasporto;

    /** @var FatturaPrincipale */
    protected $FatturaPrincipale;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof DatiGeneraliDocumento) {
                $this->DatiGeneraliDocumento = $child['value'];
            } elseif ($child['value'] instanceof DatiContratto) {
                $this->DatiContratto[] = $child['value'];
            } elseif ($child['value'] instanceof DatiConvenzione) {
                $this->DatiConvenzione[] = $child['value'];
            } elseif ($child['value'] instanceof DatiRicezione) {
                $this->DatiRicezione[] = $child['value'];
            } elseif ($child['value'] instanceof DatiFattureCollegate) {
                $this->DatiFattureCollegate[] = $child['value'];
            } elseif ($child['value'] instanceof DatiSAL) {
                $this->DatiSAL[] = $child['value'];
            } elseif ($child['value'] instanceof DatiDDT) {
                $this->DatiDDT[] = $child['value'];
            } elseif ($child['value'] instanceof DatiOrdineAcquisto) {
                $this->DatiOrdineAcquisto[] = $child['value'];
            } elseif ($child['value'] instanceof DatiTrasporto) {
                $this->DatiTrasporto[] = $child['value'];
            } elseif ($child['value'] instanceof FatturaPrincipale) {
                $this->FatturaPrincipale = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->DatiGeneraliDocumento ? $data['DatiGeneraliDocumento'] = $this->DatiGeneraliDocumento : null;
        if ($this->DatiOrdineAcquisto) {
            foreach ($this->DatiOrdineAcquisto as $DatiOrdineAcquisto) {
                $data[] = ['name' => 'DatiOrdineAcquisto', 'value' => $DatiOrdineAcquisto];
            }
        }
        if ($this->DatiContratto) {
            foreach ($this->DatiContratto as $DatiContratto) {
                $data[] = ['name' => 'DatiContratto', 'value' => $DatiContratto];
            }
        }
        if ($this->DatiConvenzione) {
            foreach ($this->DatiConvenzione as $DatiConvenzione) {
                $data[] = ['name' => 'DatiConvenzione', 'value' => $DatiConvenzione];
            }
        }
        if ($this->DatiRicezione) {
            foreach ($this->DatiRicezione as $DatiRicezione) {
                $data[] = ['name' => 'DatiRicezione', 'value' => $DatiRicezione];
            }
        }
        if ($this->DatiFattureCollegate) {
            foreach ($this->DatiFattureCollegate as $DatiFattureCollegate) {
                $data[] = ['name' => 'DatiFattureCollegate', 'value' => $DatiFattureCollegate];
            }
        }
        if ($this->DatiSAL) {
            foreach ($this->DatiSAL as $DatiSAL) {
                $data[] = ['name' => 'DatiSAL', 'value' => $DatiSAL];
            }
        }
        if ($this->DatiDDT) {
            foreach ($this->DatiDDT as $DatiDDT) {
                $data[] = ['name' => 'DatiDDT', 'value' => $DatiDDT];
            }
        }
        $this->DatiTrasporto ? $data['DatiTrasporto'] = $this->DatiTrasporto : null;
        $this->FatturaPrincipale ? $data['FatturaPrincipale'] = $this->FatturaPrincipale : null;
        $writer->write($data);
    }

    /**
     * @return DatiGeneraliDocumento
     */
    public function getDatiGeneraliDocumento()
    {
        return $this->DatiGeneraliDocumento;
    }

    /**
     * @param DatiGeneraliDocumento $DatiGeneraliDocumento
     * @return DatiGenerali
     */
    public function setDatiGeneraliDocumento($DatiGeneraliDocumento)
    {
        $this->DatiGeneraliDocumento = $DatiGeneraliDocumento;
        return $this;
    }

    /**
     * @return DatiOrdineAcquisto[]
     */
    public function getDatiOrdineAcquisto()
    {
        return $this->DatiOrdineAcquisto;
    }

    /**
     * @param DatiOrdineAcquisto[] $DatiOrdineAcquisto
     * @return DatiGenerali
     */
    public function setDatiOrdineAcquisto($DatiOrdineAcquisto)
    {
        $this->DatiOrdineAcquisto = $DatiOrdineAcquisto;
        return $this;
    }

    /**
     * @return DatiContratto[]
     */
    public function getDatiContratto()
    {
        return $this->DatiContratto;
    }

    /**
     * @param DatiContratto[] $DatiContratto
     * @return DatiGenerali
     */
    public function setDatiContratto($DatiContratto)
    {
        $this->DatiContratto = $DatiContratto;
        return $this;
    }

    /**
     * @return DatiConvenzione[]
     */
    public function getDatiConvenzione()
    {
        return $this->DatiConvenzione;
    }

    /**
     * @param DatiConvenzione[] $DatiConvenzione
     * @return DatiGenerali
     */
    public function setDatiConvenzione($DatiConvenzione)
    {
        $this->DatiConvenzione = $DatiConvenzione;
        return $this;
    }

    /**
     * @return DatiRicezione[]
     */
    public function getDatiRicezione()
    {
        return $this->DatiRicezione;
    }

    /**
     * @param DatiRicezione[] $DatiRicezione
     * @return DatiGenerali
     */
    public function setDatiRicezione($DatiRicezione)
    {
        $this->DatiRicezione = $DatiRicezione;
        return $this;
    }

    /**
     * @return DatiFattureCollegate[]
     */
    public function getDatiFattureCollegate()
    {
        return $this->DatiFattureCollegate;
    }

    /**
     * @param DatiFattureCollegate[] $DatiFattureCollegate
     * @return DatiGenerali
     */
    public function setDatiFattureCollegate($DatiFattureCollegate)
    {
        $this->DatiFattureCollegate = $DatiFattureCollegate;
        return $this;
    }

    /**
     * @return DatiSAL[]
     */
    public function getDatiSAL()
    {
        return $this->DatiSAL;
    }

    /**
     * @param DatiSAL[] $DatiSAL
     * @return DatiGenerali
     */
    public function setDatiSAL($DatiSAL)
    {
        $this->DatiSAL = $DatiSAL;
        return $this;
    }

    /**
     * @return DatiDDT[]
     */
    public function getDatiDDT()
    {
        return $this->DatiDDT;
    }

    /**
     * @param DatiDDT[] $DatiDDT
     * @return DatiGenerali
     */
    public function setDatiDDT($DatiDDT)
    {
        $this->DatiDDT = $DatiDDT;
        return $this;
    }

    /**
     * @return DatiTrasporto
     */
    public function getDatiTrasporto()
    {
        return $this->DatiTrasporto;
    }

    /**
     * @param DatiTrasporto $DatiTrasporto
     * @return DatiGenerali
     */
    public function setDatiTrasporto($DatiTrasporto)
    {
        $this->DatiTrasporto = $DatiTrasporto;
        return $this;
    }

    /**
     * @return FatturaPrincipale
     */
    public function getFatturaPrincipale()
    {
        return $this->FatturaPrincipale;
    }

    /**
     * @param FatturaPrincipale $FatturaPrincipale
     * @return DatiGenerali
     */
    public function setFatturaPrincipale($FatturaPrincipale)
    {
        $this->FatturaPrincipale = $FatturaPrincipale;
        return $this;
    }


}
