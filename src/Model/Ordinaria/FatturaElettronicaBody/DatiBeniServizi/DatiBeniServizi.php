<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:36
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiBeniServizi;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DatiBeniServizi
{
    use Traversable;

    public $DettaglioLinee;
    public $DatiRiepilogo;


    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof  DettaglioLinee) {
                $this->DettaglioLinee[] = $child['value'];
            } elseif ($child['value'] instanceof  DatiRiepilogo) {
                $this->DatiRiepilogo[] = $child['value'];
            }
        }
    }
}