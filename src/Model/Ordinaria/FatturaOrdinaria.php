<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:41
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria;


use Robertogallea\FatturaPA\Exceptions\UnknownFatturaElettronicaVersionException;
use \Robertogallea\FatturaPA\Traits\Traversable;
use Robertogallea\FatturaPA\Model\FatturaBase;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;
use Sabre\Xml\Writer;

class FatturaOrdinaria extends FatturaBase
{
    use Traversable;

    /** @var FatturaElettronicaHeader */
    protected $FatturaElettronicaHeader;

    /** @var FatturaElettronicaBody[] */
    protected $FatturaElettronicaBody;

    private function traverse($reader)
    {
        if (FatturaBase::PRIVATI_12 === $reader->getAttribute('versione')) {
            $this->versione = FatturaBase::PRIVATI_12;
        } elseif (FatturaBase::PUBBLICA_AMMINISTRAZIONE_12 === $reader->getAttribute('versione')) {
            $this->versione = FatturaBase::PUBBLICA_AMMINISTRAZIONE_12;
        } else {
            throw new UnknownFatturaElettronicaVersionException('Formato fattura sconosciuto: ' . $reader->getAttribute('versione'));
        }

        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof FatturaElettronicaHeader) {
                $this->FatturaElettronicaHeader = $child['value'];
            } elseif ($child['value'] instanceof FatturaElettronicaBody) {
                $this->FatturaElettronicaBody[] = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $ns = '{http://ivaservizi.agenziaentrate.gov.it/docs/xsd/fatture/v1.2}';

        $data = array();
        $this->FatturaElettronicaHeader ? $data['FatturaElettronicaHeader'] = $this->FatturaElettronicaHeader : null;
        if ($this->FatturaElettronicaBody) {
            foreach ($this->FatturaElettronicaBody as $FatturaElettronicaBody) {
                $data[] = ['name' => 'FatturaElettronicaBody', 'value' => $FatturaElettronicaBody];
            }
        }
        $writer->write($data);
    }

    /**
     * @return FatturaElettronicaHeader
     */
    public function getFatturaElettronicaHeader()
    {
        return $this->FatturaElettronicaHeader;
    }

    /**
     * @param FatturaElettronicaHeader $FatturaElettronicaHeader
     * @return FatturaOrdinaria
     */
    public function setFatturaElettronicaHeader($FatturaElettronicaHeader)
    {
        $this->FatturaElettronicaHeader = $FatturaElettronicaHeader;
        return $this;
    }

    /**
     * @return FatturaElettronicaBody[]
     */
    public function getFatturaElettronicaBody()
    {
        return $this->FatturaElettronicaBody;
    }

    /**
     * @param FatturaElettronicaBody[] $FatturaElettronicaBody
     * @return FatturaOrdinaria
     */
    public function setFatturaElettronicaBody($FatturaElettronicaBody)
    {
        $this->FatturaElettronicaBody = $FatturaElettronicaBody;
        return $this;
    }

}