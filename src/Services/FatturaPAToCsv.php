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
    protected $currentFilename;
    protected $currentFattura;
    protected $currentBody;

    protected $config;
    protected $csvSet;
    protected $csvType;
    protected $elements;


    protected $separator = ';';
    protected $separatorReplacement = ' - ';
    protected $breakline = "\n";
    protected $decimalPointForExporting = ',';


    public static function factory($fatture = [], $csvType = 'totali', $configFile = null)
    {

        if (is_null($configFile)) {
            $configFile = __DIR__ . '/FatturaPAToCsv/config/fatturapa_to_csv.php';
        }
        if (!file_exists($configFile)) {
            throw new \Exception("Configuration file ".$configFile." not found");
        }
        $config = include_once $configFile;


        if (!is_array($config['types']) || !array_key_exists($csvType,$config['types'])) {
            throw new \InvalidArgumentException("Csv type not defined in configuration");
        }

        if (!array_key_exists('set',$config['types'][$csvType])) {
            throw new \InvalidArgumentException("You must include a 'set' in the csv type definition");
        }


        $csvSet = $config['types'][$csvType]['set'];
        $csvSet = str_replace(' ', '',ucwords(str_replace(['-', '_'], ' ', $csvSet)));

        $className = "\\Robertogallea\\FatturaPA\\Services\\FatturaPAToCsv\\Csv".$csvSet."Set";
        return new $className($fatture,$config,$csvType);

    }

    public function __construct($fatture,$config,$csvType) {
        $this->fatture = $fatture;
        $this->config = $config;
        $this->csvType = $csvType;

        $csvTypeConfiguration = $this->config['types'][$this->csvType];

        if (!array_key_exists('elements',$csvTypeConfiguration) || !is_array($csvTypeConfiguration['elements'])) {
            throw new \InvalidArgumentException("Elements of csv type must be defined and must be an array");
        }

        $this->elements = $csvTypeConfiguration['elements'];

        $this->detailLevel = array_key_exists('detail_level',$csvTypeConfiguration)
            ? $csvTypeConfiguration['detail_level']
            : $this->getDefaultDetailLevel();

    }


    protected function getDefaultDetailLevel() {

        $csvSetComponents = $this->config['sets'][$this->csvSet];

        return last($csvSetComponents);

    }


    protected function getElementMethodName($element) {
        return 'get'.str_replace(' ','',ucwords(str_replace(['.','-', '_'], ' ', $element))).'Element';
    }

    protected function addFatturaRow() {

        $csvRow = "";
        foreach ($this->elements as $element) {

            $methodName = $this->getElementMethodName($element);
            $csvRow .= $this->$methodName() . $this->separator;

        }

        return $csvRow . $this->breakline;

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

            $this->currentFattura = $fattura;

            $csvContent .= $this->addFatturaRows();

        }

        return $csvContent;
    }

    abstract protected function addFatturaRows();

    public function setLabels($labels) {
        $this->config['labels'] = array_merge($this->config['labels'],$labels);
    }

    public function getLabels() {
        return $this->config['labels'];
    }




    protected function setHeaders() {
        $labels = $this->config['labels'];
        $elements = $this->elements;

        $headerLine = "";
        foreach ($elements as $element) {
            if (!array_key_exists($element,$labels)) {
                $label = $element;
            } else {
                $label = $labels[$element];
            }

            $headerLine .= $label . $this->separator;
        }

        return $headerLine . $this->breakline;
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
