<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:35
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\Allegati;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class Allegati
{
    use Traversable;

    public $NomeAttachment;
    public $AlgoritmoCompressione;
    public $FormatoAttachment;
    public $DescrizioneAttachment;
    public $Attachment;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}NomeAttachment') {
                $this->NomeAttachment = $child['value'];
            } elseif ($child['name'] === '{}AlgoritmoCompressione') {
                $this->AlgoritmoCompressione = $child['value'];
            } elseif ($child['name'] === '{}FormatoAttachment') {
                $this->FormatoAttachment = $child['value'];
            } elseif ($child['name'] === '{}DescrizioneAttachment') {
                $this->DescrizioneAttachment = $child['value'];
            } elseif ($child['name'] === '{}Attachment') {
                $this->Attachment = $child['value'];
            }
        }
    }
}