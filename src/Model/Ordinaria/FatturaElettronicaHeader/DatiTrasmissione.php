<?php
/**
 * Created by PhpStorm.
 * User: Roberto Gallea
 * Date: 14/03/2019
 * Time: 21:32
 */

namespace Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader;


use Robertogallea\FatturaPA\Exceptions\InvalidValueException;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione\ContattiTrasmittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione\IdTrasmittente;
use Robertogallea\FatturaPA\Traits\Traversable;
use Sabre\Xml\Reader;
use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class DatiTrasmissione implements XmlSerializable
{
    use Traversable;

    /** @var IdTrasmittente */
    protected $IdTrasmittente;

    /** @var string */
    protected $ProgressivoInvio;

    /** @var string */
    protected $FormatoTrasmissione;

    /** @var string */
    protected $CodiceDestinatario;

    /** var ContattiTrasmittente */
    protected $ContattiTrasmittente;

    /** @var string */
    protected $PECDestinatario;

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
            } elseif ($child['value'] instanceof ContattiTrasmittente) {
                $this->ContattiTrasmittente = $child['value'];
            } elseif ($child['name'] === '{}PECDestinatario') {
                $this->PECDestinatario = $child['value'];
            }
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $data = array();
        $this->IdTrasmittente ? $data['IdTrasmittente'] = $this->IdTrasmittente : null;
        $this->ProgressivoInvio ? $data['ProgressivoInvio'] = $this->ProgressivoInvio : null;
        $this->FormatoTrasmissione ? $data['FormatoTrasmissione'] = $this->FormatoTrasmissione : null;
        $this->CodiceDestinatario ? $data['CodiceDestinatario'] = $this->CodiceDestinatario : null;
        $this->ContattiTrasmittente ? $data['ContattiTrasmittente'] = $this->ContattiTrasmittente : null;
        $this->PECDestinatario ? $data['PECDestinatario'] = $this->PECDestinatario : null;
        $writer->write($data);
    }

    /**
     * @return IdTrasmittente
     */
    public function getIdTrasmittente()
    {
        return $this->IdTrasmittente;
    }

    /**
     * @param IdTrasmittente $IdTrasmittente
     * @return DatiTrasmissione
     */
    public function setIdTrasmittente($IdTrasmittente)
    {
        $this->IdTrasmittente = $IdTrasmittente;
        return $this;
    }

    /**
     * @return string
     */
    public function getProgressivoInvio()
    {
        return $this->ProgressivoInvio;
    }

    /**
     * @param string $ProgressivoInvio
     * @return DatiTrasmissione
     */
    public function setProgressivoInvio($ProgressivoInvio)
    {
        if (strlen($ProgressivoInvio) > 10) {
            throw new InvalidValueException("ProgressivoInvio must be a string of maximum 10 characters");
        }
        $this->ProgressivoInvio = $ProgressivoInvio;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormatoTrasmissione()
    {
        return $this->FormatoTrasmissione;
    }

    /**
     * @param string $FormatoTrasmissione
     * @return DatiTrasmissione
     */
    public function setFormatoTrasmissione($FormatoTrasmissione)
    {
        if (!in_array($FormatoTrasmissione , array('FPA12','FPR12'))) {
            throw new InvalidValueException("FormatoTrasmissione must be a 'FPA12' or 'FPR12'");
        }
        $this->FormatoTrasmissione = $FormatoTrasmissione;
        return $this;
    }

    /**
     * @return string
     */
    public function getCodiceDestinatario()
    {
        return $this->CodiceDestinatario;
    }

    /**
     * @param string $CodiceDestinatario
     * @return DatiTrasmissione
     */
    public function setCodiceDestinatario($CodiceDestinatario)
    {
        if (($this->FormatoTrasmissione) && ($this->FormatoTrasmissione == 'FPA12') && (strlen($CodiceDestinatario) !== 6)) {
            throw new InvalidValueException("CodiceDestinatario for FPA12 must be a string of 6 characters");
        } elseif (($this->FormatoTrasmissione) && ($this->FormatoTrasmissione == 'FPR12') && (strlen($CodiceDestinatario) !== 7)) {
            throw new InvalidValueException("CodiceDestinatario for FPR12 must be a string of 7 characters");
        }
        $this->CodiceDestinatario = $CodiceDestinatario;
        return $this;
    }

    /**
     * @return string
     */
    public function getPECDestinatario()
    {
        return $this->PECDestinatario;
    }

    /**
     * @param string $PECDestinatario
     * @return DatiTrasmissione
     */
    public function setPECDestinatario($PECDestinatario)
    {
        if ((strlen($PECDestinatario) < 7) && (strlen($PECDestinatario) > 256)) {
            throw new InvalidValueException("PECDestinatario must be a string between 7 and 256 characters");
        }
        $this->PECDestinatario = $PECDestinatario;
        return $this;
    }

    /**
    * @return mixed
    */
    public function getContattiTrasmittente()
    {
        return $this->ContattiTrasmittente;
    }

    /**
     * @param mixed $ContattiTrasmittente
     * @return DatiTrasmissione
     */
    public function setContattiTrasmittente($ContattiTrasmittente)
    {
        $this->ContattiTrasmittente = $ContattiTrasmittente;
        return $this;
    }




}
