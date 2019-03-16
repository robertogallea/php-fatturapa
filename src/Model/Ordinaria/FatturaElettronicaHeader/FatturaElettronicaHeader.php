<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:35
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader;



use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore\CedentePrestatore;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CessionarioCommittente\CessionarioCommittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione\DatiTrasmissione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\RappresentanteFiscale\RappresentanteFiscale;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\TerzoIntermediarioOSoggettoEmittente\TerzoIntermediarioOSoggettoEmittente;
use Robertogallea\FatturaPA\Traits\Traversable;

class FatturaElettronicaHeader
{
    use Traversable;

    public $CedentePrestatore;
    public $CessionarioCommittemte;
    public $DatiTrasmissione;
    public $RappresentateFiscale;
    public $TerzoIntermediarioOSoggettoEmittente;

    private function traverse($reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['value'] instanceof CedentePrestatore) {
                $this->CedentePrestatore = $child['value'];
            } elseif ($child['value'] instanceof CessionarioCommittente) {
                $this->CessionarioCommittemte = $child['value'];
            } elseif ($child['value'] instanceof DatiTrasmissione) {
                $this->DatiTrasmissione = $child['value'];
            } elseif ($child['value'] instanceof RappresentanteFiscale) {
                $this->CessionarioCommittemte = $child['value'];
            } elseif ($child['value'] instanceof TerzoIntermediarioOSoggettoEmittente) {
                $this->TerzoIntermediarioOSoggettoEmittente = $child['value'];
            }
        }
    }
}