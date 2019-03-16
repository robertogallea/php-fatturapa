<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:30
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class Contatti
{
    use Traversable;

    public $Telefono;
    public $Email;
    public $Fax;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Telefono') {
                $this->Telefono = $child['value'];
            } elseif ($child['name'] === '{}Email') {
                $this->Email = $child['value'];
            } elseif ($child['name'] === '{}Fax') {
                $this->Fax = $child['value'];
            }
        }
    }


}