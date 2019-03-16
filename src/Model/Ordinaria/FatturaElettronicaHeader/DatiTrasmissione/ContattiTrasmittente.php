<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:32
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class ContattiTrasmittente
{
    use Traversable;

    public $Telefono;
    public $Email;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Telefono') {
                $this->Telefono = $child['value'];
            } elseif ($child['name'] === '{}Email') {
                $this->Email = $child['value'];
            }
        }
    }
}