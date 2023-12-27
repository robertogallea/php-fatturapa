<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:39
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiPagamento;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DettaglioPagamento implements XmlSerializable
{
    use Traversable;

    /** @var string */
    protected $Beneficiario;

    /** @var string */
    protected $ModalitaPagamento;

    /** @var string */
    protected $DataRiferimentoTerminiPagamento;

    /** @var string */
    protected $GiorniTerminiPagamento;

    /** @var string */
    protected $DataScadenzaPagamento;

    /** @var string */
    protected $ImportoPagamento;

    /** @var string */
    protected $CodUfficioPostale;

    /** @var string */
    protected $CognomeQuietanzante;

    /** @var string */
    protected $NomeQuietanzante;

    /** @var string */
    protected $CFQuietanzante;

    /** @var string */
    protected $TitoloQuientanzante;

    /** @var string */
    protected $IstitutoBancario;

    /** @var string */
    protected $IBAN;

    /** @var string */
    protected $ABI;

    /** @var string */
    protected $CAB;

    /** @var string */
    protected $BIC;

    /** @var string */
    protected $ScontoPagamentoAnticipato;

    /** @var string */
    protected $DataLimitePagamentoAnticipato;

    /** @var string */
    protected $PenalitaPagamentiRitardati;

    /** @var string */
    protected $DataDecorrenzaPenale;

    /** @var string */
    protected $CodicePagamento;

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

    function xmlSerialize(Writer $writer): void
    {
        $data = array();
        $this->Beneficiario ? $data['Beneficiario'] = $this->Beneficiario : null;
        $this->ModalitaPagamento ? $data['ModalitaPagamento'] = $this->ModalitaPagamento : null;
        $this->DataRiferimentoTerminiPagamento ? $data['DataRiferimentoTerminiPagamento'] = $this->DataRiferimentoTerminiPagamento : null;
        $this->GiorniTerminiPagamento ? $data['GiorniTerminiPagamento'] = $this->GiorniTerminiPagamento : null;
        $this->DataScadenzaPagamento ? $data['DataScadenzaPagamento'] = $this->DataScadenzaPagamento : null;
        $this->ImportoPagamento ? $data['ImportoPagamento'] = $this->ImportoPagamento : null;
        $this->CodUfficioPostale ? $data['CodUfficioPostale'] = $this->CodUfficioPostale : null;
        $this->CognomeQuietanzante ? $data['CognomeQuietanzante'] = $this->CognomeQuietanzante : null;
        $this->NomeQuietanzante ? $data['NomeQuietanzante'] = $this->NomeQuietanzante : null;
        $this->CFQuietanzante ? $data['CFQuietanzante'] = $this->CFQuietanzante : null;
        $this->TitoloQuientanzante ? $data['TitoloQuientanzante'] = $this->TitoloQuientanzante : null;
        $this->IstitutoBancario ? $data['IstitutoBancario'] = $this->IstitutoBancario : null;
        $this->IBAN ? $data['IBAN'] = $this->IBAN : null;
        $this->ABI ? $data['ABI'] = $this->ABI : null;
        $this->CAB ? $data['CAB'] = $this->CAB : null;
        $this->BIC ? $data['BIC'] = $this->BIC : null;
        $this->ScontoPagamentoAnticipato ? $data['ScontoPagamentoAnticipato'] = $this->ScontoPagamentoAnticipato : null;
        $this->DataLimitePagamentoAnticipato ? $data['DataLimitePagamentoAnticipato'] = $this->DataLimitePagamentoAnticipato : null;
        $this->PenalitaPagamentiRitardati ? $data['PenalitaPagamentiRitardati'] = $this->PenalitaPagamentiRitardati : null;
        $this->DataDecorrenzaPenale ? $data['DataDecorrenzaPenale'] = $this->DataDecorrenzaPenale : null;
        $this->CodicePagamento ? $data['CodicePagamento'] = $this->CodicePagamento : null;
        $writer->write($data);
    }

    /**
     * @return string
     */
    public function getBeneficiario()
    {
        return $this->Beneficiario;
    }

    /**
     * @param string $Beneficiario
     * @return DettaglioPagamento
     */
    public function setBeneficiario($Beneficiario)
    {
        if (strlen($Beneficiario) > 100) {
            throw new InvalidValueException("Beneficiario must be a string of maximum 100 characters");
        }
        $this->Beneficiario = $Beneficiario;
        return $this;
    }

    /**
     * @return string
     */
    public function getModalitaPagamento()
    {
        return $this->ModalitaPagamento;
    }

    /**
     * @param string $ModalitaPagamento
     * @return DettaglioPagamento
     */
    public function setModalitaPagamento($ModalitaPagamento)
    {
        if (strlen($ModalitaPagamento) !== 4) {
            throw new InvalidValueException("ModalitaPagamento must be a string of 4 characters");
        }
        $this->ModalitaPagamento = $ModalitaPagamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataRiferimentoTerminiPagamento()
    {
        return $this->DataRiferimentoTerminiPagamento;
    }

    /**
     * @param string $DataRiferimentoTerminiPagamento
     * @return DettaglioPagamento
     */
    public function setDataRiferimentoTerminiPagamento($DataRiferimentoTerminiPagamento)
    {
        if (strlen($DataRiferimentoTerminiPagamento) !== 10) {
            throw new InvalidValueException("DataRiferimentoTerminiPagamento must be a date string in the format YYYY-MM-DD");
        }
        $this->DataRiferimentoTerminiPagamento = $DataRiferimentoTerminiPagamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getGiorniTerminiPagamento()
    {
        return $this->GiorniTerminiPagamento;
    }

    /**
     * @param string $GiorniTerminiPagamento
     * @return DettaglioPagamento
     */
    public function setGiorniTerminiPagamento($GiorniTerminiPagamento)
    {
        if (strlen($GiorniTerminiPagamento) > 3) {
            throw new InvalidValueException("GiorniTerminiPagamento must be a string of maximum 3 characters");
        }
        $this->GiorniTerminiPagamento = $GiorniTerminiPagamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataScadenzaPagamento()
    {
        return $this->DataScadenzaPagamento;
    }

    /**
     * @param string $DataScadenzaPagamento
     * @return DettaglioPagamento
     */
    public function setDataScadenzaPagamento($DataScadenzaPagamento)
    {
        if (strlen($DataScadenzaPagamento) !== 10) {
            throw new InvalidValueException("DataScadenzaPagamento must be a date string in the format YYYY-MM-DD");
        }
        $this->DataScadenzaPagamento = $DataScadenzaPagamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getImportoPagamento()
    {
        return $this->ImportoPagamento;
    }

    /**
     * @param string $ImportoPagamento
     * @return DettaglioPagamento
     */
    public function setImportoPagamento($ImportoPagamento)
    {
        if ((strlen($ImportoPagamento) < 4) || (strlen($ImportoPagamento) > 15)) {
            throw new InvalidValueException("ImportoPagamento must be a string between 4 and 15 characters");
        }
        $this->ImportoPagamento = $ImportoPagamento;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodUfficioPostale()
    {
        return $this->CodUfficioPostale;
    }

    /**
     * @param string $CodUfficioPostale
     * @return DettaglioPagamento
     */
    public function setCodUfficioPostale($CodUfficioPostale)
    {
        if (strlen($CodUfficioPostale) > 20) {
            throw new InvalidValueException("CodUfficioPostale must be a string of maximum 20 characters");
        }
        $this->CodUfficioPostale = $CodUfficioPostale;
        return $this;
    }

    /**
     * @return string
     */
    public function getCognomeQuietanzante()
    {
        return $this->CognomeQuietanzante;
    }

    /**
     * @param string $CognomeQuietanzante
     * @return DettaglioPagamento
     */
    public function setCognomeQuietanzante($CognomeQuietanzante)
    {
        if (strlen($CognomeQuietanzante) > 60) {
            throw new InvalidValueException("CognomeQuietanzante must be a string of maximum 60 characters");
        }
        $this->CognomeQuietanzante = $CognomeQuietanzante;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomeQuietanzante()
    {
        return $this->NomeQuietanzante;
    }

    /**
     * @param string $NomeQuietanzante
     * @return DettaglioPagamento
     */
    public function setNomeQuietanzante($NomeQuietanzante)
    {
        if (strlen($NomeQuietanzante) > 60) {
            throw new InvalidValueException("NomeQuietanzante must be a string of maximum 60 characters");
        }
        $this->NomeQuietanzante = $NomeQuietanzante;
        return $this;
    }

    /**
     * @return string
     */
    public function getCFQuietanzante()
    {
        return $this->CFQuietanzante;
    }

    /**
     * @param string $CFQuietanzante
     * @return DettaglioPagamento
     */
    public function setCFQuietanzante($CFQuietanzante)
    {
        if (strlen($CFQuietanzante) !== 16) {
            throw new InvalidValueException("CFQuietanzante must be a string of 16 characters");
        }
        $this->CFQuietanzante = $CFQuietanzante;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitoloQuientanzante()
    {
        return $this->TitoloQuientanzante;
    }

    /**
     * @param string $TitoloQuientanzante
     * @return DettaglioPagamento
     */
    public function setTitoloQuientanzante($TitoloQuientanzante)
    {
        if ((strlen($TitoloQuientanzante) < 2) || (strlen($TitoloQuientanzante) > 10)) {
            throw new InvalidValueException("TitoloQuietanzante must be a string between 2 and 10 characters");
        }
        $this->TitoloQuientanzante = $TitoloQuientanzante;
        return $this;
    }

    /**
     * @return string
     */
    public function getIstitutoBancario()
    {
        return $this->IstitutoBancario;
    }

    /**
     * @param string $IstitutoBancario
     * @return DettaglioPagamento
     */
    public function setIstitutoBancario($IstitutoBancario)
    {
        if (strlen($IstitutoBancario) > 80) {
            throw new InvalidValueException("IstitutoBancario must be a string of maximum 80 characters");
        }
        $this->IstitutoBancario = $IstitutoBancario;
        return $this;
    }

    /**
     * @return string
     */
    public function getIBAN()
    {
        return $this->IBAN;
    }

    /**
     * @param string $IBAN
     * @return DettaglioPagamento
     */
    public function setIBAN($IBAN)
    {
        if ((strlen($IBAN) < 15) || (strlen($IBAN) > 34)) {
            throw new InvalidValueException("IBAN must be a string between 15 and 34 characters");
        }
        $this->IBAN = $IBAN;
        return $this;
    }

    /**
     * @return string
     */
    public function getABI()
    {
        return $this->ABI;
    }

    /**
     * @param string $ABI
     * @return DettaglioPagamento
     */
    public function setABI($ABI)
    {
        if (strlen($ABI) !== 5) {
            throw new InvalidValueException("ABI must be a string of 5 characters");
        }
        $this->ABI = $ABI;
        return $this;
    }

    /**
     * @return string
     */
    public function getCAB()
    {
        return $this->CAB;
    }

    /**
     * @param string $CAB
     * @return DettaglioPagamento
     */
    public function setCAB($CAB)
    {
        if (strlen($CAB) !== 5) {
            throw new InvalidValueException("CAB must be a string of 5 characters");
        }
        $this->CAB = $CAB;
        return $this;
    }

    /**
     * @return string
     */
    public function getBIC()
    {
        return $this->BIC;
    }

    /**
     * @param string $BIC
     * @return DettaglioPagamento
     */
    public function setBIC($BIC)
    {
        if ((strlen($BIC) < 8) || (strlen($BIC) > 11)) {
            throw new InvalidValueException("BIC must be a string between 8 and 11 characters");
        }
        $this->BIC = $BIC;
        return $this;
    }

    /**
     * @return string
     */
    public function getScontoPagamentoAnticipato()
    {
        return $this->ScontoPagamentoAnticipato;
    }

    /**
     * @param string $ScontoPagamentoAnticipato
     * @return DettaglioPagamento
     */
    public function setScontoPagamentoAnticipato($ScontoPagamentoAnticipato)
    {
        if ((strlen($ScontoPagamentoAnticipato) < 4) || (strlen($ScontoPagamentoAnticipato) > 11)) {
            throw new InvalidValueException("ScontoPagamentoAnticipato must be a string between 4 and 11 characters");
        }
        $this->ScontoPagamentoAnticipato = $ScontoPagamentoAnticipato;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataLimitePagamentoAnticipato()
    {
        return $this->DataLimitePagamentoAnticipato;
    }

    /**
     * @param string $DataLimitePagamentoAnticipato
     * @return DettaglioPagamento
     */
    public function setDataLimitePagamentoAnticipato($DataLimitePagamentoAnticipato)
    {
        if (strlen($DataLimitePagamentoAnticipato) !== 10) {
            throw new InvalidValueException("DataLimitePagamentoAnticipato must be a date string in the format YYYY-MM-DD");
        }
        $this->DataLimitePagamentoAnticipato = $DataLimitePagamentoAnticipato;
        return $this;
    }

    /**
     * @return string
     */
    public function getPenalitaPagamentiRitardati()
    {
        return $this->PenalitaPagamentiRitardati;
    }

    /**
     * @param string $PenalitaPagamentiRitardati
     * @return DettaglioPagamento
     */
    public function setPenalitaPagamentiRitardati($PenalitaPagamentiRitardati)
    {
        if ((strlen($PenalitaPagamentiRitardati) < 4) || (strlen($PenalitaPagamentiRitardati) > 15)) {
            throw new InvalidValueException("PenalitaPagamentiRitardati must be a string between 4 and 15 characters");
        }
        $this->PenalitaPagamentiRitardati = $PenalitaPagamentiRitardati;
        return $this;
    }

    /**
     * @return string
     */
    public function getDataDecorrenzaPenale()
    {
        return $this->DataDecorrenzaPenale;
    }

    /**
     * @param string $DataDecorrenzaPenale
     * @return DettaglioPagamento
     */
    public function setDataDecorrenzaPenale($DataDecorrenzaPenale)
    {
        if (strlen($DataDecorrenzaPenale) !== 10) {
            throw new InvalidValueException("DataDecorrenzaPenale must be a date string in the format YYYY-MM-DD");
        }
        $this->DataDecorrenzaPenale = $DataDecorrenzaPenale;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodicePagamento()
    {
        return $this->CodicePagamento;
    }

    /**
     * @param string $CodicePagamento
     * @return DettaglioPagamento
     */
    public function setCodicePagamento($CodicePagamento)
    {
        if (strlen($CodicePagamento) > 60) {
            throw new InvalidValueException("CodicePagamento must be a string of maximum 60 characters");
        }
        $this->CodicePagamento = $CodicePagamento;
        return $this;
    }


}
