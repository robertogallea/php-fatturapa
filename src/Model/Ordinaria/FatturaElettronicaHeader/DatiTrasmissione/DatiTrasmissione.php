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

class DatiTrasmissione
{
    use Traversable;

    public $IdTrasmittente;
    public $ProgressivoInvio;
    public $FormatoTrasmissione;
    public $CodiceDestinatario;
    public $PECDestinatario;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof IdTrasmittente) {
                $this->IdTrasmittente = $child['value'];
            } elseif ($child['name'] === '{}ProgressivoInvio') {
                $this->ProgressivoInvio = $child['value'];
            } elseif ($child['name'] === '{}FormatoTrasmissione') {
                $this->FormatoTrasmissione = $child['value'];
            } elseif ($child['name'] === '{}CodiceDestinatario') {
                $this->CodiceDestinatario = $child['value'];
            } elseif ($child['name'] === '{}PECDestinatario') {
                $this->PECDestinatario = $child['value'];
            }
        }
    }
}