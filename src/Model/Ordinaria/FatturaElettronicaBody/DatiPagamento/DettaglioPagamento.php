<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:39
 */

namespace Robertogallea\FatturaPA\Model\FatturaElettronicaBody\DatiPagamento;


use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;

class DettaglioPagamento
{
    use Traversable;

    public $Beneficiario;
    public $ModalitaPagamento;
    public $DataRiferimentoTerminiPagamento;
    public $GiorniTerminiPagamento;
    public $DataScadenzaPagamento;
    public $ImportoPagamento;
    public $CodUfficioPostale;
    public $CognomeQuietanzante;
    public $NomeQuietanzante;
    public $CFQuietanzante;
    public $TitoloQuientanzante;
    public $IstitutoBancario;
    public $IBAN;
    public $ABI;
    public $CAB;
    public $BIC;
    public $ScontoPagamentoAnticipato;
    public $DataLimitePagamentoAnticipato;
    public $PenalitaPagamentiRitardati;
    public $DataDecorrenzaPenale;
    public $CodicePagamento;

    private function traverse(Reader $reader)
    {
        $children = $reader->parseInnerTree();

        foreach($children as $child) {
            if ($child['name'] === '{}Beneficiario') {
                $this->Beneficiario = $child['value'];
            } elseif ($child['name'] === '{}ModalitaPagamento') {
                $this->ModalitaPagamento = $child['value'];
            } elseif ($child['name'] === '{}DataRiferimentoTerminiPagamento') {
                $this->DataRiferimentoTerminiPagamento = $child['value'];
            } elseif ($child['name'] === '{}GiorniTerminiPagamento') {
                $this->GiorniTerminiPagamento = $child['value'];
            } elseif ($child['name'] === '{}DataScadenzaPagamento') {
                $this->DataScadenzaPagamento = $child['value'];
            } elseif ($child['name'] === '{}ImportoPagamento') {
                $this->ImportoPagamento = $child['value'];
            } elseif ($child['name'] === '{}CodUfficioPostale') {
                $this->CodUfficioPostale = $child['value'];
            } elseif ($child['name'] === '{}CognomeQuietanzante') {
                $this->CognomeQuietanzante = $child['value'];
            } elseif ($child['name'] === '{}NomeQuietanzante') {
                $this->NomeQuietanzante = $child['value'];
            } elseif ($child['name'] === '{}CFQuietanzante') {
                $this->CFQuietanzante = $child['value'];
            } elseif ($child['name'] === '{}TitoloQuientanzante') {
                $this->TitoloQuientanzante = $child['value'];
            } elseif ($child['name'] === '{}IstitutoBancario') {
                $this->IstitutoBancario = $child['value'];
            } elseif ($child['name'] === '{}IBAN') {
                $this->IBAN = $child['value'];
            } elseif ($child['name'] === '{}ABI') {
                $this->ABI = $child['value'];
            } elseif ($child['name'] === '{}CAB') {
                $this->CAB = $child['value'];
            } elseif ($child['name'] === '{}BIC') {
                $this->BIC = $child['value'];
            } elseif ($child['name'] === '{}ScontoPagamentoAnticipato') {
                $this->ScontoPagamentoAnticipato = $child['value'];
            } elseif ($child['name'] === '{}DataLimitePagamentoAnticipato') {
                $this->DataLimitePagamentoAnticipato = $child['value'];
            } elseif ($child['name'] === '{}PenalitaPagamentiRitardati') {
                $this->PenalitaPagamentiRitardati = $child['value'];
            } elseif ($child['name'] === '{}DataDecorrenzaPenale') {
                $this->DataDecorrenzaPenale = $child['value'];
            } elseif ($child['name'] === '{}CodicePagamento') {
                $this->CodicePagamento = $child['value'];
            }
        }
    }
}