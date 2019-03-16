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
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\FatturaElettronicaHeader;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\FatturaElettronicaBody;

class FatturaOrdinaria extends FatturaBase
{
    use Traversable;

    public $FatturaElettronicaHeader;
    public $FatturaElettronicaBody;

    private function traverse($reader)
    {
        if (FatturaBase::PRIVATI_12 === $reader->getAttribute('versione')) {
            $this->Versione = FatturaBase::PRIVATI_12;
        } elseif (FatturaBase::PUBBLICA_AMMINISTRAZIONE_12 === $reader->getAttribute('versione')) {
            $this->Versione = FatturaBase::PUBBLICA_AMMINISTRAZIONE_12;
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

}