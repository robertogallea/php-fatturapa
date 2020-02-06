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

    protected $fatture = [];
    protected $currentFattura;
    protected $currentFilename;
    protected $separator = ';';
    protected $separatorReplacement = ' - ';
    protected $breakline = "\n";
    protected $decimalPointForExporting = ',';

    public static function factory($fatture = [], $csvType = 'riepilogo')
    {

        $csvType = str_replace(' ', '',ucwords(str_replace(['-', '_'], ' ', $csvType)));

        $className = "\\Robertogallea\\FatturaPA\\Services\\FatturaPAToCsv\\Csv".$csvType."Type";
        return new $className($fatture);

    }


    public function getCsvFile($csvFilename, $force = false)
    {

        if (file_exists($csvFilename) && !$force) {
            throw new \Exception($csvFilename . " is already present in the filesystem. Choose another file or use the 'force' option");
        }

        $csvContent = $this->buildCsv();

        $file = fopen($csvFilename, 'w+');
        fwrite($file, $csvContent);
        fclose($file);
    }

    /**
     * @param string $separator
     */
    public function setSeparator(string $separator)
    {
        $this->separator = $separator;
    }

    /**
     * @param string $separatorReplacement
     */
    public function setSeparatorReplacement(string $separatorReplacement)
    {
        $this->separatorReplacement = $separatorReplacement;
    }

    /**
     * @param string $breakline
     */
    public function setBreakline(string $breakline)
    {
        $this->breakline = $breakline;
    }

    /**
     * @param string $decimalPointForExporting
     */
    public function setDecimalPointForExporting(string $decimalPointForExporting)
    {
        $this->decimalPointForExporting = $decimalPointForExporting;
    }


    protected function buildCsv()
    {
        $csvContent = $this->setHeaders();

        foreach ($this->fatture as $fattura) {

            $this->currentFilename = null;
            if (is_string($fattura)) {
                if (!file_exists($fattura)) {
                    throw new \Exception($fattura . " not found.");
                }
                $this->currentFilename = substr($fattura, strrpos($fattura, '/') + 1);
                $fattura = FatturaPA::readFromXML($fattura, '1.2.1');
            }


            if (!($fattura instanceof FatturaBase)) {
                throw new \InvalidArgumentException("Trynig to convert to csv a non-FatturaPA element");
            }

            $csvContent = $this->addFatturaRows($fattura, $csvContent);
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
            'Importo documento' => $this->formatNumbers((float)$datiGeneraliDocumento->getImportoTotaleDocumento()),
            'Arrotondamento documento' => $this->formatNumbers((float)$datiGeneraliDocumento->getArrotondamento()),
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


    protected function calculateDatiRiepilogo($fatturaBodyDatiRiepilogo) {


        /*
         * Esistono fatture (fatte male ma che passano la validazione ministeriale) con riepiloghi iva ripetuti
         * con stessa aliquota....... (tipo fatture di nota compagnia telefonica.....)
         */
        $riepiloghi = [];
        foreach ($fatturaBodyDatiRiepilogo as $fatturaBodyDatoRiepilogo) {
            $imponibile = $fatturaBodyDatoRiepilogo->getImponibileImporto();
            $imposta = $fatturaBodyDatoRiepilogo->getImposta();
            $aliquota = $fatturaBodyDatoRiepilogo->getAliquotaIVA();
            if (!array_key_exists($aliquota,$riepiloghi)) {

                $riepiloghi[$aliquota]['Imponibile'] = (float)$imponibile;
                $riepiloghi[$aliquota]['Imposta'] = (float)$imposta;
                $riepiloghi[$aliquota]['Importo'] = (float)$imponibile + (float)$imposta;
                $riepiloghi[$aliquota]['Arrotondamento'] = (float)$fatturaBodyDatoRiepilogo->Arrotondamento();
            } else {
                $riepiloghi[$aliquota]['Imponibile'] += (float)$imponibile;
                $riepiloghi[$aliquota]['Imposta'] += (float)$imposta;
                $riepiloghi[$aliquota]['Importo'] += (float)$imponibile + (float)$imposta;
                $riepiloghi[$aliquota]['Arrotondamento'] += (float)$fatturaBodyDatoRiepilogo->Arrotondamento();
            }

        }

        return $this->formatNumbers($riepiloghi);

    }


    protected function formatNumbers($var) {
        return filter_var($var, \FILTER_CALLBACK, ['options' => function($el) {
            return number_format($el, 2, $this->decimalPointForExporting, '');
        }]);
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
