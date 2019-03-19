<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:33
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\RappresentanteFiscale;


use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\DatiAnagrafici;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class RappresentanteFiscale implements XmlSerializable
{
    use Traversable;

    /** @var DatiAnagrafici */
    protected $DatiAnagrafici;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof DatiAnagrafici) {
                $this->DatiAnagrafici = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->DatiAnagrafici ? $data['DatiAnagrafici'] = $this->DatiAnagrafici : null;
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
     * @return RappresentanteFiscale
     */
    public function setDatiAnagrafici($DatiAnagrafici)
    {
        $this->DatiAnagrafici = $DatiAnagrafici;
        return $this;
    }


}