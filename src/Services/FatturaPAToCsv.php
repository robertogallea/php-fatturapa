<?php
/**
 * Created by PhpStorm.
 * User: robertogallea
 * Date: 6/13/15
 * Time: 11:35 AM
 */

namespace Robertogallea\FatturaPA\Services;

use Robertogallea\FatturaPA\FatturaPA;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\Anagrafica;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici;
use Robertogallea\FatturaPA\Model\Common\DatiAnagrafici\IdFiscaleIVA;
use Robertogallea\FatturaPA\Model\Common\Sede;
use Robertogallea\FatturaPA\Model\FatturaBase;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\Allegati;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee\AltriDatiGestionali;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee\CodiceArticolo;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DatiRiepilogo;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiBeniServizi\DettaglioLinee;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto\DatiAnagraficiVettore;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento\DatiBollo;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento\DatiCassaPrevidenziale;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiDDT;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiOrdineAcquisto;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiGeneraliDocumento\DatiRitenuta;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiSAL;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\FatturaPrincipale;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiGenerali\DatiTrasporto\IndirizzoResa;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiPagamento;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiPagamento\DettaglioPagamento;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody\DatiVeicoli;
use Robertogallea\FatturaPA\Model\Common\ScontoMaggiorazione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaBody;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore\Contatti;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CedentePrestatore\IscrizioneREA;
use Robertogallea\FatturaPA\Model\Common\StabileOrganizzazione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\CessionarioCommittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione\ContattiTrasmittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\DatiTrasmissione\IdTrasmittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\RappresentanteFiscale;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaElettronicaHeader\TerzoIntermediarioOSoggettoEmittente;
use Robertogallea\FatturaPA\Model\Ordinaria\FatturaOrdinaria;
use Robertogallea\FatturaPA\Services\FatturaPAToCsv\CsvRiepilogoType;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;
use Sabre\Xml\Reader;
use Sabre\Xml\Service;
use Sabre\Xml\Writer;


abstract class FatturaPAToCsv
{

    protected $filenames = [];
    protected $separator = ';';
    protected $separatorReplacement = ' - ';
    protected $breakline = "\n";

    public static function factory($filenames = [], $csvType = 'riepilogo')
    {

        $csvType = str_replace(' ', '',ucwords(str_replace(['-', '_'], ' ', $csvType)));

        $className = "\\Robertogallea\\FatturaPA\\Services\\FatturaPAToCsv\\Csv".$csvType."Type";
        return new $className($filenames);

    }


    public function getCsvFile($filename, $force = false)
    {

        if (file_exists($filename) && !$force) {
            throw new \Exception($filename . " is already present in the filesystem. Choose another file or use the 'force' option");
        }

        $csvContent = $this->buildCsv();

        $file = fopen($filename, 'w+');
        fwrite($file, $csvContent);
        fclose($file);
    }


    protected function buildCsv()
    {
        $csvContent = $this->setHeaders();

        foreach ($this->filenames as $filename) {
            if (!file_exists($filename)) {
                throw new \Exception($filename . " not found.");
            }


            $csvContent = $this->addFatturaRows($filename, $csvContent);
        }

        return $csvContent;
    }

    abstract protected function setHeaders();


    abstract protected function addFatturaRows($filename, $csvContent);


    protected function getFatturaRowsHeader($fattura)
    {

        $cedentePrestatore = $fattura->getFatturaElettronicaHeader()->getCedentePrestatore()->getDatiAnagrafici();
        //$cessonarioCommittente = $fattura->getFatturaElettronicaHeader()->getCessionarioCommittente()->getDatiAnagrafici();

        return [
            'Partita Iva' => $this->getPartitaIva($cedentePrestatore),
            'Denominazione' => $this->getNominativo($cedentePrestatore),
        ];
    }

    protected function getFatturaRowsBodyGenerali($fatturaBody)
    {

        $datiGeneraliDocumento = $fatturaBody->getDatiGenerali()->getDatiGeneraliDocumento();
        $datiRicezione = $fatturaBody->getDatiGenerali()->getDatiRicezione();

        $causale = $this->replaceSeparator($datiGeneraliDocumento->getCausale());


        return [
            'Data ricezione' => $datiRicezione ? $datiRicezione->getData() : '',
            'Data fattura' => $datiGeneraliDocumento->getData(),
            'Numero' => $datiGeneraliDocumento->getNumero(),
            'Causale' => $causale,
            'Importo documento' => $datiGeneraliDocumento->getImportoTotaleDocumento(),
            'Arrotondamento documento' => $datiGeneraliDocumento->getArrotondamento(),
        ];
    }


    protected function getPartitaIva(DatiAnagrafici $datiAnagrafici)
    {
        return $datiAnagrafici->getIdFiscaleIVA()->getIdPaese() . $datiAnagrafici->getIdFiscaleIVA()->getIdCodice();
    }

    protected function getNominativo(DatiAnagrafici $datiAnagrafici)
    {
        $anagrafica = $datiAnagrafici->getAnagrafica();
        return $anagrafica->getDenominazione() ?: $anagrafica->getCognome() . ' ' . $anagrafica->getNome();
    }

    protected function replaceSeparator($part)
    {
        if (is_array($part)) {
            $part = implode($this->separatorReplacement, $part);
        }
        return str_replace($this->separator, $this->separatorReplacement, $part);
    }

    protected function echoPart($part)
    {

        echo '<pre>';
        print_r($part);
        echo '</pre>';

    }


}
