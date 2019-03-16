<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:33
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\RappresentanteFiscale;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class RappresentanteFiscale
{
    use Traversable;

    public $DatiAnagrafici;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof DatiAnagrafici) {
                $this->DatiAnagrafici = $child['value'];
            }
        }
    }
}