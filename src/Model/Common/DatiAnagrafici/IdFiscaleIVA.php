<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 15/03/2019
 * Time: 09:23
 */

namespace Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class IdFiscaleIVA
{
    use Traversable;

    public $IdPaese;
    public $IdCodice;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach ($children as $child) {
            if ($child['name'] === '{}IdPaese') {
                $this->IdPaese = $child['value'];
            } elseif ($child['name'] === '{}IdCodice') {
                $this->IdCodice = $child['value'];
            }
        }

    }

}