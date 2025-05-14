<?php

/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;


use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiBeniServizi implements XmlSerializable
{
    use Traversable;

    /** @var DettaglioLinee[] */
    protected $DettaglioLinee;

    /** @var DatiRiepilogo[] */
    protected $DatiRiepilogo;


    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['value'] instanceof  DettaglioLinee) {
                $this->DettaglioLinee[] = $child['value'];
            } elseif ($child['value'] instanceof  DatiRiepilogo) {
                $this->DatiRiepilogo[] = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        if ($this->DettaglioLinee) {
            foreach ($this->DettaglioLinee as $DettaglioLinee) {
                $data[] = ['name' => 'DettaglioLinee', 'value' => $DettaglioLinee];
            }
        }
        if ($this->DatiRiepilogo) {
            foreach ($this->DatiRiepilogo as $DatiRiepilogo) {
                $data[] = ['name' => 'DatiRiepilogo', 'value' => $DatiRiepilogo];
            }
        }

        $writer->write($data);
    }

    /**
     * @return DettaglioLinee[]
     */
    public function getDettaglioLinee()
    {
        return $this->DettaglioLinee;
    }

    /**
     * @param DettaglioLinee[] $DettaglioLinee
     * @return DatiBeniServizi
     */
    public function setDettaglioLinee($DettaglioLinee)
    {
        $this->DettaglioLinee = $DettaglioLinee;
        return $this;
    }

    /**
     * @return DatiRiepilogo[]
     */
    public function getDatiRiepilogo()
    {
        return $this->DatiRiepilogo;
    }

    /**
     * @param DatiRiepilogo[] $DatiRiepilogo
     * @return DatiBeniServizi
     */
    public function setDatiRiepilogo($DatiRiepilogo)
    {
        $this->DatiRiepilogo = $DatiRiepilogo;
        return $this;
    }
}
